<?php
$defaults = $this->get_defaults();
if(isset($_POST['interstitial_ads_section']) && $_POST['interstitial_ads_section'] === 'popup') {
	$ads_content = $_POST['interstitial_popup_ads_content'];
	$options = $_POST['interstitial_popup_ads_opts'];
	$options['popup_content'] = $ads_content;

	update_option('interstitial_popup_ads_opts', $options);
	?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
	<?php
} else {
	$options = get_option('interstitial_popup_ads_opts', $defaults);
}

$functions = new Int_Ads_Functions();
?>

<p class="description" style="margin-top: 20px;">If Intersitial ad is active on the same page as a popup ad, the interstitial will take precedence.</p>
<form method="post" action="" method="post" id="interstitial_ads_form" name="interstitial_ads_form">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Enable Ads', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="checkbox" id="interstitial_popup_ads_opts[enable]" name="interstitial_popup_ads_opts[enable]" <?php if(isset($options['enable']) && $options['enable']) echo ' checked'; ?> />
				<span class="description"><?php _e( 'Turn popup ads on', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Development Mode', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="checkbox" id="interstitial_popup_ads_opts[dev_mode]" name="interstitial_popup_ads_opts[dev_mode]" <?php if(isset($options['dev_mode']) && $options['dev_mode']) echo ' checked'; ?> />
				<span class="description"><?php _e( 'Only show ad if logged in as admin. No cookie will be set', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Show On Pages', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<?php
					$page_options = array(
						'Home' => 'home',
						'Posts' => 'posts',
						'Pages' => 'pages',
						'Tags' => 'tags',
						'Categories' => 'categories',
						'Authors' => 'authors',
					);
					foreach ($page_options as $opt_name => $option) {
						$id_name = 'interstitial_popup_ads_opts[popup_page]['.$option.']';
						?>
						<label for="interstitial_popup_ads_opts[popup_page][<?php echo $option; ?>]">
							<input type="checkbox" id="<?php echo $id_name; ?>" name="<?php echo $id_name; ?>" <?php if(isset($options['popup_page'][$option])) echo ' checked'; ?> />
							<?php _e( $opt_name, 'wp-interstitial-ads' ); ?>
						</label>
						<br>
						<?php
					}
				?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Cookie Time', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<?php
					$cookie_dur_options = array(
						'None' => 1,
						'5 Minutes' => 300,
						'10 Minutes' => 600,
						'30 Minutes' => 1800,
						'1 Hour' => 3600,
						'6 Hours' => 21600,
						'1 Day' => 86400,
						'1 Week' => 604800
					);
				?>
				<select name="interstitial_popup_ads_opts[cookie_duration]" id="interstitial_popup_ads_opts[cookie_duration]">
					<?php foreach ($cookie_dur_options as $duration => $seconds): ?>
						<option value="<?php echo $seconds; ?>"<?php $functions->is_selected($seconds, 'popup', $defaults); ?>><?php echo $duration; ?></option>
					<?php endforeach ?>
				</select>
				<span class="description"><?php _e( 'Time until ad shows again for the user', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Form Content', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
					<?php wp_editor( htmlspecialchars_decode(stripslashes($options['popup_content'])), 'interstitial_popup_ads_content', array( 'media_buttons' => true, 'textarea_rows' => 10, 'teeny' => false ) ); ?>
					<span class="description"><?php _e( 'HTML to display in the ad', 'wp-interstitial-ads' ); ?></span>
				</div>
			</td>
		</tr>
	</table>
	<input type="hidden" name="interstitial_ads_section" value="popup">
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'wp-interstitial-ads' ); ?>" />
	</p>
</form>
