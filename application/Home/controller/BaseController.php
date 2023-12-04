<?php
namespace app\Home\controller;
use app\Home\model\AppTemplate;
use think\Controller;
use think\Config;
use think\Session;
use think\Cookie;

class BaseController extends Controller
{
    public function _initialize()
    {
		parent::_initialize();

		// 模板
		$template = AppTemplate::get(['current' => AppTemplate::CURRENT_ACTIVE, 'status' => AppTemplate::STATUS_ACTIVE]);
		$this->template = $template['mark'];
		$this->view_name = $this->template . '/' . strtolower(request()->controller()) . '/' . request()->action();
    }
}
