<?php

class SC_Ads_Admin{
	public static $pagename;

	public function __construct($opts){
		self::$pagename = 'sc-ads';

		add_action( 'admin_init', array($opts, 'sc_ads_settings_init') );
		add_action( 'admin_menu', array($this, 'register_submenu') );
	}

	public function get_defaults(){
		return array(
			'timer' => 5,
			'cookie_duration' => 1,
			'content' => 'Ad content goes here!',
			'popup_content' => 'Ad content goes here!',
			'css' => '.int-ad-content{'. PHP_EOL
			.'  color: #eee;'. PHP_EOL
			.'}',
			'bg' => array(
				'type' => 'color',
				'background_color' => '#FFFFFF',
				'image_size' => 'stretch'
			),
			'content_layout' => 'layout1'
		);
	}

	public function load_admin_scripts($hook){
		global $sc_settings_page;
		if( $hook != $sc_settings_page )
			return;

		wp_enqueue_script( 'word-count' );
		wp_enqueue_script('post');
		if ( user_can_richedit() ){
			wp_enqueue_script('editor');
		}
		add_thickbox();
		wp_enqueue_script('media-upload');
		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'jquery-ui-slider');
		wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'jquery-effects-core');
		wp_enqueue_script( 'jquery-effects-slide');
		wp_enqueue_style( 'jquery-ui-style', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');

		// Codemirror
		// wp_enqueue_script( 'codemirror-js', plugins_url( '/assets/codemirror-compressed.js', SC_ADS_DIR ), false, false, true  );
		// wp_enqueue_script( 'codemirror-closebrackets-js', plugins_url( '/assets/codemirror-closebrackets.js', SC_ADS_DIR ), false, false, true  );
		// wp_enqueue_style( 'codemirror-css',  plugins_url( '/assets/codemirror.css', SC_ADS_DIR ) );

		// Admin Assets
		wp_enqueue_script( 'sc-ads-admin-js', plugins_url( '/assets/admin-scripts.js', SC_ADS_DIR ), array( 'jquery', 'wp-color-picker' ), false, true  );
		wp_enqueue_style( 'sc-ads-admin-css',  plugins_url( '/assets/admin-style.css', SC_ADS_DIR ) );
	}

	public function register_submenu() {
		global $sc_settings_page;
		$sc_settings_page = add_options_page(
			'Supercool Ads Options',
			'Supercool Ads',
			'manage_options',
			self::$pagename,
			array($this, 'display_plugin_options')
		);
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_scripts') );
	}

	public function display_plugin_options(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		?>
		<div class="wrap">
			<h1>Supercool Ads</h1>
			<form action="options.php" method="post">
				<div id="sc-tabs">
					<ul class="nav-tab-wrapper sc-ad-tabs">
					<?php
					$active_tab = (isset($_GET['active-tab'])) ? $_GET['active-tab'] : 'interstitial';
					$tabs = array( 'interstitial' => 'Interstitial Ad', 'popup' => 'Popup Ad' );
					foreach ($tabs as $tab => $name) {
						$is_active = ($active_tab === $tab) ? ' active' : '';
						echo "<li><a class='nav-tab".$is_active."' href='/wp-admin/options-general.php?page=sc-ads&active-tab=".$tab."'>".$name."</a></li>";
					}
					?>
					</ul>
					<?php if($active_tab === 'interstitial'): ?>
					<div class="sc-ad-tab-content" id="tab-interstitial">
						<div class="tab-content-sec left-sec">
							<?php
							settings_fields('sc_int_ads_options_group');
							do_settings_sections('sc_int_ads_options_group');
							?>
						</div>
						<div class="tab-content-sec right-sec">
							<?php
							settings_fields('sc_int_ads_content_group');
							do_settings_sections('sc_int_ads_content_group');
							?>
						</div>
					</div>
					<?php else: ?>
					<div class="sc-ad-tab-content" id="tab-popup">
						<div class="tab-content-sec left-sec">
							<?php
							settings_fields('sc_popup_ads_options_group');
							do_settings_sections('sc_popup_ads_options_group');
							?>
						</div>
						<div class="tab-content-sec right-sec">
							<?php
							settings_fields('sc_popup_ads_content_group');
							do_settings_sections('sc_popup_ads_content_group');
							?>
						</div>
					</div>
					<?php endif; ?>
				</div><!--#sc-tabs-->
				<div class="submit">
					<input type="hidden" id="active-tab" name="active-tab" value="">
					<?php submit_button(); ?>
				</div>
			</form>
		</div><!--.wrap-->
		<?php
	}
}
