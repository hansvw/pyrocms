<?php echo sprintf(lang('booking_mail_text'), $this->config->item('site_name'));?>

<?php echo 'Thank you for your reservation request '.$firstname . ' ' . $lastname .
           'We will contact you shortly to finalize your reservation, and to discuss any
            special requests you may have.'; ?>
    
<?php echo lang('booking_mail_above_message_label');?>

<?php echo $message;?>

<?php echo lang('booking_mail_below_message_label');?>

<?php echo sprintf(lang('booking_mail_ip_label'), $sender_ip);?>
<?php echo sprintf(lang('booking_mail_os_label'), $sender_os);?>
<?php echo sprintf(lang('booking_mail_agent_label'), $sender_agent);?>