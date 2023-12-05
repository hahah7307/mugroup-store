<?php

namespace app\Manage\model;

use think\Config;
use think\Model;

class StoreModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'store';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return date('Y-m-d H:i:s');
    }

    protected function setUpdatedAtAttr()
    {
        return date('Y-m-d H:i:s');
    }

    static public function formatPostData($post)
    {
        $arr['query_date'] = $post['query_date'];
        $arr['product_name'] = $post['product_name'];
        $arr['product_sku'] = $post['product_sku'];
        $arr['sale_info'] = array_combine($post['month'], $post['sale']);
        $arr['w_info'] = [
            'basic_store'   =>  $post['w_basic_store'],
            'deliver'       =>  array_combine($post['w_deliver_date'], $post['w_deliver_num'])
        ];
        $arr['e_info'] = [
            'basic_store'   =>  $post['e_basic_store'],
            'deliver'       =>  array_combine($post['e_deliver_date'], $post['e_deliver_num'])
        ];

        return $arr;
    }

    static public function getStoreData($formatPostData, $data = [])
    {
        if (!empty($data)) {
            $array = array_keys($data['w']);
            $ymd = end($array);
            $ym = date('Ym', strtotime($ymd));
            $sale = $formatPostData['sale_info'][$ym];
            $w_sale = floor($sale * Config::get('W_SALE_PROPORTION'));
            $e_sale = $sale - $w_sale;

            $current_date = date('Ymd', strtotime($ymd) + 24 * 60 * 60);
            $current_date_format = date('Y-m-d', strtotime($ymd) + 24 * 60 * 60);
            $w_new_store = isset($formatPostData['w_info']['deliver'][$current_date_format]) ? $formatPostData['w_info']['deliver'][$current_date_format] : 0;
            $e_new_store = isset($formatPostData['e_info']['deliver'][$current_date_format]) ? $formatPostData['e_info']['deliver'][$current_date_format] : 0;

            // 整理返回数据
            $w_store = max($data['w'][$ymd] + $w_new_store - $w_sale, 0);
            $e_store = max($data['e'][$ymd] + $e_new_store - $e_sale, 0);
            $data['w'][$current_date] = $w_store;
            $data['e'][$current_date] = $e_store;

            // 获取两个仓库送货的最后一天
            $w_date_list = array_keys($formatPostData['w_info']['deliver']);
            $w_last_date = end($w_date_list);
            $e_date_list = array_keys($formatPostData['e_info']['deliver']);
            $e_last_date = end($e_date_list);

            // 判断是否已没货和卖完
            if ($w_store == 0 && $e_store == 0 && $current_date >= date('Ymd', strtotime($w_last_date)) && $current_date >= date('Ymd', strtotime($e_last_date))) {
                return $data;
            } else {
                return self::getStoreData($formatPostData, $data);
            }
        } else {
            $ymd = date('Ymd', strtotime($formatPostData['query_date']));
            $data = [
                'w' => [$ymd => intval($formatPostData['w_info']['basic_store'])],
                'e' => [$ymd => intval($formatPostData['e_info']['basic_store'])]
            ];

//            $ym = date('Ym', strtotime($ymd));
//            $sale = $formatPostData['sale_info'][$ym];
//            var_dump($sale);
//            $w_sale = floor($sale * Config::get('W_SALE_PROPORTION'));
//            var_dump($w_sale);
//            $e_sale = $sale - $w_sale;
//
//            $current_date_format = date('Y-m-d', strtotime($ymd));
//            $w_new_store = isset($formatPostData['w_info']['deliver'][$current_date_format]) ? $formatPostData['w_info']['deliver'][$current_date_format] : 0;
//            $e_new_store = isset($formatPostData['e_info']['deliver'][$current_date_format]) ? $formatPostData['e_info']['deliver'][$current_date_format] : 0;
//
//            $data = [
//                'w' => [$ymd => max($formatPostData['w_info']['basic_store'] + $w_new_store - $w_sale, 0)],
//                'e' => [$ymd => max($formatPostData['e_info']['basic_store'] + $e_new_store - $e_sale, 0)]
//            ];
            return self::getStoreData($formatPostData, $data);
        }
    }
}
