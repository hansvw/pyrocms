<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><?php echo sprintf(lang('booking_mail_text'), $this->config->item('site_name'));?></td>
	</tr>
  	<tr>
		<td colspan="3">
            <p>You have received a reservation request from <?php echo $firstname. ' ' . $lastname?></p>
		</td>
    </tr>
  	<tr>
		<td colspan="3">
            <p><strong>E-mail address:</strong> <?php echo $email;?></p>
            <p><strong>Telephone number:</strong> <?php echo $tel1;?></p>
            <p><strong>Alternate telephone number:</strong> <?php echo $tel2;?></p>
            <p><strong>Arrival date:</strong> <?php echo $startdate;?></p>
            <p><strong>Departure date:</strong> <?php echo $enddate; ?></p>
		</td>
    </tr>
	<tr>
		<td colspan="3">
            <p><strong>Special requests, message to owner:</strong></p>
			<?php echo $message;?>
			<br />
			<?php echo sprintf('<strong>'.lang('booking_mail_first_name_label').'</strong>', $firstname);?><br/>
		</td>
    </tr>
   	<tr>
        <hr />
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_ip_label').'</strong>', $sender_ip);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_os_label').'</strong>', $sender_os);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('booking_mail_agent_label').'</strong>', $sender_agent);?></td>
	</tr>
</table>
