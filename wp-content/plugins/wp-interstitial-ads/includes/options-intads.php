<?php
$defaults = $this->get_defaults();
if($_POST['interstitial_ads_hidden'] === 'Y') {
	$ads_content = $_POST['interstitial_ads_content'];
	$ads_content_top = $_POST['interstitial_ads_content_two_top'];
	$ads_content_bottom_left = $_POST['interstitial_ads_content_bottom_left'];
	$ads_content_bottom_right = $_POST['interstitial_ads_content_bottom_right'];
	$options = $_POST['interstitial_ads_opts'];
	$options['content'] = $ads_content;
	$options['content_top'] = $ads_content_top;
	$options['content_bottom_left'] = $ads_content_bottom_left;
	$options['content_bottom_right'] = $ads_content_bottom_right;

	update_option('interstitial_ads_opts', $options);
	?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
	<?php
} else {
	$options = get_option('interstitial_ads_opts', $defaults);
}

$functions = new Int_Ads_Functions();
?>

<form method="post" action="" method="POST" id="interstitial_ads_form">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Enable Ads', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="checkbox" id="interstitial_ads_opts[enable]" name="interstitial_ads_opts[enable]" <?php if($options['enable']) echo ' checked'; ?> />
				<span class="description"><?php _e( 'Turn interstitial ads on', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Allow Skip Link', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="checkbox" id="interstitial_ads_opts[skip_link]" name="interstitial_ads_opts[skip_link]" <?php if($options['skip_link']) echo ' checked'; ?> />
				<span class="description"><?php _e( 'Allow skip this ad link during countdown', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Development Mode', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="checkbox" id="interstitial_ads_opts[dev_mode]" name="interstitial_ads_opts[dev_mode]" <?php if($options['dev_mode']) echo ' checked'; ?> />
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
						?>
						<label for="interstitial_ads_opts[page][<?php echo $option; ?>]">
							<input type="checkbox" id="interstitial_ads_opts[page][<?php echo $option; ?>]" name="interstitial_ads_opts[page][<?php echo $option; ?>]" <?php if(isset($options['page'][$option])) echo ' checked'; ?> />
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
				<?php _e( 'Ad Timer', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<input type="number" id="interstitial_ads_opts[timer]" name="interstitial_ads_opts[timer]" value="<?php echo $options['timer']; ?>" />
				<span class="description"><?php _e( 'Time (in seconds) to show ad before skip button', 'wp-interstitial-ads' ); ?></span>
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
				<select name="interstitial_ads_opts[cookie_duration]" id="interstitial_ads_opts[cookie_duration]">
					<?php foreach ($cookie_dur_options as $duration => $seconds): ?>
						<option value="<?php echo $seconds; ?>"<?php $functions->is_selected($seconds, 'interstitial', $defaults); ?>><?php echo $duration; ?></option>
					<?php endforeach ?>
				</select>
				<span class="description"><?php _e( 'Time until ad shows again for the user', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Ad Background', 'wp-interstitial-ads' ); ?>
			</th>
			<td class="bg-accordion">
				<div class="accordion-item">
					<input type="radio" name="interstitial_ads_opts[bg][type]" value="color" id="ads_bg_color" <?php if($options['bg']['type'] === 'color') echo ' checked'; ?>>
					<label for="ads_bg_color">Color</label>
					<article>
						<input type="text" name="interstitial_ads_opts[bg][background_color]" value="<?php echo $options['bg']['background_color']; ?>" class="color-field" >
					</article>
				</div>
				<div class="accordion-item">
					<input type="radio" name="interstitial_ads_opts[bg][type]" value="image" id="ads_bg_img" <?php if($options['bg']['type'] === 'image') echo ' checked'; ?>>
					<label for="ads_bg_img">Image</label>
					<article>
						<input id="interstitial_ads_opts[bg][image]" name="interstitial_ads_opts[bg][image]" value="<?php if(isset($options['bg']['image'])) echo $options['bg']['image']; ?>" class="img_url" type="text" />
						<input id="interstitial_ads_bg_button" class="button" name="interstitial_ads_bg_button" type="button" value="Upload" />
						<div class="img-size">
							<input type="radio" name="interstitial_ads_opts[bg][image_size]" value="stretch" id="interstitial_ads_bg_stretch" <?php if($options['bg']['image_size'] === 'stretch') echo ' checked'; ?>>
							<label for="interstitial_ads_bg_stretch"> Stretch Image</label>
							<br>
							<input type="radio" name="interstitial_ads_opts[bg][image_size]" value="repeat" id="interstitial_ads_bg_repeat" <?php if($options['bg']['image_size'] === 'repeat') echo ' checked'; ?>>
							<label for="interstitial_ads_bg_repeat"> Repeat Image</label>
						</div>
					</article>
				</div>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e( 'Ad Content', 'wp-interstitial-ads' ); ?>
			</th>
			<td class="content-accordion">
				<div class="accordion-item">
					<input type="radio" name="interstitial_ads_opts[content_layout]" value="layout1" id="ad_layout_one" <?php if($options['content_layout'] === 'layout1') echo ' checked'; ?>>
					<label for="ad_layout_one">Whole Top</label>
					<article>
						<div class="postarea">
							<?php wp_editor( htmlspecialchars_decode(stripslashes($options['content'])), 'interstitial_ads_content', array( 'media_buttons' => true, 'textarea_rows' => 10, 'teeny' => false ) ); ?>
							<span class="description"><?php _e( 'HTML to display in the ad', 'wp-interstitial-ads' ); ?></span>
						</div>
					</article>
				</div>
				<div class="accordion-item">
					<input type="radio" name="interstitial_ads_opts[content_layout]" value="layout2" id="ad_layout_two" <?php if($options['content_layout'] === 'layout2') echo ' checked'; ?>>
					<label for="ad_layout_two">Whole Top + 2 Half Bottoms</label>
					<article>
						<div class="postarea">
							<p>
								<strong>Main Content</strong>
							</p>
							<?php wp_editor( htmlspecialchars_decode(stripslashes($options['content_top'])), 'interstitial_ads_content_two_top', array( 'media_buttons' => true, 'textarea_rows' => 6, 'teeny' => false ) ); ?>
							<div class="bottom-areas">
								<div class="input_sec">
									<p>
										<strong>Left Bottom Content</strong>
									</p>
									<?php wp_editor( htmlspecialchars_decode(stripslashes($options['content_bottom_left'])), 'interstitial_ads_content_bottom_left', array( 'media_buttons' => true, 'textarea_rows' => 6, 'teeny' => false ) ); ?>
								</div>
								<div class="input_sec">
									<p>
										<strong>Right Bottom Content</strong>
									</p>
									<?php wp_editor( htmlspecialchars_decode(stripslashes($options['content_bottom_right'])), 'interstitial_ads_content_bottom_right', array( 'media_buttons' => true, 'textarea_rows' => 6, 'teeny' => false ) ); ?>
								</div>
							</div>
						</div>
					</article>
				</div>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<?php _e( 'Extra Styles', 'wp-interstitial-ads' ); ?>
			</th>
			<td>
				<textarea name="interstitial_ads_opts[css]" id="interstitial_ads_css" cols="30" rows="10"><?php echo $options['css']; ?></textarea>
				<span class="description"><?php _e( 'Extra CSS you want to add to your ad', 'wp-interstitial-ads' ); ?></span>
			</td>
		</tr>
	</table>
	<input type="hidden" name="interstitial_ads_hidden" value="Y">
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'wp-interstitial-ads' ); ?>" />
	</p>
</form>
