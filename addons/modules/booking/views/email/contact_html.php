<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><?php echo sprintf(lang('booking_mail_text'), $this->config->item('site_name'));?></td>
	</tr>
	<tr>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_ip_label').'</strong>', $sender_ip);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_os_label').'</strong>', $sender_os);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_agent_label').'</strong>', $sender_agent);?></td>
	</tr>
	<tr>
		<td colspan="3">
			<hr />
			<?php echo $message;?>
			<br />
			<?php echo sprintf('<strong>'.lang('booking_mail_first_name_label').'</strong>', $booking_first_name);?><br/>
		</td>
  </tr>
</table>
