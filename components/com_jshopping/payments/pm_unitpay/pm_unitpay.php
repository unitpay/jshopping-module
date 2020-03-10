<?php

//защита от прямого доступа
defined('_JEXEC') or die();

class pm_unitpay extends PaymentRoot
{
    //функция подключает языковый файл
    function loadLanguageFile()
    {
        $lang = JFactory::getLanguage();
        $langtag = $lang->getTag(); //определяем текущий язык

        if (file_exists(JPATH_ROOT.'/components/com_jshopping/payments/pm_unitpay/lang/'.$langtag.'.php')) {
            require_once(JPATH_ROOT.'/components/com_jshopping/payments/pm_unitpay/lang/'.$langtag.'.php');
        } else {
            require_once(JPATH_ROOT.'/components/com_jshopping/payments/pm_onpay/lang/en-GB.php'); //если языковый файл не найден, то подключаем en-GB.php
        }
    }

    //функция показывает настройки плагина в админке
    function showAdminFormParams($params)
    {
        $array_params = array('unitpay_domain', 'unitpay_public_key', 'unitpay_secret_key', 'payment_end_status', 'payment_failed_status');

        foreach ($array_params as $key) {
            if (!isset($params[$key])) {
                $params[$key] = '';
            }
        }

        $this->loadLanguageFile(); //подключаем нужный язык

        $orders = JSFactory::getModel("orders");    //нужен для админпарамсформ

        include(dirname(__FILE__).'/adminparamsform.php');
    }

    //функция показывает форму оплаты
    function showEndForm($pmconfigs, $order)
    {
        $domain = $pmconfigs['unitpay_domain'];
        $public_key = $pmconfigs['unitpay_public_key'];
        $secret_key = $pmconfigs['unitpay_secret_key'];
        $sum = $order->order_total;
        $account = $order->order_id;
        $desc = 'Оплата по заказу №' . $order->order_id;
        $signature = hash('sha256', join('{up}', array(
            $account,
            $desc,
            $sum,
            $secret_key
        )));

        //очищаем корзину
        $checkout = JSFactory::getModel('checkoutFinish', 'jshop');
        $checkout->paymentComplete($order->order_id);
        $checkout->clearAllDataCheckout();

        ?>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        </head>
        <body>
        <form name="unitpay" action="https://<?php print $domain;?>/pay/<?php print $public_key;?>" method="get">
            <input type="hidden" name="sum" value="<?php print $sum;?>">
            <input type="hidden" name="account" value="<?php print $account;?>">
            <input type="hidden" name="desc" value="<?php print $desc;?>">
            <input type="hidden" name="signature" value="<?php print $signature;?>">
        </form>
        <?php print _JSHOP_REDIRECT_TO_PAYMENT_PAGE?>
        <br>
        <script type="text/javascript">
            document.forms.unitpay.submit();
        </script>
        </body>
        </html>
        <?php
        die();

    }
}