<?php

//защита от прямого доступа
defined('_JEXEC') or die();

define('_JSHOP_CFG_UNITPAY_DOMAIN', 'DOMAIN');
define('_JSHOP_CFG_UNITPAY_DOMAIN_DESCRIPTION', 'Insert your working domain');
define('_JSHOP_CFG_UNITPAY_PUBLIC_KEY', 'PUBLIC KEY');
define('_JSHOP_CFG_UNITPAY_PUBLIC_KEY_DESCRIPTION', 'Copy PUBLIC KEY from Unitpay page');
define('_JSHOP_CFG_UNITPAY_SECRET_KEY', 'SECRET KEY');
define('_JSHOP_CFG_UNITPAY_SECRET_KEY_DESCRIPTION', 'Copy SECRET KEY from Unitpay page');
define('_JSHOP_UNITPAY_PAYMENT_END', 'Order status to the successful completion of payment');
define('_JSHOP_UNITPAY_PAYMENT_END_DESCRIPTION', 'Select order status, which will setup after successful payments');
define('_JSHOP_UNITPAY_PAYMENT_FAILED', 'Order status to the failed completion of payment');
define('_JSHOP_UNITPAY_PAYMENT_FAILED_DESCRIPTION', 'Select order status, which will setup after unsuccessful payments');