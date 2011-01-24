<h2 id="page_title"><?php echo lang('contact_title');?></h2>

<?php if (validation_errors()): ?>
<div class="error_box">
	<?php echo validation_errors();?>
</div>
<?php endif; ?>
<?php echo form_open('yourstrulli');?>
    <div class="colmask">
        <div class="colmid">
            <div class="colleft">
                <div class="col1">
                    <div>
                    <label for="contact_name"><?php echo lang('contact_name_label');?></label>
                    </div>
                    <div>
                    <?php echo form_input('contact_name', $form_values->contact_name);?>
                    </div>
                </div>
                <div class="col2">
                    <div>
                    <label for="contact_email"><?php echo lang('contact_email_label');?></label>
                    </div>
                    <div>
                    <?php echo form_input('contact_email', $form_values->contact_email);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="colmask">
        <div class="colmid">
            <div class="colleft">
                <div class="col1">
                    <div>
                    <label for="contact_subject"><?php echo lang('contact_subject_label');?></label>
                    </div>
                    <div>
                    <?php echo form_dropdown('subject', $subjects, $form_values->subject, 'id="subject"'); ?>
                    </div>
                </div>
                <div class="col2">
                <input id="other_subject" name="other_subject" type="text" />
                </div>
            </div>
        </div>
    </div>
    <div class="colmask">
        <div>
        <label for="message"><?php echo lang('contact_message_label'); ?></label>
        </div>
        <div>
        <?php echo form_textarea('message', $form_values->message, 'id="message"'); ?>
        </div>
    </div>
    <p class="form_buttons">
		<input type="submit" value="<?php echo lang('contact_send_label') ?>" name="btnSubmit" />
	</p>
<?php echo form_close(); ?>