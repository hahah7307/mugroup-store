<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class PriceValidate extends Validate
{
    protected $rule = [
        'length'            =>  'require',
        'width'             =>  'require',
        'height'            =>  'require',
        'gross_weight'      =>  'require',
        'cost'              =>  'require',
        'min_price'         =>  'require',
        'target_pricing'    =>  'require',
        'flp_standard'      =>  'require',
        'tariff_rate'       =>  'require',
        'exchange_rate'     =>  'require',
        'delivery'          =>  'require',
        'ad_rate'           =>  'require',
        'return_rate'       =>  'require',
        'platform_rate'     =>  'require',
        'storage_info'      =>  'require'
    ];

    protected $message = [
        
    ];

    protected $field = [
        'length'            =>  '长度',
        'width'             =>  '宽度',
        'height'            =>  '高度',
        'gross_weight'      =>  '毛重',
        'cost'              =>  '采购成本',
        'min_price'         =>  '最低市场价',
        'target_pricing'    =>  '目标定价',
        'flp_standard'      =>  '头程价格标准',
        'tariff_rate'       =>  '关税率',
        'exchange_rate'     =>  '汇率',
        'delivery'          =>  '派送方式',
        'ad_rate'           =>  '广告费占比',
        'return_rate'       =>  '退货率',
        'platform_rate'     =>  '平台费占比',
        'storage_info'      =>  '核价详情'
    ];

    protected $scene = [
        'save'          =>  ['length', 'width', 'height', 'gross_weight', 'cost', 'min_price', 'target_pricing', 'flp_standard', 'tariff_rate', 'exchange_rate', 'delivery', 'ad_rate', 'return_rate', 'platform_rate', 'storage_info'],
    ];
}
