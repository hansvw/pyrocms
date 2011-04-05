<html>
    <head>
        <title>Message from <?php echo $this->settings->item('site_name');?></title>
    </head>
    <body>
        <table width="100%" style="font-size: 14px;">
            <tr>
                <td>Thank you for contacting Trullove, <?php echo $contact_name;?>. We will respond to your question or suggestion shortly.
                    If you wish to speak with us, please call: +32 (Belgium) 477 66 29 65.
                </td>
            </tr>
            <tr>
                Your message as we have received it:
                <hr />
                <?php echo $message; ?>
            </tr>
        </table>
    </body>
</html>