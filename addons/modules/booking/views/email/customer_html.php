<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><?php echo sprintf(lang('booking_mail_text'), $this->config->item('site_name'));?></td>
	</tr>
  	<tr>
		<td colspan="3">
            <p>Thank you for your reservation request <?php echo $firstname . ' ' . $lastname?>.
                We will contact you shortly to finalize your reservation, and to discuss any
                special requests you may have.</p>
			<br />
		</td>
    </tr>
	<tr>
		<td colspan="3">
            <p>Your special requests, message to owner:</p>
			<?php echo $message;?>
		</td>
    </tr>
   	<tr>
        <hr />
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_ip_label').'</strong>', $sender_ip);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_os_label').'</strong>', $sender_os);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_agent_label').'</strong>', $sender_agent);?></td>
	</tr>
</table>
