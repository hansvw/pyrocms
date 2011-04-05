<?php echo sprintf(lang('contact_mail_text'), $this->settings->item('site_name'));?>

<?php echo sprintf('<strong>From: </strong> %s', $contact_name);?>
<?php echo sprintf('<strong>Email: </strong> %s', $contact_email);?>
<?php echo sprintf('<strong>Tel: </strong> %s', $contact_phone);?>

<?php echo sprintf(lang('contact_mail_ip_label'), $sender_ip);?>
<?php echo sprintf(lang('contact_mail_os_label'), $sender_os);?>
<?php echo sprintf(lang('contact_mail_agent_label'), $sender_agent);?>
    
<?php echo lang('contact_mail_above_message_label');?>

<?php echo $message;?>

<?php echo lang('contact_mail_below_message_label');?>

<?php echo sprintf(lang('contact_mail_name_label'), $contact_name);?>