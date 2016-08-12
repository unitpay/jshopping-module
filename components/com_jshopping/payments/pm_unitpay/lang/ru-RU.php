<?php

//защита от прямого доступа
defined('_JEXEC') or die();

define('_JSHOP_CFG_UNITPAY_PUBLIC_KEY', 'PUBLIC KEY');
define('_JSHOP_CFG_UNITPAY_PUBLIC_KEY_DESCRIPTION', 'Скопируйте PUBLIC KEY со страницы проекта в системе Unitpay');
define('_JSHOP_CFG_UNITPAY_SECRET_KEY', 'SECRET KEY');
define('_JSHOP_CFG_UNITPAY_SECRET_KEY_DESCRIPTION', 'Скопируйте SECRET KEY со страницы проекта в системе Unitpay');
define('_JSHOP_UNITPAY_PAYMENT_END', 'Статус заказа для успешной оплаты');
define('_JSHOP_UNITPAY_PAYMENT_END_DESCRIPTION', 'Выберите статус заказа, который будет установлен в случае если оплата прошла успешно');
define('_JSHOP_UNITPAY_PAYMENT_FAILED', 'Статус заказа для неудачной оплаты');
define('_JSHOP_UNITPAY_PAYMENT_FAILED_DESCRIPTION', 'Выберите статус заказа, который будет установлен в случае если оплата прошла неудачно');
