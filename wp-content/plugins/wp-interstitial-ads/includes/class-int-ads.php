<?php

class Int_Ads{
	public static $current;
	public static $pagename;

	public function __construct(){
		require plugin_dir_path( INT_ADS_DIR ) . 'includes/class-int-ads-frontend.php';
		add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_scripts') );
		add_action( 'admin_menu', array($this, 'register_submenu') );
		add_action( 'wp_head', array($this, 'init_int_ads') );

		self::$current = ($_GET['tab'] === 'popup') ? 'popup' : 'interstitial';
		self::$pagename = 'interstitial-ads';
	}

	public function load_scripts(){
		wp_enqueue_script( 'cookies-js', plugins_url( '/assets/cookies.js', INT_ADS_DIR ), array(), '', true );
		wp_enqueue_style( 'wp-int-ad-css', plugins_url( '/assets/wp-int-ads.css', INT_ADS_DIR ) );
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

	public function load_admin_scripts(){
		wp_enqueue_script( 'word-count' );
		wp_enqueue_script('post');
		if ( user_can_richedit() )
			wp_enqueue_script('editor');
		add_thickbox();
		wp_enqueue_script('media-upload');

		// color picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_script( 'codemirror-js', plugins_url( '/assets/codemirror-compressed.js', INT_ADS_DIR ), false, false, true  );
		wp_enqueue_script( 'codemirror-closebrackets-js', plugins_url( '/assets/codemirror-closebrackets.js', INT_ADS_DIR ), false, false, true  );
		wp_enqueue_style( 'codemirror-css',  plugins_url( '/assets/codemirror.css', INT_ADS_DIR ) );

		wp_enqueue_script( 'intads-admin-js', plugins_url( '/assets/admin-scripts.js', INT_ADS_DIR ), array( 'jquery', 'wp-color-picker' ), false, true  );

		wp_enqueue_style( 'intads-admin-css',  plugins_url( '/assets/admin-style.css', INT_ADS_DIR ) );
	}

	public function write_ad_css($type='interstitial')
	{
		if ($type === 'interstitial') {
			$options = get_option('interstitial_ads_opts', Int_Ads::get_defaults());
			?>
			<style>
			.ad-container{
			    position: fixed;
			    z-index: 1000;
			    top: 0;
			    bottom: 0;
			    left: 0;
			    right: 0;
			    overflow: auto;
				padding-bottom: 40px;
			    background: #fff;
			    background-position: center;
			    <?php Int_Ads_Functions::create_bg_css($options['bg']); ?>
			}
			<?php echo $options['css']; ?>
			</style>
			<?php
		}
	}

	public function register_submenu() {
	    add_options_page(
	        'WP Interstitial Ads Options',
	        'WP Interstitial Ads',
	        'manage_options',
	        self::$pagename,
	        array($this, 'display_plugin_options')
	    );
	}
	public function display_plugin_options(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo '<div class="wrap">';
		echo '<h1>Interstitial Ads</h1>';

		echo '<h2 class="nav-tab-wrapper">';
		$tabs = array( 'interstitial' => 'Interstitial Ads', 'popup' => 'Popup Ads' );
		foreach ($tabs as $tab => $name) {
			$class = ( $tab == self::$current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab".$class."' href='?page=".self::$pagename."&tab=".$tab."'>".$name."</a>";
		}
		echo '</h2>';

		if (self::$current === 'popup') {
			require plugin_dir_path( INT_ADS_DIR ) . 'includes/options-popup.php';
		} else {
			require plugin_dir_path( INT_ADS_DIR ) . 'includes/options-intads.php';
		}

		echo '</div>';
	}

	public function check_page_active($pages){
		if(
			(is_home() && isset($pages['home'])) ||
			(is_single() && isset($pages['posts'])) ||
			(is_page() && isset($pages['pages'])) ||
			(is_tag() && isset($pages['tags'])) ||
			(is_category() && isset($pages['categories'])) ||
			(is_author() && isset($pages['authors']))
		){
			return true;
		}
	}

	public function check_ad_enabled($opts){
		if($opts['enable']){
			if ($opts['dev_mode'] && (is_user_logged_in() && current_user_can( 'manage_options' )) ) {
				return true;
			} elseif (!isset($opts['dev_mode'])) {
				return true;
			}
		}
	}

	public function check_int_active(){
		$opts = get_option('interstitial_ads_opts', self::get_defaults());
		$is_enabled = self::check_ad_enabled($opts);
		if (!isset($_COOKIE['_wp_int_ad']) && $is_enabled) {
			$type = 'int';
			$interstitials_active = true;
			$ads_page = $opts['page'];
			$page_active = self::check_page_active($ads_page);
		}
		return array(
			'interstitials_active' => $interstitials_active,
			'ads_page' => $ads_page,
			'ad_type' => $type,
			'page_active' => $page_active
		);
	}
	public function check_popup_active(){
		$opts = get_option('interstitial_popup_ads_opts', self::get_defaults());
		$is_enabled = self::check_ad_enabled($opts);
		if (!isset($_COOKIE['_wp_int_ad_popup']) && $is_enabled) {
			$type = 'popup';
			$popup_active = true;
			$ads_page = $opts['popup_page'];
			$page_active = self::check_page_active($ads_page);
		}
		return array(
			'interstitials_active' => $popup_active,
			'ads_page' => $ads_page,
			'ad_type' => $type,
			'page_active' => $page_active
		);
	}

	/*
	 * Init the front-end plugin
	 */
	public function init_int_ads(){
		$check_int = self::check_int_active();
		$check_popup = self::check_popup_active();

		if($check_int['page_active'] || $check_popup['page_active']){
			if($check_int['page_active']){
				self::write_ad_css('interstitial');
				add_action( 'wp_footer', array(Int_Ads_Frontend, 'full_screen_ad') );
			} else{
				// self::write_ad_css('popup');
				add_action( 'wp_footer', array(Int_Ads_Frontend, 'modal_ad') );
			}
		}
	}
}
