<h2 id="page_title"><?php echo lang('booking_title');?></h2>

<?php echo form_open('booking');?>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="firstnamefield"><?php echo lang('booking_first_name_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['firstname']['name']))
            {
                echo form_error($formfields['firstname']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['firstname']).'</div>';
            }
            else
            {
                echo form_input($formfields['firstname'], $form_values->firstname);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="lastnamefield"><?php echo lang('booking_last_name_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['lastname']['name']))
            {
                echo form_error($formfields['lastname']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['lastname']).'</div>';
            }
            else
            {
                echo form_input($formfields['lastname'], $form_values->lastname);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="emailfield"><?php echo lang('booking_email_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['email']['name']))
            {
                echo form_error($formfields['email']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['email']).'</div>';
            }
            else
            {
                echo form_input($formfields['email'], $form_values->email);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="countryfield"><?php echo lang('booking_country_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['country']['name']))
            {
                echo form_error($formfields['country']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['country']).'</div>';
            }
            else
            {
                echo form_input($formfields['country'], $form_values->country);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="languagefield"><?php echo lang('booking_language_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['language']['name']))
            {
                echo form_error($formfields['language']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['language']).'</div>';
            }
            else
            {
                echo form_input($formfields['language'], $form_values->language);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="tel1field"><?php echo lang('booking_tel1_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['tel1']['name']))
            {
                echo form_error($formfields['tel1']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['tel1']).'</div>';
            }
            else
            {
                echo form_input($formfields['tel1'], $form_values->tel1);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <label for="tel2field"><?php echo lang('booking_tel2_label');?></label>
            </div>
            <div class="col2">
            <?php if(form_error($formfields['tel2']['name']))
            {
                echo form_error($formfields['tel2']['name']);
                echo '<div style="border: 1px solid #ff0000;">'.form_input($formfields['tel2']).'</div>';
            }
            else
            {
                echo form_input($formfields['tel2'], $form_values->tel2);
            }?>
            </div>
        </div>
    </div>
</div>
<div class="colmask">
    <div class="colmid">
        <div class="colleft">
            <div class="col1">
                <div><label for="arrivaldate">Arrival Date:</label></div>
                <div>
                <?php echo form_dropdown('arrivaldate',$form_values->arrivaldates);?>
                </div>
            </div>
            <div class="col2">
                <div><label for="lengthofstay">Length of stay (weeks)</label></div>
                <div>
                <?php echo form_dropdown('lengthofstay',$form_values->lengthsofstay);?>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div><label for="message">Special requests, message to owner:</label></div>
    <div>
        <?php echo form_textarea($formfields['message'], $form_values->message);?>
    </div>
</div>
<p class="form_buttons">
    <input type="submit" class="art-button" value="<?php echo lang('booking_send_label') ?>" name="btnSubmit" />
</p>
<?php echo form_close(); ?>