<h2 id="page_title"><?php echo lang('booking_title');?></h2>

<?php echo form_open('booking');?>
	<p>
		<label for="firstnamefield"><?php echo lang('booking_first_name_label');?></label>
        <?php if(form_error($formfields['firstname']['name']))
        {
            echo form_error($formfields['firstname']['name']);
            echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['firstname']).'</div>';
        }
        else
        {
            echo form_input($formfields['firstname']);
        }?>
	</p>
	<p>
		<label for="lastnamefield"><?php echo lang('booking_last_name_label');?></label>
        <?php if(form_error($formfields['lastname']['name']))
        {
            echo form_error($formfields['lastname']['name']);
            echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['lastname']).'</div>';
        }
        else
        {
            echo form_input($formfields['lastname']);
        }?>
	</p>
    <p>
        <label for="emailfield"><?php echo lang('booking_email_label');?></label>
        <?php if(form_error($formfields['email']['name']))
        {
            echo form_error($formfields['email']['name']);
            echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['email']).'</div>';
        }
        else
        {
            echo form_input($formfields['email']);
        }?>
    </p>
	<p>
        <label for="tel1field"><?php echo lang('booking_tel1_label');?></label>
        <?php if(form_error($formfields['tel1']['name']))
        {
            echo form_error($formfields['tel1']['name']);
            echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['tel1']).'</div>';
        }
        else
        {
            echo form_input($formfields['tel1']);
        }?>
    </p>
    <p>
        <label for="tel2field"><?php echo lang('booking_tel2_label');?></label>
        <?php if(form_error($formfields['tel2']['name']))
        {
            echo form_error($formfields['tel2']['name']);
            echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['tel2']).'</div>';
        }
        else
        {
            echo form_input($formfields['tel1']);
        }?>
	</p>
    <p>
        <?php echo form_dropdown('url',$form_values->urlarray);?>
    </p>
	<p class="form_buttons">
		<input type="submit" class="art-button" value="<?php echo lang('booking_send_label') ?>" name="btnSubmit" />
	</p>
<?php echo form_close(); ?>
