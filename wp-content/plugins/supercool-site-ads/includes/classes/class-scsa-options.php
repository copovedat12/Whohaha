<?php

class SC_Ads_Options{
	public static $int_option_name;
	public static $popup_option_name;
	public function __construct(){
		self::$int_option_name = 'sc_ads_opts_int';
		self::$popup_option_name = 'sc_ads_opts_popup';
	}

	public function sc_ads_settings_init(){
		// register settings
		register_setting( 'sc_int_ads_options_group', self::$int_option_name );
		register_setting( 'sc_int_ads_content_group', self::$int_option_name );
		register_setting( 'sc_popup_ads_options_group', self::$popup_option_name );
		register_setting( 'sc_popup_ads_content_group', self::$popup_option_name );

		/*
		 * Create seperate settings sections for plugin
		 */
		add_settings_section(
			'sc_int_ads_section',
			__( 'Interstitial Ads Options', 'sc_ads' ),
			array($this, 'sc_int_ads_section_callback'),
			'sc_int_ads_options_group'
		);
		add_settings_section(
			'sc_int_ads_content_section',
			__( 'Interstitial Ads Content', 'sc_ads' ),
			array($this, 'sc_int_ads_content_section_callback'),
			'sc_int_ads_content_group'
		);
		add_settings_section(
			'sc_popup_ads_section',
			__( 'Popup Ads Options', 'sc_ads' ),
			array($this, 'sc_popup_ads_section_callback'),
			'sc_popup_ads_options_group'
		);
		add_settings_section(
			'sc_popup_ads_content_section',
			__( 'Popup Ads Content', 'sc_ads' ),
			array($this, 'sc_popup_ads_content_section_callback'),
			'sc_popup_ads_content_group'
		);

		// Enable Ads
		// sc_ads_opts_int[sc_int_ads_enable]
		add_settings_field(
			'sc_ads_setting_enable_field',
			__( 'Enable Interstital Ad', 'sc_ads' ),
			array($this, 'sc_int_ads_enable_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Development Mode
		// sc_ads_opts_int[sc_int_ads_dev_mode]
		add_settings_field(
			'sc_int_ads_dev_mode_field',
			__( 'Development Mode', 'sc_ads' ),
			array($this, 'sc_int_ads_dev_mode_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Skip Link
		// sc_ads_opts_int[sc_int_ads_allow_skip]
		add_settings_field(
			'sc_int_ads_allow_skip_field',
			__( 'Allow Skip Link', 'sc_ads' ),
			array($this, 'sc_int_ads_allow_skip_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Show On Pages
		// sc_ads_opts_int[sc_int_ads_pages]
		add_settings_field(
			'sc_int_ads_pages_field',
			__( 'Show On Pages', 'sc_ads' ),
			array($this, 'sc_int_ads_pages_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Ad Timer
		// sc_ads_opts_int[sc_int_ads_timer]
		add_settings_field(
			'sc_int_ads_timer_field',
			__( 'Ad Timer', 'sc_ads' ),
			array($this, 'sc_int_ads_timer_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Cookie Time
		// sc_ads_opts_int[sc_int_cookie_time]
		add_settings_field(
			'sc_int_cookie_time_field',
			__( 'Cookie Time', 'sc_ads' ),
			array($this, 'sc_int_cookie_time_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Ad Background
		// sc_ads_opts_int[sc_int_ads_bg]
		// sc_ads_opts_int[sc_int_ads_bg][type]
		// sc_ads_opts_int[sc_int_ads_bg][bg_color]
		// sc_ads_opts_int[sc_int_ads_bg][bg_url]
		// sc_ads_opts_int[sc_int_ads_bg][img_placement]
		add_settings_field(
			'sc_int_ads_bg_field',
			__( 'Ad Background', 'sc_ads' ),
			array($this, 'sc_int_ads_bg_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);

		// Font Color
		// sc_ads_opts_int[sc_int_ads_max_width]
		add_settings_field(
			'sc_int_ads_font_color_field',
			__( 'Font Color', 'sc_ads' ),
			array($this, 'sc_int_ads_font_color_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);

		// Max Ad Width
		// sc_ads_opts_int[sc_int_ads_max_width]
		add_settings_field(
			'sc_int_ads_max_width_field',
			__( 'Max Ad Width (in px)', 'sc_ads' ),
			array($this, 'sc_int_ads_max_width_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// CTA Button
		// sc_ads_opts_int[sc_int_ads_btn_text]
		// sc_ads_opts_int[sc_int_ads_btn_link]
		add_settings_field(
			'sc_int_ads_btn_field',
			__( 'CTA Button', 'sc_ads' ),
			array($this, 'sc_int_ads_btn_render'),
			'sc_int_ads_options_group',
			'sc_int_ads_section'
		);
		// Ad Content
		// sc_ads_opts_int[sc_int_ads_content]
		add_settings_field(
			'sc_int_ads_content_field',
			false,
			array($this, 'sc_int_ads_content_render'),
			'sc_int_ads_content_group',
			'sc_int_ads_content_section',
			array('class' => 'hide_title')
		);
		// Ads bottom content
		// sc_ads_opts_int[sc_int_ads_bl_content]
		// sc_ads_opts_int[sc_int_ads_br_content]
		add_settings_field(
			'sc_int_ads_bottom_content_field',
			false,
			array($this, 'sc_int_ads_bottom_content_render'),
			'sc_int_ads_content_group',
			'sc_int_ads_content_section',
			array('class' => 'hide_title')
		);

		/*
			Popup Ad field settings
		 */

		// Enable Ads
		// sc_ads_opts_popup[sc_popup_ads_enable]
		add_settings_field(
			'sc_popup_ads_enable_field',
			__( 'Enable Popup Ad', 'sc_ads' ),
			array($this, 'sc_popup_ads_enable_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		// Development Mode
		// sc_ads_opts_popup[sc_popup_ads_dev_mode]
		add_settings_field(
			'sc_popup_ads_dev_mode_field',
			__( 'Development Mode', 'sc_ads' ),
			array($this, 'sc_popup_ads_dev_mode_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		// Show On Pages
		// sc_ads_opts_popup[sc_popup_ads_pages]
		add_settings_field(
			'sc_popup_ads_pages_field',
			__( 'Show On Pages', 'sc_ads' ),
			array($this, 'sc_popup_ads_pages_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		// Cookie Time
		// sc_ads_opts_popup[sc_popup_cookie_time]
		add_settings_field(
			'sc_popup_cookie_time_field',
			__( 'Cookie Time', 'sc_ads' ),
			array($this, 'sc_popup_cookie_time_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		// Font Color
		// sc_ads_opts_popup[sc_popup_ads_font_color]
		add_settings_field(
			'sc_popup_ads_font_color_field',
			__( 'Font Color', 'sc_ads' ),
			array($this, 'sc_popup_ads_font_color_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		// Max Ad Width
		// sc_ads_opts_popup[sc_popup_ads_max_width]
		add_settings_field(
			'sc_popup_ads_max_width_field',
			__( 'Max Ad Width (in px)', 'sc_ads' ),
			array($this, 'sc_popup_ads_max_width_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);
		//sc_popup_ads_distance_from_top
		// Max Ad Width
		add_settings_field(
			'sc_popup_ads_distance_from_top_field',
			__( 'Ad distance from top of window', 'sc_ads' ),
			array($this, 'sc_popup_ads_distance_from_top_render'),
			'sc_popup_ads_options_group',
			'sc_popup_ads_section'
		);

		// Ad Content
		// sc_ads_opts_popup[sc_popup_ads_content]
		add_settings_field(
			'sc_popup_ads_content_field',
			false,
			array($this, 'sc_popup_ads_content_render'),
			'sc_popup_ads_content_group',
			'sc_popup_ads_content_section',
			array('class' => 'hide_title')
		);
	}

	public function sc_int_ads_enable_render(){
		$options = get_option(self::$int_option_name);
		?>
		<input type="checkbox" name="<?php echo self::$int_option_name; ?>[sc_int_ads_enable]" <?php if(isset($options['sc_int_ads_enable'])) checked( $options['sc_int_ads_enable'], 1 ); ?> value="1">
		<span class="description">Turn interstitial ads on</span>
		<?php
	}

	public function sc_int_ads_dev_mode_render(){
		$options = get_option(self::$int_option_name);
		?>
		<input type="checkbox" name="<?php echo self::$int_option_name; ?>[sc_int_ads_dev_mode]" <?php if(isset($options['sc_int_ads_dev_mode'])) checked( $options['sc_int_ads_dev_mode'], 1 ); ?> value="1">
		<span class="description">Only show ad if logged in as admin. No cookie will be set</span>
		<?php
	}

	public function sc_int_ads_allow_skip_render(){
		$options = get_option(self::$int_option_name);
		?>
		<input type="checkbox" name="<?php echo self::$int_option_name; ?>[sc_int_ads_allow_skip]" <?php if(isset($options['sc_int_ads_allow_skip'])) checked( $options['sc_int_ads_allow_skip'], 1 ); ?> value="1">
		<span class="description">Allow skip this ad link during countdown</span>
		<?php
	}

	public function sc_int_ads_pages_render(){
		$options = get_option(self::$int_option_name);
		?>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][home]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][home]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][home]" <?php if(isset($options['sc_int_ads_pages']['home'])) checked( $options['sc_int_ads_pages']['home'], 1 ); ?> value="1">
			Home
		</label>
		<br>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][posts]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][posts]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][posts]" <?php if(isset($options['sc_int_ads_pages']['posts'])) checked( $options['sc_int_ads_pages']['posts'], 1 ); ?> value="1">
			Posts
		</label>
		<br>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][pages]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][pages]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][pages]" <?php if(isset($options['sc_int_ads_pages']['pages'])) checked( $options['sc_int_ads_pages']['pages'], 1 ); ?> value="1">
			Pages
		</label>
		<br>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][tags]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][tags]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][tags]" <?php if(isset($options['sc_int_ads_pages']['tags'])) checked( $options['sc_int_ads_pages']['tags'], 1 ); ?> value="1">
			Tag Pages
		</label>
		<br>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][categories]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][categories]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][categories]" <?php if(isset($options['sc_int_ads_pages']['categories'])) checked( $options['sc_int_ads_pages']['categories'], 1 ); ?> value="1">
			Category Pages
		</label>
		<br>
		<label for="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][authors]">
			<input type="checkbox" id="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][authors]" name="<?php echo self::$int_option_name; ?>[sc_int_ads_pages][authors]" <?php if(isset($options['sc_int_ads_pages']['authors'])) checked( $options['sc_int_ads_pages']['authors'], 1 ); ?> value="1">
			Author Pages
		</label>
		<?php
	}

	public function sc_int_ads_timer_render(){
		$options = get_option(self::$int_option_name, array('sc_int_ads_timer' => 5));
		?>
		<input type="number" name="<?php echo self::$int_option_name; ?>[sc_int_ads_timer]" value="<?php if(isset($options['sc_int_ads_timer'])) echo $options['sc_int_ads_timer']; ?>">
		<span class="description">Time (in seconds) to show ad before skip button</span>
		<?php
	}

	public function sc_int_cookie_time_render(){
		$options = get_option(self::$int_option_name, array('sc_int_cookie_time' => 3600));
		?>
		<select name="<?php echo self::$int_option_name; ?>[sc_int_cookie_time]">
			<option value='1' <?php selected( $options['sc_int_cookie_time'], 1 ); ?>>None</option>
			<option value='300' <?php selected( $options['sc_int_cookie_time'], 300 ); ?>>5 Minutes</option>
			<option value='600' <?php selected( $options['sc_int_cookie_time'], 600 ); ?>>10 Minutes</option>
			<option value='1800' <?php selected( $options['sc_int_cookie_time'], 1800 ); ?>>30 Minutes</option>
			<option value='3600' <?php selected( $options['sc_int_cookie_time'], 3600 ); ?>>1 Hour</option>
			<option value='21600' <?php selected( $options['sc_int_cookie_time'], 21600 ); ?>>6 Hours</option>
			<option value='86400' <?php selected( $options['sc_int_cookie_time'], 86400 ); ?>>1 Day</option>
			<option value='64800' <?php selected( $options['sc_int_cookie_time'], 64800 ); ?>>1 Week</option>
			<option value='1209600' <?php selected( $options['sc_int_cookie_time'], 1209600 ); ?>>2 Weeks</option>
			<option value='2592000' <?php selected( $options['sc_int_cookie_time'], 2592000 ); ?>>1 Month</option>
			<option value='31536000' <?php selected( $options['sc_int_cookie_time'], 31536000 ); ?>>1 Year</option>
		</select>
		<span class="description">Time until ad shows again for the user</span>
		<?php
	}

	public function sc_int_ads_bg_render(){
		$bg_default = array(
			'sc_int_ads_bg' => array(
				'type' => 'color',
				'bg_color' => '#FFFFFF',
				'img_placement' => 'stretch'
			)
		);
		$options = get_option(self::$int_option_name, $bg_default);
		?>
		<div class="bg-accordion">
			<div class="accordion-item">
				<input type="radio" name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][type]" id="<?php echo self::$int_option_name; ?>_color" <?php checked( $options['sc_int_ads_bg']['type'], 'color' ); ?> value="color">
				<label for="<?php echo self::$int_option_name; ?>_color">Color</label>
				<article>
					<input type="text" name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][bg_color]" value="<?php echo $options['sc_int_ads_bg']['bg_color']; ?>" class="color-field" >
				</article>
			</div>
		</div>
		<div class="bg-accordion">
			<div class="accordion-item">
				<input type="radio" name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][type]" id="<?php echo self::$int_option_name; ?>_image" <?php checked( $options['sc_int_ads_bg']['type'], 'image' ); ?> value="image">
				<label for="<?php echo self::$int_option_name; ?>_image">Image</label>
				<article>
					<input name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][bg_url]" value="<?php if(isset($options['sc_int_ads_bg']['bg_url'])) echo $options['sc_int_ads_bg']['bg_url']; ?>" class="sc_img_url" type="text" />
					<input id="sc_int_ads_bg_button" class="button" data-insert="sc_img_url" type="button" value="Upload" />

					<div class="img-placement">
						<input type="radio" name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][img_placement]" id="<?php echo self::$int_option_name; ?>_imgstretch" <?php checked( $options['sc_int_ads_bg']['img_placement'], 'stretch' ); ?> value="stretch">
						<label for="<?php echo self::$int_option_name; ?>_imgstretch">Stretch Image</label>
						<br>
						<input type="radio" name="<?php echo self::$int_option_name; ?>[sc_int_ads_bg][img_placement]" id="<?php echo self::$int_option_name; ?>_imgrepeat" <?php checked( $options['sc_int_ads_bg']['img_placement'], 'repeat' ); ?> value="repeat">
						<label for="<?php echo self::$int_option_name; ?>_imgrepeat">Repeat Image</label>
					</div>
				</article>
			</div>
		</div>
		<?php
	}

	public function sc_int_ads_font_color_render(){
		$options = get_option(self::$int_option_name, array('sc_int_ads_font_color' => '#000000'));
		?>
		<input type="text" name="<?php echo self::$int_option_name; ?>[sc_int_ads_font_color]" value="<?php echo $options['sc_int_ads_font_color']; ?>" class="color-field" >
		<?php
	}

	public function sc_int_ads_max_width_render(){
		$options = get_option(self::$int_option_name, array('sc_int_ads_max_width' => '1400px'));
		?>
		<input type="text" id="max-int-px" readonly name="<?php echo self::$int_option_name; ?>[sc_int_ads_max_width]" value="<?php if(isset($options['sc_int_ads_max_width'])) echo $options['sc_int_ads_max_width']; ?>">

		<div id="max-int-px-slider" style="margin-top:10px;"></div>
		<?php
	}

	public function sc_int_ads_btn_render(){
		$options = get_option(self::$int_option_name);
		?>
		<input type="text" name="<?php echo self::$int_option_name; ?>[sc_int_ads_btn_text]" value="<?php if(isset($options['sc_int_ads_btn_text'])) echo $options['sc_int_ads_btn_text']; ?>">
		<span class="description">CTA Button Text</span>
		<br><br>
		<input type="text" name="<?php echo self::$int_option_name; ?>[sc_int_ads_btn_link]" value="<?php if(isset($options['sc_int_ads_btn_link'])) echo $options['sc_int_ads_btn_link']; ?>">
		<span class="description">CTA Button Link</span>
		<?php
	}

	public function sc_int_ads_content_render(){
		$options = get_option(self::$int_option_name, array('sc_int_ads_content' => 'Content Goes Here'));
		echo '<h4>Main Ad Content</h4>';
		echo wp_editor( $options['sc_int_ads_content'], 'sc_int_ads_content', array( 'textarea_name' => self::$int_option_name.'[sc_int_ads_content]', 'media_buttons' => true, 'textarea_rows' => 10, 'teeny' => false)  );
	}

	public function sc_int_ads_bottom_content_render(){
		$content_sections = array(
			'sc_int_ads_bl_content' => 'This section not required',
			'sc_int_ads_br_content' => 'This section not required'
		);
		$options = get_option(self::$int_option_name, $content_sections);
		echo '<div class="content-bottom-container"><div class="tab-content-sec left-sec">';
			echo '<h4>Bottom Left Content</h4>';
			echo wp_editor( $options['sc_int_ads_bl_content'], 'sc_int_ads_bl_content', array( 'textarea_name' => self::$int_option_name.'[sc_int_ads_bl_content]', 'media_buttons' => true, 'textarea_rows' => 6, 'teeny' => false)  );
		echo '</div><div class="tab-content-sec right-sec">';
			echo '<h4>Bottom Right Content</h4>';
			echo wp_editor( $options['sc_int_ads_br_content'], 'sc_int_ads_br_content', array( 'textarea_name' => self::$int_option_name.'[sc_int_ads_br_content]', 'media_buttons' => true, 'textarea_rows' => 6, 'teeny' => false)  );
		echo '</div></div>';
	}

	/*
	 * POPUP AD RENDER FUNCTIONS
	 */
	public function sc_popup_ads_enable_render(){
		$options = get_option(self::$popup_option_name);
		?>
		<input type="checkbox" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_enable]" <?php if(isset($options['sc_popup_ads_enable'])) checked( $options['sc_popup_ads_enable'], 1 ); ?> value="1">
		<span class="description">Turn popup ads on</span>
		<?php
	}

	public function sc_popup_ads_dev_mode_render(){
		$options = get_option(self::$popup_option_name);
		?>
		<input type="checkbox" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_dev_mode]" <?php if(isset($options['sc_popup_ads_dev_mode'])) checked( $options['sc_popup_ads_dev_mode'], 1 ); ?> value="1">
		<span class="description">Only show ad if logged in as admin. No cookie will be set</span>
		<?php
	}

	public function sc_popup_ads_pages_render(){
		$options = get_option(self::$popup_option_name);
		?>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][home]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][home]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][home]" <?php if(isset($options['sc_popup_ads_pages']['home'])) checked( $options['sc_popup_ads_pages']['home'], 1 ); ?> value="1">
			Home
		</label>
		<br>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][posts]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][posts]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][posts]" <?php if(isset($options['sc_popup_ads_pages']['posts'])) checked( $options['sc_popup_ads_pages']['posts'], 1 ); ?> value="1">
			Posts
		</label>
		<br>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][pages]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][pages]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][pages]" <?php if(isset($options['sc_popup_ads_pages']['pages'])) checked( $options['sc_popup_ads_pages']['pages'], 1 ); ?> value="1">
			Pages
		</label>
		<br>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][tags]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][tags]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][tags]" <?php if(isset($options['sc_popup_ads_pages']['tags'])) checked( $options['sc_popup_ads_pages']['tags'], 1 ); ?> value="1">
			Tag Pages
		</label>
		<br>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][categories]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][categories]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][categories]" <?php if(isset($options['sc_popup_ads_pages']['categories'])) checked( $options['sc_popup_ads_pages']['categories'], 1 ); ?> value="1">
			Category Pages
		</label>
		<br>
		<label for="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][authors]">
			<input type="checkbox" id="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][authors]" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_pages][authors]" <?php if(isset($options['sc_popup_ads_pages']['authors'])) checked( $options['sc_popup_ads_pages']['authors'], 1 ); ?> value="1">
			Author Pages
		</label>
		<?php
	}

	public function sc_popup_cookie_time_render(){
		$options = get_option(self::$popup_option_name, array('sc_popup_cookie_time' => 3600));
		?>
		<select name="<?php echo self::$popup_option_name; ?>[sc_popup_cookie_time]">
			<option value='1' <?php selected( $options['sc_popup_cookie_time'], 1 ); ?>>None</option>
			<option value='300' <?php selected( $options['sc_popup_cookie_time'], 300 ); ?>>5 Minutes</option>
			<option value='600' <?php selected( $options['sc_popup_cookie_time'], 600 ); ?>>10 Minutes</option>
			<option value='1800' <?php selected( $options['sc_popup_cookie_time'], 1800 ); ?>>30 Minutes</option>
			<option value='3600' <?php selected( $options['sc_popup_cookie_time'], 3600 ); ?>>1 Hour</option>
			<option value='21600' <?php selected( $options['sc_popup_cookie_time'], 21600 ); ?>>6 Hours</option>
			<option value='86400' <?php selected( $options['sc_popup_cookie_time'], 86400 ); ?>>1 Day</option>
			<option value='64800' <?php selected( $options['sc_popup_cookie_time'], 64800 ); ?>>1 Week</option>
			<option value='1209600' <?php selected( $options['sc_popup_cookie_time'], 1209600 ); ?>>2 Weeks</option>
			<option value='2592000' <?php selected( $options['sc_popup_cookie_time'], 2592000 ); ?>>1 Month</option>
			<option value='31536000' <?php selected( $options['sc_popup_cookie_time'], 31536000 ); ?>>1 Year</option>
		</select>
		<span class="description">Time until ad shows again for the user</span>
		<?php
	}

	public function sc_popup_ads_font_color_render(){
		$options = get_option(self::$popup_option_name, array('sc_popup_ads_font_color' => '#000000'));
		?>
		<input type="text" name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_font_color]" value="<?php echo $options['sc_popup_ads_font_color']; ?>" class="color-field" >
		<?php
	}

	public function sc_popup_ads_max_width_render(){
		$options = get_option(self::$popup_option_name, array('sc_popup_ads_max_width' => '700px'));
		?>
		<input type="text" id="max-popup-px" readonly name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_max_width]" value="<?php if(isset($options['sc_popup_ads_max_width'])) echo $options['sc_popup_ads_max_width']; ?>">

		<div id="max-popup-px-slider" style="margin-top:10px;"></div>
		<?php
	}

	public function sc_popup_ads_distance_from_top_render(){
		$options = get_option(self::$popup_option_name, array('sc_popup_ads_distance_from_top' => '100px'));
		?>
		<input type="text" id="popup-px-fromtop" readonly name="<?php echo self::$popup_option_name; ?>[sc_popup_ads_distance_from_top]" value="<?php echo (isset($options['sc_popup_ads_distance_from_top'])) ? $options['sc_popup_ads_distance_from_top'] : '100px'; ?>">

		<div id="popup-px-fromtop-slider" style="margin-top:10px;"></div>
		<?php
	}

	public function sc_popup_ads_content_render(){
		$options = get_option(self::$popup_option_name, array('sc_popup_ads_content' => 'Content Goes Here'));
		echo '<h4>Popup Ad Content</h4>';
		echo wp_editor( $options['sc_popup_ads_content'], 'sc_popup_ads_content', array( 'textarea_name' => self::$popup_option_name.'[sc_popup_ads_content]', 'media_buttons' => true, 'editor_height' => 400, 'teeny' => false)  );
	}

	/**
	 * returns description that shows under the setting title
	 * @return string [setting callback]
	 */
	public function sc_int_ads_section_callback(){
		echo __( 'Full screen ads that appear between pages', 'sc_ads' );
	}
	public function sc_popup_ads_section_callback(){
		echo __( 'If Intersitial ad is active on the same page as a popup ad, the interstitial will take precedence.
', 'sc_ads' );
	}
	public function sc_int_ads_content_section_callback(){
		echo __( 'HTML to use on Interstital Ad', 'sc_ads' );
	}
	public function sc_popup_ads_content_section_callback(){
		echo __( 'HTML to use on Popup Ad', 'sc_ads' );
	}
}
