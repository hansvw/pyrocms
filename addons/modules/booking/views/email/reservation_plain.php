<?php echo sprintf(lang('booking_mail_text'), $this->config->item('site_name'));?>
    
<?php echo lang('booking_mail_above_message_label');?>

<?php echo 'Reservation request from: '. $firstname. ' ' . $lastname;?>
<?php echo 'Reservation code: ' . $reservationcode?>
<?php echo 'Special requests, message to owner: '.$message;?>

<?php echo lang('booking_mail_below_message_label');?>

<?php echo sprintf(lang('booking_mail_ip_label'), $sender_ip);?>
<?php echo sprintf(lang('booking_mail_os_label'), $sender_os);?>
<?php echo sprintf(lang('booking_mail_agent_label'), $sender_agent);?>
