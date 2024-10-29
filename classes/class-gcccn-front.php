<?php 
defined( 'GCCCN_DIR_PATH' ) or die( 'No script kiddies please!' );

class GCCCN_FRONT{
		
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $textDomain   The text domain of this plugin.
	 */
	private $textDomain;
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;	
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $better_search_replace       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct() {
		$this->version 	= GCCCN_VERSION;
		add_action( 'wp_enqueue_scripts', array( $this, 'gcccn_enqueue_scripts' ) );
	}
	
	/**
	 * Register any CSS and JS used by the plugin.
	 * @since    1.0.0
	 * @access 	 public
	 * @param    string $hook Used for determining which page(s) to load our scripts.
	 */
	public function gcccn_enqueue_scripts() {
		global $sitepress;
		$polylangLang = get_option( 'polylang' );
		if ( isset($polylangLang['default_lang']) && ( function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language' ))) {
			$gcccn_current_lanhuage_slug = pll_current_language('slug');
			$getPagesNotDisplayPopup = get_option('gcccn_popup_hide_pages_'.$gcccn_current_lanhuage_slug);

			if($getPagesNotDisplayPopup == '' || !in_array(get_the_ID(), $getPagesNotDisplayPopup)){
				if(get_option( 'gcccn_discourage_cookie_consent_'.$gcccn_current_lanhuage_slug) !== 'yes' ){
					if(!isset($_COOKIE['gcccn-status'])) {
						$minFiles = ( GCCCN_ENVIRONMENT == 'P' ) ? '.min' : '';
						wp_enqueue_style( 'gcccn-front', GCCCN_ASSETS_URL . 'css/gcccn-front'.$minFiles.'.css', array(), $this->version, 'all' );	
						wp_enqueue_script( 'gcccn-front', GCCCN_ASSETS_URL . 'js/gcccn-front'.$minFiles.'.js', array( 'jquery' ), $this->version, true );
						wp_add_inline_script( 'gcccn-front', "window.addEventListener('load', function(){window.gcccn.init(".get_option("gcccn_layout_configuration_".$gcccn_current_lanhuage_slug).")});", 'after' );
						if($gcccn_current_lanhuage_slug){
							if(get_option('gcccn_open_new_tab_'.$gcccn_current_lanhuage_slug) == 'yes'){
								$openInTab = "_blank";
							}else{
								$openInTab = "_self";
							}
							if(get_option("gcccn_cookie_policy_url_type_".$gcccn_current_lanhuage_slug) == "custom_link"){
								$cookiePolicyUrl = get_option('gcccn_url_cookie_policy_link_'.$gcccn_current_lanhuage_slug);
							}else{
								$cookiePolicyUrl = get_the_permalink(get_option('gcccn_url_cookie_policy_option_'.$gcccn_current_lanhuage_slug));
							}

							if(get_option('gcccn_cookie_policy_url_type_'.$gcccn_current_lanhuage_slug) == 'custom_link' && get_option('gcccn_url_cookie_policy_link_'.$gcccn_current_lanhuage_slug) == ''){
								$displayLinkText = '';
							}else{
								$displayLinkText = get_option('gcccn_policy_link_text_'.$gcccn_current_lanhuage_slug);
							}

							$gcccn_main_message = get_option('gcccn_main_message_'.$gcccn_current_lanhuage_slug);
							$gcccn_cookie_expiry_duration = get_option("gcccn_cookie_expiry_duration_".$gcccn_current_lanhuage_slug);
							$gcccn_dismiss_button_text = get_option('gcccn_dismiss_button_text_'.$gcccn_current_lanhuage_slug);
						}
						$cookie_consent_popup_data = array(
							'gcccn_main_message' => $gcccn_main_message,
							'gcccn_policy_link_text' => $displayLinkText,
							'gcccn_dismiss_button_text' => $gcccn_dismiss_button_text,
							'gcccn_url_cookie_policy' => $cookiePolicyUrl,
							'gcccn_open_new_tab' => $openInTab,
							'gcccn_cookie_expiry_duration' => $gcccn_cookie_expiry_duration
						);
						wp_localize_script( 'gcccn-front', 'cookie_consent_popup_object',$cookie_consent_popup_data  );
					}
				}
			}
		}else if ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) && (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {
			$gcccn_current_lanhuage_slug = ICL_LANGUAGE_CODE;
			$getPagesNotDisplayPopup = get_option('gcccn_popup_hide_pages_'.$gcccn_current_lanhuage_slug);
		
			if($getPagesNotDisplayPopup == '' || !in_array(get_the_ID(), $getPagesNotDisplayPopup)){
				if(get_option( 'gcccn_discourage_cookie_consent_'.$gcccn_current_lanhuage_slug) !== 'yes' ){
					if(!isset($_COOKIE['gcccn-status'])) {
						$minFiles = ( GCCCN_ENVIRONMENT == 'P' ) ? '.min' : '';
						wp_enqueue_style( 'gcccn-front', GCCCN_ASSETS_URL . 'css/gcccn-front'.$minFiles.'.css', array(), $this->version, 'all' );	
						wp_enqueue_script( 'gcccn-front', GCCCN_ASSETS_URL . 'js/gcccn-front'.$minFiles.'.js', array( 'jquery' ), $this->version, true );
						wp_add_inline_script( 'gcccn-front', "window.addEventListener('load', function(){window.gcccn.init(".get_option("gcccn_layout_configuration_".$gcccn_current_lanhuage_slug).")});", 'after' );

						if($gcccn_current_lanhuage_slug){
							if(get_option('gcccn_open_new_tab_'.$gcccn_current_lanhuage_slug) == 'yes'){
								$openInTab = "_blank";
							}else{
								$openInTab = "_self";
							}
							if(get_option("gcccn_cookie_policy_url_type_".$gcccn_current_lanhuage_slug) == "custom_link"){
								$cookiePolicyUrl = get_option('gcccn_url_cookie_policy_link_'.$gcccn_current_lanhuage_slug);
							}else{
								$cookiePolicyUrl = get_the_permalink(get_option('gcccn_url_cookie_policy_option_'.$gcccn_current_lanhuage_slug));
							}			
							if(get_option('gcccn_cookie_policy_url_type_'.$gcccn_current_lanhuage_slug) == 'custom_link' && get_option('gcccn_url_cookie_policy_link_'.$gcccn_current_lanhuage_slug) == ''){
								$displayLinkText = '';
							}else{
								$displayLinkText = get_option('gcccn_policy_link_text_'.$gcccn_current_lanhuage_slug);
							}

							$gcccn_main_message = get_option('gcccn_main_message_'.$gcccn_current_lanhuage_slug);
							$gcccn_cookie_expiry_duration = get_option("gcccn_cookie_expiry_duration_".$gcccn_current_lanhuage_slug);
							$gcccn_dismiss_button_text = get_option('gcccn_dismiss_button_text_'.$gcccn_current_lanhuage_slug);
						}
						$cookie_consent_popup_data = array(
							'gcccn_main_message' => $gcccn_main_message,
							'gcccn_policy_link_text' => $displayLinkText,
							'gcccn_dismiss_button_text' => $gcccn_dismiss_button_text,
							'gcccn_url_cookie_policy' => $cookiePolicyUrl,
							'gcccn_open_new_tab' => $openInTab,
							'gcccn_cookie_expiry_duration' => $gcccn_cookie_expiry_duration
						);
						wp_localize_script( 'gcccn-front', 'cookie_consent_popup_object',$cookie_consent_popup_data  );
					}
				}
			}
		}else{
			$getPagesNotDisplayPopup = get_option('gcccn_popup_hide_pages');
			if($getPagesNotDisplayPopup == '' || !in_array(get_the_ID(), $getPagesNotDisplayPopup)){
				if(get_option( 'gcccn_discourage_cookie_consent') !== 'yes' ){
					if(!isset($_COOKIE['gcccn-status'])) {
						$minFiles = ( GCCCN_ENVIRONMENT == 'P' ) ? '.min' : '';
						wp_enqueue_style( 'gcccn-front', GCCCN_ASSETS_URL . 'css/gcccn-front'.$minFiles.'.css', array(), $this->version, 'all' );
						wp_enqueue_script( 'gcccn-front', GCCCN_ASSETS_URL . 'js/gcccn-front'.$minFiles.'.js', array( 'jquery' ), $this->version, true );
						wp_add_inline_script( 'gcccn-front', "window.addEventListener('load', function(){window.gcccn.init(".get_option("gcccn_layout_configuration").")});", 'after' );
						if(get_option('gcccn_open_new_tab') == 'yes'){
							$openInTab = "_blank";
						}else{
							$openInTab = "_self";
						}
						if(get_option("gcccn_cookie_policy_url_type") == "custom_link"){
							$cookiePolicyUrl = get_option('gcccn_url_cookie_policy_link');
						}else{
							$cookiePolicyUrl = get_the_permalink(get_option('gcccn_url_cookie_policy_option'));
						}

						if(get_option('gcccn_cookie_policy_url_type') == 'custom_link' && get_option('gcccn_url_cookie_policy_link') == ''){
							$displayLinkText = '';
						}else{
							$displayLinkText = get_option('gcccn_policy_link_text');
						}

						$cookie_consent_popup_data = array(
							'gcccn_main_message' => get_option('gcccn_main_message'),
							'gcccn_policy_link_text' => $displayLinkText,
							'gcccn_dismiss_button_text' => get_option('gcccn_dismiss_button_text'),
							'gcccn_url_cookie_policy' => $cookiePolicyUrl,
							'gcccn_open_new_tab' => $openInTab,
							'gcccn_cookie_expiry_duration' => get_option("gcccn_cookie_expiry_duration")
						);
						wp_localize_script( 'gcccn-front', 'cookie_consent_popup_object',$cookie_consent_popup_data  );

					}
				}
			}
		}
	}
}