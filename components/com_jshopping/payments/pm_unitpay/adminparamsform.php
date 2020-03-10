<?php

//защита от прямого доступа
defined('_JEXEC') or die();

//вывод настроек плагина
?>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable" width="100%">
            <tr>
                <td class="key" width="300">
                    <?php echo "DOMAIN"; ?></td>
                <td>
                    <input type="text" name="pm_params[unitpay_domain]" class="inputbox" value="<?php echo $params['unitpay_domain']; ?>" />
                    <?php echo JHTML::tooltip(_JSHOP_CFG_UNITPAY_DOMAIN_DESCRIPTION); ?>
                </td>
            </tr>
			<tr>
				<td class="key" width="300">
					<?php echo "PUBLIC KEY"; ?></td>
				<td>
					<input type="text" name="pm_params[unitpay_public_key]" class="inputbox" value="<?php echo $params['unitpay_public_key']; ?>" />
					<?php echo JHTML::tooltip(_JSHOP_CFG_UNITPAY_PUBLIC_KEY_DESCRIPTION); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo "SECRET KEY"; ?>
				</td>
				<td>
					<input type="text" name="pm_params[unitpay_secret_key]" class="inputbox" value="<?php echo $params['unitpay_secret_key'];?>" />
					<?php echo JHTML::tooltip(_JSHOP_CFG_UNITPAY_SECRET_KEY_DESCRIPTION); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo _JSHOP_UNITPAY_PAYMENT_END;?>
				</td>
				<td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[payment_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['payment_end_status'] );
					echo " ".JHTML::tooltip(_JSHOP_UNITPAY_PAYMENT_END_DESCRIPTION);
					?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo _JSHOP_UNITPAY_PAYMENT_FAILED; ?>
				</td>
				<td>
					<?php
					echo JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[payment_failed_status]', 'class="inputbox" size="1"', 'status_id', 'name', $params['payment_failed_status']);
					echo " ".JHTML::tooltip(_JSHOP_UNITPAY_PAYMENT_FAILED_DESCRIPTION);
					?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>
<div class="clr"></div>