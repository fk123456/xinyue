<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

$uri = $_SERVER["REQUEST_URI"];
// 真实存在的文件（静态资源、install/index.php 等）直接返回
$file = $_SERVER["DOCUMENT_ROOT"] . parse_url($uri, PHP_URL_PATH);
if (is_file($file)) {
    return false;
}
// 其余请求交给 ThinkPHP 路由
$_SERVER["SCRIPT_FILENAME"] = __DIR__ . '/index.php';
$_SERVER["SCRIPT_NAME"] = '/index.php';
require __DIR__ . "/index.php";
