<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>
<h1 class="pcfcn-topic">Setup Google Firebase Cloud Messaging</h1>
<div id="acf_location" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle ui-sortable-handle"><span>SETTINGS</span></h3>
<div class="inside">
<form action="options.php" method="post">

    <?php settings_fields( 'pfcm_group'); ?>
    <?php do_settings_sections( 'pfcm_group' ); ?>
	
	<table class="acf_input widefat" id="acf_location">
		<tbody>
		<tr>
			<td class="label">
				<label for="post_type">FCM API Key</label>
				<p class="description">Get API key from your Firebase Console</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-api-key" class="number" name="pfcm_api" value="<?php echo get_option( 'pfcm_api' );  ?>" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">FCM Topic</label>
				<p class="description">FCM Topic in Application</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-api-key" class="number" name="pfcm_topic" value="<?php echo get_option( 'pfcm_topic' );  ?>" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Category</label>
				<p class="description">Send FCM when post is published from these Categories</p>
			</td>
			<td>
				<ul class="acf-checkbox-list checkbox vertical">
					<?php $catest = get_categories() ;
						foreach($catest as $catests){ 
							$pfcmCats = 'pfcm_'.$catests->slug; ?>
							<li>
								<label>
									<input type="checkbox" value="1" name="<?php echo $pfcmCats ; ?>" <?php checked( '1', get_option( $pfcmCats ) ); ?> ><?php echo $catests->name; ?>
								</label>
							</li>
					<?php } ?>
				</ul>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Disable FCM</label>
				<p class="description">Disable Push Notification on Post Publish</p>
			</td>
			<td>
				<input id="post_disable" name="pfcm_disable" type="checkbox" value="1" <?php checked( '1', get_option( 'pfcm_disable' ) ); ?> >Yes 
			</td>
		</tr>
		</tbody>
	</table>
	
	<p class="submit"><?php submit_button(); ?></p>
</form>
</div>
</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
