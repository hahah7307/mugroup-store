<?php
namespace app\Manage\controller;

use app\Manage\model\AHS;
use app\Manage\model\DeliverFeeModel;
use app\Manage\model\StorageRuleModel;
use app\Manage\model\PriceModel;
use app\Manage\validate\PriceValidate;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Fill;
use think\Controller;
use think\Exception;
use think\exception\DbException;
use think\Session;
use think\Config;

class PriceController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['title'] = ['like', '%' . $keyword . '%'];
        }

        // 核价列表
        $list = new PriceModel;
        $list = PriceModel::where($where)->order('id '.$sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');

        return view();
    }

    // 添加

    /**
     * @throws DbException
     */
    public function add()
    {
        $length = input('length');
        $width = input('width');
        $height = input('height');
        $tariff_rate = input('tariff_rate', 0.25);
        $gross_weight = input('gross_weight', 1);
        $delivery = input('delivery', 'FBM');
        $exchange_rate = input('exchange_rate', 6.95);
        $flp_standard = input('flp_standard', 500);
        $cost = input('cost', 0);
        $min_price = input('min_price', 0);
        $target_pricing = input('target_pricing', 0);
        $ad_rate = input('ad_rate', 0.1);
        $return_rate = input('return_rate', 0.05);
        $platform_rate = input('platform_rate', 0.15);

        // volume
        $volume = round($length * $width * $height / 1000000, 4);
        $this->assign('volume', $volume);

        // lbs
        $gross_weight_lbs = ceil($gross_weight * Config::get('kg_pound'));
        $this->assign('gross_weight_lbs', $gross_weight_lbs);

        $volume_lbs = ceil($length * $width * $height / Config::get('density_fraction'));
        $this->assign('volume_lbs', $volume_lbs);

        // loading qty
        $loading_qty = round(Config::get('container_volume') / $volume, 2);
        $this->assign('loading_qty', $loading_qty);

        // fob
        $fob = round($cost / $exchange_rate, 2);
        $this->assign('fob', $fob);

        // initial_cost
        $initial_cost = round($flp_standard / $exchange_rate * $volume, 2);
        $this->assign('initial_cost', $initial_cost);

        // initial_cost_rate
        $initial_cost_rate = round($initial_cost / $target_pricing, 4);
        $this->assign('initial_cost_rate', $initial_cost_rate);

        // tariff
        $tariff = round($fob * 0.7 * $tariff_rate, 2);
        $this->assign('tariff', $tariff);

        // tariff_proportion
        $tariff_proportion = round($tariff / $target_pricing, 4);
        $this->assign('tariff_proportion', $tariff_proportion);

        // storage_charge
        $liang_storage_charge = round(30 * 0.3 * $volume + 90 * 0.4 * $volume, 2);
        $this->assign('liang_storage_charge', $liang_storage_charge);
        $loctek_storage_charge = round(30 * 0.3 * $volume + 60 * 0.5 * $volume, 2);
        $this->assign('loctek_storage_charge', $loctek_storage_charge);

        // storage_charge_proportion
        $liang_storage_charge_proportion = round($liang_storage_charge / $target_pricing, 4);
        $this->assign('liang_storage_charge_proportion', $liang_storage_charge_proportion);
        $loctek_storage_charge_proportion = round($loctek_storage_charge / $target_pricing, 4);
        $this->assign('loctek_storage_charge_proportion', $loctek_storage_charge_proportion);

        // tail_end
        $w = max($gross_weight_lbs, $volume_lbs);
        $liang_outbound = StorageRuleModel::w2outbound(1, $w);
        $liang_deliver_fee = DeliverFeeModel::w2deliverFee(1, $w);
        $liang_ahs_fee = AHS::AHSFeeLiang($w, $length, $width, $height);
        $liang_tail_end = round(300 / $loading_qty + $liang_outbound + ($liang_deliver_fee + 2.71 + $liang_ahs_fee['basicFee'] + $liang_ahs_fee['additionalFee']) * 1.18 + 3, 2);
        $this->assign('liang_tail_end_count', "300 / " . $loading_qty . " + " . $liang_outbound . " + (" . $liang_deliver_fee . " + 2.71 + " . $liang_ahs_fee['basicFee'] . " + " . $liang_ahs_fee['additionalFee'] . ") * 1.18 + 3");
        $this->assign('liang_tail_end', $liang_tail_end);

        $loctek_outbound = StorageRuleModel::w2outbound(2, $w);
        $loctek_deliver_fee = DeliverFeeModel::w2deliverFee(2, $w);
        $loctek_ahs_fee = AHS::AHSFeeLoctek($w, $length, $width, $height);
        $loctek_tail_end = round(400 / $loading_qty + $loctek_outbound + ($loctek_deliver_fee + 2.8 + $loctek_ahs_fee['basicFee'] + $loctek_ahs_fee['additionalFee']) * 1.18 + 3, 2);
        $this->assign('loctek_tail_end_count', "400 / " . $loading_qty . " + " . $loctek_outbound . " + (" . $loctek_deliver_fee . " + 2.8 + " . $loctek_ahs_fee['basicFee'] . " + " . $loctek_ahs_fee['additionalFee'] . ") * 1.18 + 3");
        $this->assign('loctek_tail_end', $loctek_tail_end);

        // tail_end_proportion
        $liang_tail_end_proportion = round($liang_tail_end / $target_pricing, 4);
        $this->assign('liang_tail_end_proportion', $liang_tail_end_proportion);
        $loctek_tail_end_proportion = round($loctek_tail_end / $target_pricing, 4);
        $this->assign('loctek_tail_end_proportion', $loctek_tail_end_proportion);

        // advertising_expenses
        $advertising_expenses = round($target_pricing * $ad_rate, 4);
        $this->assign('advertising_expenses', $advertising_expenses);

        // return_rate
        $return_fee = round($target_pricing * $return_rate, 2);
        $this->assign('return_fee', $return_fee);

        // platform_fees
        $platform_fees = round($target_pricing * $platform_rate, 2);
        $this->assign('platform_fees', $platform_fees);

        // no_profit_price
        $liang_no_profit_price = round(($fob + $initial_cost + $tariff + $liang_storage_charge + $liang_tail_end) / (1 - $ad_rate - $return_rate - $platform_rate), 2);
        $this->assign('liang_no_profit_price', $liang_no_profit_price);
        $loctek_no_profit_price = round(($fob + $initial_cost + $tariff + $loctek_storage_charge + $loctek_tail_end) / (1 - $ad_rate - $return_rate - $platform_rate), 2);
        $this->assign('loctek_no_profit_price', $loctek_no_profit_price);

        // min_selling_profit
        $liang_min_selling_profit = round($min_price - $fob - $initial_cost - $tariff - $liang_storage_charge - $liang_tail_end - $min_price * 0.3, 2);
        $this->assign('liang_min_selling_profit', $liang_min_selling_profit);
        $loctek_min_selling_profit = round($min_price - $fob - $initial_cost - $tariff - $loctek_storage_charge - $loctek_tail_end - $min_price * 0.3, 2);
        $this->assign('loctek_min_selling_profit', $loctek_min_selling_profit);

        // min_selling_profit_rate
        $liang_min_selling_profit_rate = round($liang_min_selling_profit / $min_price, 4);
        $this->assign('liang_min_selling_profit_rate', $liang_min_selling_profit_rate);
        $loctek_min_selling_profit_rate = round($loctek_min_selling_profit / $min_price, 4);
        $this->assign('loctek_min_selling_profit_rate', $loctek_min_selling_profit_rate);

        // target_pricing_profit
        $liang_target_pricing_profit = round($target_pricing - $fob - $initial_cost - $tariff - $liang_storage_charge - $liang_tail_end - $advertising_expenses - $return_fee - $platform_fees, 2);
        $this->assign('liang_target_pricing_profit', $liang_target_pricing_profit);
        $loctek_target_pricing_profit = round($target_pricing - $fob - $initial_cost - $tariff - $loctek_storage_charge - $loctek_tail_end - $advertising_expenses - $return_fee - $platform_fees, 2);
        $this->assign('loctek_target_pricing_profit', $loctek_target_pricing_profit);

        // target_pricing_profit_rate
        $liang_target_pricing_profit_rate = round($liang_target_pricing_profit / $target_pricing, 4);
        $this->assign('liang_target_pricing_profit_rate', $liang_target_pricing_profit_rate);
        $loctek_target_pricing_profit_rate = round($loctek_target_pricing_profit / $target_pricing, 4);
        $this->assign('loctek_target_pricing_profit_rate', $loctek_target_pricing_profit_rate);

        // excel data
        $data = [
            'length'            =>  $length,
            'width'             =>  $width,
            'height'            =>  $height,
            'tariff_rate'       =>  $tariff_rate,
            'gross_weight'      =>  $gross_weight,
            'delivery'          =>  $delivery,
            'exchange_rate'     =>  $exchange_rate,
            'flp_standard'      =>  $flp_standard,
            'cost'              =>  $cost,
            'min_price'         =>  $min_price,
            'target_pricing'    =>  $target_pricing,
            'ad_rate'           =>  $ad_rate,
            'return_rate'       =>  $return_rate,
            'platform_rate'     =>  $platform_rate,
        ];
        $data['storage'][] = [
            'storage_name'  => '一号仓',
            'data'          =>  [
                'volume'                        =>  $volume,
                'gross_weight_lbs'              =>  $gross_weight_lbs,
                'volume_lbs'                    =>  $volume_lbs,
                'loading_qty'                   =>  $loading_qty,
                'fob'                           =>  $fob,
                'initial_cost'                  =>  $initial_cost,
                'initial_cost_rate'             =>  $initial_cost_rate,
                'tariff'                        =>  $tariff,
                'tariff_proportion'             =>  $tariff_proportion,
                'storage_charge'                =>  $liang_storage_charge,
                'storage_charge_proportion'     =>  $liang_storage_charge_proportion,
                'tail_end'                      =>  $liang_tail_end,
                'tail_end_proportion'           =>  $liang_tail_end_proportion,
                'advertising_expenses'          =>  $advertising_expenses,
                'return_fee'                    =>  $return_fee,
                'platform_fees'                 =>  $platform_fees,
                'no_profit_price'               =>  $liang_no_profit_price,
                'min_selling_profit'            =>  $liang_min_selling_profit,
                'min_selling_profit_rate'       =>  $liang_min_selling_profit_rate,
                'target_pricing_profit'         =>  $liang_target_pricing_profit,
                'target_pricing_profit_rate'    =>  $liang_target_pricing_profit_rate
            ]
        ];
        $data['storage'][] = [
            'storage_name'  =>  '二号仓',
            'data'          =>  [
                'volume'                        =>  $volume,
                'gross_weight_lbs'              =>  $gross_weight_lbs,
                'volume_lbs'                    =>  $volume_lbs,
                'loading_qty'                   =>  $loading_qty,
                'fob'                           =>  $fob,
                'initial_cost'                  =>  $initial_cost,
                'initial_cost_rate'             =>  $initial_cost_rate,
                'tariff'                        =>  $tariff,
                'tariff_proportion'             =>  $tariff_proportion,
                'storage_charge'                =>  $loctek_storage_charge,
                'storage_charge_proportion'     =>  $loctek_storage_charge_proportion,
                'tail_end'                      =>  $loctek_tail_end,
                'tail_end_proportion'           =>  $loctek_tail_end_proportion,
                'advertising_expenses'          =>  $advertising_expenses,
                'return_fee'                    =>  $return_fee,
                'platform_fees'                 =>  $platform_fees,
                'no_profit_price'               =>  $loctek_no_profit_price,
                'min_selling_profit'            =>  $loctek_min_selling_profit,
                'min_selling_profit_rate'       =>  $loctek_min_selling_profit_rate,
                'target_pricing_profit'         =>  $loctek_target_pricing_profit,
                'target_pricing_profit_rate'    =>  $loctek_target_pricing_profit_rate
            ]
        ];
        $jsonData = json_encode($data);
        $this->assign('jsonData', $jsonData);

        if (!empty($_GET)) {
            $this->assign('show_reason', 1);
        }

        return view();
    }

    // 保存
    public function save()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['storage_info'] = json_encode($post['data']);

            //
            $dataValidate = new PriceValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new PriceModel();
                if ($model->allowField(true)->save($post)) {
                    echo json_encode(['code' => 1, 'msg' => '添加成功']);
                    exit;
                } else {
                    echo json_encode(['code' => 0, 'msg' => '添加失败，请重试']);
                    exit;
                }
            } else {
                echo json_encode(['code' => 0, 'msg' => $dataValidate->getError()]);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    /**
     * @throws DbException
     * @throws Exception
     */
    public function info($id)
    {
        $info = PriceModel::get(['id' => $id, 'state' => PriceModel::STATUS_ACTIVE]);
        $info['storage_info'] = json_decode(json_decode($info['storage_info']), true);

        $this->assign('info', $info);
        return view();
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $block = PriceModel::get($post['id']);
            if ($block->delete()) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 校验三边长度
    public function ajaxLengthRule() {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $length = $this->request->post('length');
            $width = $this->request->post('width');
            $height = $this->request->post('height');
            if (!empty($length) && !empty($width) && !empty($height)) {
                if (!is_numeric($length) || !is_numeric($width) || !is_numeric($height)) {
                    echo json_encode(['code' => 2, 'info' => '请输入正确的数字！']);
                    exit;
                }
                $arr = [$length, $width, $height];
                $maxLength = max($arr);
                // verify max length
                if ($maxLength >= Config::get('min_3leng')) {
                    echo json_encode(['code' => 2, 'info' => '最长边不得超过' . Config::get('min_3leng') . 'cm！']);
                    exit;
                }
                // verify volume
                $volume = 0;
                $isMax = 0;
                foreach ($arr as $value) {
                    if ($value == $maxLength && $isMax == 0) {
                        $volume += $maxLength;
                        $isMax ++;
                    } else {
                        $volume += 2 * $value;
                    }
                }
                if ($volume >= Config::get('min_5leng')) {
                    echo json_encode(['code' => 2, 'info' => '最长边与其他边的两倍之和为' . $volume . 'cm超过' . Config::get('min_5leng') . 'cm！']);
                    exit;
                }
                echo json_encode(['code' => 1, 'info' => 'success']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'info' => 'Incomplete data']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => 'Abnormal operation']);
            exit;
        }
    }

    /**
     * @throws \PHPExcel_Exception
     */
    public function excel()
    {
        $data = input('data');
        $dataArr = json_decode($data, true);
//        echo "<pre>";var_dump($dataArr);exit;

        // phpexcel
        require_once './static/classes/PHPExcel/Classes/PHPExcel.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

//        // Set properties
//        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
//            ->setLastModifiedBy("Maarten Balliauw")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
//        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        // Set background color
        // A1 - Z1
        for ($s = 65; $s <= 90; $s ++) {
            $objPHPExcel->getActiveSheet()->getStyle(chr($s) . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
        }
        // AA1 - AL1
        for ($s = 65; $s <= 76; $s ++) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . chr($s) . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDD7EE');
        }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '仓库')
            ->setCellValue('B1', '产品名称')
            ->setCellValue('C1', '关税率')
            ->setCellValue('D1', '包装长cm')
            ->setCellValue('E1', '包装宽cm')
            ->setCellValue('F1', '包装高cm')
            ->setCellValue('G1', '毛重kg')
            ->setCellValue('H1', '派送方式')
            ->setCellValue('I1', '汇率')
            ->setCellValue('J1', '头程价格标准(元/CBM)')
            ->setCellValue('K1', '采购成本')
            ->setCellValue('L1', '最低市场售价')
            ->setCellValue('M1', '目标定价')
            ->setCellValue('N1', '广告费占比')
            ->setCellValue('O1', '退货率')
            ->setCellValue('P1', '平台费占比')

            ->setCellValue('Q1', '体积m3')
            ->setCellValue('R1', '毛重lbs')
            ->setCellValue('S1', '体积重LBS')
            ->setCellValue('T1', '装箱数')
            ->setCellValue('U1', '装柜数')
            ->setCellValue('V1', 'FOB成本')
            ->setCellValue('W1', '头程成本')
            ->setCellValue('X1', '头程成本占比')
            ->setCellValue('Y1', '关税')
            ->setCellValue('Z1', '关税占比')
            ->setCellValue('AA1', '4个月仓储费')
            ->setCellValue('AB1', '仓储费占比')
            ->setCellValue('AC1', '尾程')
            ->setCellValue('AD1', '尾程占比')
            ->setCellValue('AE1', '广告费')
            ->setCellValue('AF1', '退货费')
            ->setCellValue('AG1', '平台费')
            ->setCellValue('AH1', '0利润售价')
            ->setCellValue('AI1', '最低售价利润')
            ->setCellValue('AJ1', '最低售价利润率')
            ->setCellValue('AK1', '目标定价利润')
            ->setCellValue('AL1', '目标定价利润率')
        ;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', $dataArr['storage'][0]['storage_name'])
            ->setCellValue('B2', '')
            ->setCellValue('C2', $dataArr['tariff_rate'])
            ->setCellValue('D2', $dataArr['length'])
            ->setCellValue('E2', $dataArr['width'])
            ->setCellValue('F2', $dataArr['height'])
            ->setCellValue('G2', $dataArr['gross_weight'])
            ->setCellValue('H2', $dataArr['delivery'])
            ->setCellValue('I2', $dataArr['exchange_rate'])
            ->setCellValue('J2', $dataArr['flp_standard'])
            ->setCellValue('K2', $dataArr['cost'])
            ->setCellValue('L2', $dataArr['min_price'])
            ->setCellValue('M2', $dataArr['target_pricing'])
            ->setCellValue('N2', $dataArr['ad_rate'])
            ->setCellValue('O2', $dataArr['return_rate'])
            ->setCellValue('P2', $dataArr['platform_rate'])

            ->setCellValue('Q2', $dataArr['storage'][0]['data']['volume'])
            ->setCellValue('R2', $dataArr['storage'][0]['data']['gross_weight_lbs'])
            ->setCellValue('S2', $dataArr['storage'][0]['data']['volume_lbs'])
            ->setCellValue('T2', 1)
            ->setCellValue('U2', $dataArr['storage'][0]['data']['loading_qty'])
            ->setCellValue('V2', $dataArr['storage'][0]['data']['fob'])
            ->setCellValue('W2', $dataArr['storage'][0]['data']['initial_cost'])
            ->setCellValue('X2', $dataArr['storage'][0]['data']['initial_cost_rate'])
            ->setCellValue('Y2', $dataArr['storage'][0]['data']['tariff'])
            ->setCellValue('Z2', $dataArr['storage'][0]['data']['tariff_proportion'])
            ->setCellValue('AA2', $dataArr['storage'][0]['data']['storage_charge'])
            ->setCellValue('AB2', $dataArr['storage'][0]['data']['storage_charge_proportion'])
            ->setCellValue('AC2', $dataArr['storage'][0]['data']['tail_end'])
            ->setCellValue('AD2', $dataArr['storage'][0]['data']['tail_end_proportion'])
            ->setCellValue('AE2', $dataArr['storage'][0]['data']['advertising_expenses'])
            ->setCellValue('AF2', $dataArr['storage'][0]['data']['return_fee'])
            ->setCellValue('AG2', $dataArr['storage'][0]['data']['platform_fees'])
            ->setCellValue('AH2', $dataArr['storage'][0]['data']['no_profit_price'])
            ->setCellValue('AI2', $dataArr['storage'][0]['data']['min_selling_profit'])
            ->setCellValue('AJ2', $dataArr['storage'][0]['data']['min_selling_profit_rate'])
            ->setCellValue('AK2', $dataArr['storage'][0]['data']['target_pricing_profit'])
            ->setCellValue('AL2', $dataArr['storage'][0]['data']['target_pricing_profit_rate'])
        ;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', $dataArr['storage'][1]['storage_name'])
            ->setCellValue('B3', '')
            ->setCellValue('C3', $dataArr['tariff_rate'])
            ->setCellValue('D3', $dataArr['length'])
            ->setCellValue('E3', $dataArr['width'])
            ->setCellValue('F3', $dataArr['height'])
            ->setCellValue('G3', $dataArr['gross_weight'])
            ->setCellValue('H3', $dataArr['delivery'])
            ->setCellValue('I3', $dataArr['exchange_rate'])
            ->setCellValue('J3', $dataArr['flp_standard'])
            ->setCellValue('K3', $dataArr['cost'])
            ->setCellValue('L3', $dataArr['min_price'])
            ->setCellValue('M3', $dataArr['target_pricing'])
            ->setCellValue('N3', $dataArr['ad_rate'])
            ->setCellValue('O3', $dataArr['return_rate'])
            ->setCellValue('P3', $dataArr['platform_rate'])

            ->setCellValue('Q3', $dataArr['storage'][1]['data']['volume'])
            ->setCellValue('R3', $dataArr['storage'][1]['data']['gross_weight_lbs'])
            ->setCellValue('S3', $dataArr['storage'][1]['data']['volume_lbs'])
            ->setCellValue('T3', 1)
            ->setCellValue('U3', $dataArr['storage'][1]['data']['loading_qty'])
            ->setCellValue('V3', $dataArr['storage'][1]['data']['fob'])
            ->setCellValue('W3', $dataArr['storage'][1]['data']['initial_cost'])
            ->setCellValue('X3', $dataArr['storage'][1]['data']['initial_cost_rate'])
            ->setCellValue('Y3', $dataArr['storage'][1]['data']['tariff'])
            ->setCellValue('Z3', $dataArr['storage'][1]['data']['tariff_proportion'])
            ->setCellValue('AA3', $dataArr['storage'][1]['data']['storage_charge'])
            ->setCellValue('AB3', $dataArr['storage'][1]['data']['storage_charge_proportion'])
            ->setCellValue('AC3', $dataArr['storage'][1]['data']['tail_end'])
            ->setCellValue('AD3', $dataArr['storage'][1]['data']['tail_end_proportion'])
            ->setCellValue('AE3', $dataArr['storage'][1]['data']['advertising_expenses'])
            ->setCellValue('AF3', $dataArr['storage'][1]['data']['return_fee'])
            ->setCellValue('AG3', $dataArr['storage'][1]['data']['platform_fees'])
            ->setCellValue('AH3', $dataArr['storage'][1]['data']['no_profit_price'])
            ->setCellValue('AI3', $dataArr['storage'][1]['data']['min_selling_profit'])
            ->setCellValue('AJ3', $dataArr['storage'][1]['data']['min_selling_profit_rate'])
            ->setCellValue('AK3', $dataArr['storage'][1]['data']['target_pricing_profit'])
            ->setCellValue('AL3', $dataArr['storage'][1]['data']['target_pricing_profit_rate'])
        ;

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('核价模板');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        $filename = date("YmdHis") . time() . mt_rand(100000, 999999);
        ob_end_clean();
        header('Content-Disposition:attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
