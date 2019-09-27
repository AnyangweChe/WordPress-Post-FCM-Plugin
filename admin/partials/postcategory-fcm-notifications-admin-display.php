<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * @since      1.0.0
 *
 * @package    WordPress-Post-FCM-Plugin
 * @subpackage WordPress-Post-FCM-Plugin/admin/partials
 */
 
 if(isset( $_POST['sendmsg'] ) && wp_verify_nonce($_REQUEST['sendmsg'], 'mode_send_msg')  && current_user_can('administrator') && get_option('pfcm_api')){
	
	$send_token_length = strlen(sanitize_text_field($_POST['pfcm_single_token']));
	$send_token = sanitize_text_field($_POST['pfcm_single_token']);
	$send_title = sanitize_text_field($_POST['pfcm_single_subject']);
	$send_msgtext = sanitize_text_field($_POST['pfcm_single_message']);
	
	if($send_token_length > 90){
		$response = $this->pfcm_notification($title, $contentt, $send_token);
	}else{
		$response = $this->pfcm_notification($title, $contentt, "/topics/".$send_token);
	}
	
	//response from google firebase
	if($response){
		
		$result = json_decode($response, true);
		
		// if response success
		if($result['success'] == 1){
			echo "<div class='update-nag notice pcfcn-notices' ><p>Message has been sent successfully.</p></div><br/>";
		}else{
			// Print Debug Information
			echo "<div class='update-nag error pcfcn-notices' ><p>Error : ".$result['results'][0]['error']."</p></div>";
		}
	 }	
}	
?>

<h1 class="pcfcn-topic">Send Single FCM Message</h1>
<div id="acf_location" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle ui-sortable-handle"><span>New Notification</span></h3>
<div class="inside">
<form action="admin.php?page=admin_menu_pfcm" method="post">

	<table class="acf_input widefat" id="acf_location">
		<tbody>
		<tr>
			<td class="label">
				<label for="post_type">Subject</label>
				<p class="description">FCM Title</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-api-key" class="number" name="pfcm_single_subject" value="" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Token or Topic</label>
				<p class="description">Users Registration token or topic</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-api-key" class="number" name="pfcm_single_token" value="" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Message</label>
				<p class="description">Message body</p>
				
			</td>
			<td>
				<div class="acf-input-wrap">
					<textarea type="text" style="height:200px;" id="pcfn-api-key" class="number" name="pfcm_single_message" value="" placeholder="Message body" required="required"> </textarea>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	<?php wp_nonce_field('mode_send_msg','sendmsg'); ?>
	<p class="submit"><?php submit_button('Send Notification'); ?></p>
</form>
</div>
</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
