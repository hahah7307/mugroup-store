<?php

namespace app\Manage\model;

use think\Model;

class PriceModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'price';

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
}
