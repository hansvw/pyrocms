<h2><?php echo $title; ?></h2>

<?php
//check if there is any alert message set
if(isset($alert) && !empty($alert))
{
	//message alert
	echo $alert;
}

echo form_open('admin/calendar/create');?>
	<table align="center">
		
		<tr>
			<td>Date : </td>
			<td><input id="date" name="date" size="30"></td>
		</tr>
		<tr>
			<td>Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" size="50"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><textarea cols="40" rows="5" name="eventContent" id="eventContent"></textarea></td>
		</tr>
		<tr>
		<td><input type="hidden" name="user_id" id="user_id" value="<?php  echo $user->id;?>" /></td>
		<td><input type="hidden" name="user" id="nick" value="<?php  echo $user->first_name;?>" />		</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Add Event" name="add"></td>
		</tr>
	</table>

	<?php form_close() ;?>
	

	