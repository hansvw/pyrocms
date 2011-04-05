<html>
    <head>
        <title><?php echo $this->settings->item('site_name');?> contact form:</title>
    </head>
    <body>
        <table width="100%" style="font-size: 14px;">
            <tr>
                <td colspan="3">
                    <strong>From: </strong><?php echo $contact_name;?><br />
                    <strong>Email: </strong><?php echo $contact_email;?><br />
                    <strong>Tel: </strong><?php echo $contact_phone;?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <hr />
                    <?php echo $message;?>
                    <hr />
                </td>
            </tr>
            <tr>
                <td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_ip_label').'</strong>', $sender_ip);?></td>
                <td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_os_label').'</strong>', $sender_os);?></td>
                <td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_agent_label').'</strong>', $sender_agent);?></td>
            </tr>
        </table>
    </body>
</html>
