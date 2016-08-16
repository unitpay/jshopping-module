<?php


define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
$option='com_jshopping';
$my_path = dirname(__FILE__);
$my_path = explode(DS.'components',$my_path);
$my_path = $my_path[0];
if (file_exists($my_path . '/defines.php'))
    include_once $my_path . '/defines.php';

if (!defined('_JDEFINES'))
{
    define('JPATH_BASE', $my_path);
    require_once JPATH_BASE.'/includes/defines.php';
}

define('JPATH_COMPONENT',				JPATH_BASE . '/components/' . $option);
define('JPATH_COMPONENT_SITE',			JPATH_SITE . '/components/' . $option);
define('JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR . '/components/' . $option);

require_once JPATH_BASE.'/includes/framework.php';
$app = JFactory::getApplication('site');
$app->initialise();

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
jimport('joomla.application.component.model');

require_once (JPATH_COMPONENT_SITE."/lib/factory.php");
require_once (JPATH_COMPONENT_SITE.'/lib/functions.php');
include_once(JPATH_COMPONENT_SITE."/controllers/checkout.php");


header('Content-type:application/json;  charset=utf-8');
$method = '';
$params = [];
$result = [];
if ((isset($_GET['params'])) && (isset($_GET['method'])) && (isset($_GET['params']['signature']))){
    $params = $_GET['params'];
    $method = $_GET['method'];
    $signature = $params['signature'];
    if (empty($signature) ){
        $status_sign = false;
    }else{
        $order_id = $params['account'];
        $order = &JTable::getInstance('order', 'jshop');
        $order->load($order_id);

        if (is_null($order->order_id)){
            $result = array('error' =>
                array('message' => 'заказа не существует')
            );
        }else{
            $pm_method = &JTable::getInstance('paymentMethod', 'jshop');
            $pm_method->load($order->payment_method_id);
            $pmconfigs = $pm_method->getConfigs();
            $secret_key = $pmconfigs['unitpay_secret_key'];
            $status_sign = verifySignature($params, $method, $secret_key);
        }


    }
}else{
    $status_sign = false;
}

//$status_sign = true;

if ($status_sign){
    switch ($method) {
        case 'check':
            $result = check( $params );
            break;
        case 'pay':
            $result = payment( $params );
            break;
        case 'error':
            $result = error( $params );
            break;
        default:
            $result = array('error' =>
                array('message' => 'неверный метод')
            );
            break;
    }
}else{
    $result = array('error' =>
        array('message' => 'неверная сигнатура')
    );
}
echo json_encode($result);
die();






function verifySignature($params, $method, $secret)
{
    return $params['signature'] == getSignature($method, $params, $secret);
}
function getSignature($method, array $params, $secretKey)
{
    ksort($params);
    unset($params['sign']);
    unset($params['signature']);
    array_push($params, $secretKey);
    array_unshift($params, $method);
    return hash('sha256', join('{up}', $params));
}

function check( $params )
{
    $order_id = $params['account'];
    $order = &JTable::getInstance('order', 'jshop');
    $order->load($order_id);

    if (empty($order->order_id)){
        $result = array('error' =>
            array('message' => 'заказа не существует')
        );
    }elseif ((float)$order->order_total != (float)$params['orderSum']) {
        $result = array('error' =>
            array('message' => 'не совпадает сумма заказа')
        );
    }elseif ($order->currency_code_iso != $params['orderCurrency']) {
        $result = array('error' =>
            array('message' => 'не совпадает валюта заказа')
        );
    }
    else{
        $result = array('result' =>
            array('message' => 'Запрос успешно обработан')
        );
    }
    return $result;
}
function payment( $params )
{
    $order_id = $params['account'];
    $order = &JTable::getInstance('order', 'jshop');
    $order->load($order_id);

    if (empty($order->order_id)){
        $result = array('error' =>
            array('message' => 'заказа не существует')
        );
    }elseif ((float)$order->order_total != (float)$params['orderSum']) {
        $result = array('error' =>
            array('message' => 'не совпадает сумма заказа')
        );
    }elseif ($order->currency_code_iso != $params['orderCurrency']) {
        $result = array('error' =>
            array('message' => 'не совпадает валюта заказа')
        );
    }
    else{

        $pm_method = &JTable::getInstance('paymentMethod', 'jshop');
        $pm_method->load($order->payment_method_id);
        $pmconfigs = $pm_method->getConfigs();
        $status = $pmconfigs['payment_end_status'];

        $order->order_created = 1;
        $order->order_status = $status;

        $order->store();


        $result = array('result' =>
            array('message' => 'Запрос успешно обработан')
        );
    }
    return $result;
}


function error( $params )
{
    $order_id = $params['account'];
    $order = &JTable::getInstance('order', 'jshop');
    $order->load($order_id);

    if (empty($order->order_id)){
        $result = array('error' =>
            array('message' => 'заказа не существует')
        );
    }
    else{
        $pm_method = &JTable::getInstance('paymentMethod', 'jshop');
        $pm_method->load($order->payment_method_id);
        $pmconfigs = $pm_method->getConfigs();
        $status = $pmconfigs['payment_failed_status'];

        $order->order_created = 1;
        $order->order_status = $status;
        $order->store();
        $result = array('result' =>
            array('message' => 'Запрос успешно обработан')
        );
    }
    return $result;
}