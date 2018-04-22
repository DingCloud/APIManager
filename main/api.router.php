<?php
require_once(dirname(__FILE__).'/api.class.php');
require_once(dirname(__FILE__).'/httpclient.class.php');

if (!session_id()) {
    session_start();
}

if (!isset($_REQUEST['format'])) {
    header('Content-Type: text/plain; Charset=UTF-8');
    die('API初始化失败，没有设置有效的输出格式。请检查format参数是否正确传入！');
}
else if (!isset($_REQUEST['mod'])) {
    header('Content-Type: text/plain; Charset=UTF-8');
    die('API初始化失败，没有设置有效的模块。请检查mod参数是否正确传入！');
}

switch ($_REQUEST['format']) {
    case 'json':
    $response = Response::getInstance('json');
    break;
    case 'xml':
    $response = Response::getInstance('xml');
    break;
    case 'other':
    $response = Response::getInstance('null');
    break;
    default:
    Response::getInstance('null')->errorHandler(405, '抱歉，请指定一个有效且受系统支持的数据输出格式。');
    break;
}
$plugin_Path = dirname(__FILE__).'/plugins/'.$_REQUEST['mod'].'.plugin.php'; //构造插件路径
if (!file_exists($plugin_Path)) {
    $response->make(404, '找不到对应模块，请检查mod是否输入正确或是否正确的完成了模块安装！', array('filename'=>$_REQUEST['mod'].'.plugin.php','plugin_id'=>sha1($_REQUEST['mod'])));
}
require_once($plugin_Path);
$pluginApp = new $_REQUEST['mod']();
if (!method_exists($pluginApp, 'init')) {
    $response->make(400, '您所访问的模块不符合开发规范，请联系开发者。如果您是开发者，请参照平台开发标准整改该类库。技术细节简述：类库缺少入口函数init，平台无法调用。', array('filename'=>$_REQUEST['mod'].'.plugin.php','plugin_id'=>sha1($_REQUEST['mod'])));
}
$result = $pluginApp->init();
$response->make(200, 'success', $result);