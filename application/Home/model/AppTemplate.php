<?php

namespace app\Home\model;

use think\Model;
use think\Session;

class AppTemplate extends Model
{
    const STATUS_ACTIVE = 1;
    const CURRENT_ACTIVE = 1;

    protected $name = 'app_template';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setUpdatedAtAttr()
    {
        return time();
    }

    // 获取当前默认模板
    static public function current_template_name()
    {
        $template = self::get(['status' => self::STATUS_ACTIVE, 'current' => self::CURRENT_ACTIVE]);
        return $template->title;
    }
}
