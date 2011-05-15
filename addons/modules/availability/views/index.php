<?php echo form_open('availability');?>
    <div class="colmask">
        <div class="colmid">
            <div class="colleft">
                <div class="col1">
                </div>
                <div class="col2">
                    <div>
                        <label for="yearselector"><?php echo lang('yearselection_label');?></label>
                        <?php echo form_dropdown('yearselection', $yearselections, $form_values->yearselection, $selectionjs); ?>
                        <input type="hidden" name="selectedyear" value="<?php echo $form_values->yearselection;?>" />
                    </div>
                </div>
                <div class="col3">
                </div>
            </div>
        </div>
    </div>
    <div class="cleared"></div>
    <table class="legend" style="margin-left: 40px;" width="816" border="0" cellspacing="5" cellpadding="0">
        <tbody>
            <tr>
                <td class="legendtext">Legend:</td>
                <td class="legendentry" align="right">Available</td>
                <td class="ravailable" width="24"></td>
                <td class="legendentry" align="right">Pending</td>
                <td class="rpending" width="24"></td>
                <td class="legendentry" align="right">Booked</td>
                <td class="rconfirmed" width="24"></td>
                <td class="legendentry" align="right">Changeover day</td>
                <td class="rchangeover" width="24"></td>
            </tr>
        </tbody>
    </table>
    <div class="calendar">
        <?php echo $calendar_html;?>
    </div>
<?php echo form_close(); ?>