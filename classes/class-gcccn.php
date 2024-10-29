<?php
defined( 'GCCCN_DIR_PATH' ) or die( 'No script kiddies please!' );

class GCCCN {
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;
	
	protected $gcccnError;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	function __construct() {
		
		$this->plugin_name 	= 'gcccn';
		$this->version 		= GCCCN_VERSION;
		$this->load_dependencies();
		$this->set_locale();
		$this->register_admin_hooks();
		$this->register_front_hooks();

		/* Plugin activation hook for add default settings while activating plugin*/
		register_activation_hook( GCCCN_FILE, array($this, 'pluginActivation'));
		
		/* Plugin deactivation hook for do somthing while deactivating plugin. */
		register_deactivation_hook( GCCCN_FILE, array($this, 'pluginDeactivation'));

		add_filter( 'plugin_action_links_' . GCCCN_PLUGIN_BASENAME, array( $this, 'gcccn_action_links' ) );
		add_action( 'addMultiLangSupports', array( $this, 'addMultiLangSupportsAction' ) );
		add_action( 'wpml_loaded', array( $this, 'addMultiLangSupportsAction' ) );
	}
	

	public static function gcccn_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=ta_gcccn' ) . '" aria-label="' . esc_attr__( 'View Cookie Consent Settings', 'gcccn' ) . '">' . esc_html__( 'Settings', 'gcccn' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}	


	/**
	 * Plugin activation callback function
	 */
	public function pluginActivation(){
		do_action('addMultiLangSupports');
	}
	
	/**
	 * Plugin deactivation callback function
	 */
	public function pluginDeactivation(){
		
	}

	/**
	 * Add multi language support. Like WPML and Polylang
	 */
	public function addMultiLangSupportsAction(){
		global $sitepress;
		$polylangLang = get_option( 'polylang' );

		if (isset($polylangLang) && ( function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language' ))) {
				$getLanguagesNameList = pll_languages_list(['fields'=>'name']);
			    $getLanguagesSlugList = pll_languages_list(['fields'=>'slug']);
			    $getLanguagesList = array_combine( $getLanguagesSlugList, $getLanguagesNameList);
			    if($getLanguagesList){ 
			    	foreach ( $getLanguagesList as $langSlug => $langName) {
					add_option('gcccn_main_message_'.$langSlug,'This website uses cookies to ensure you get the best experience on our website.');
					add_option('gcccn_policy_link_text_'.$langSlug,'Learn More');
					add_option('gcccn_dismiss_button_text_'.$langSlug,'Got it!');
					add_option('gcccn_cookie_policy_url_type_'.$langSlug,'custom_link');
					add_option('gcccn_url_cookie_policy_link_'.$langSlug,'https://www.yoursite.com/cookie-policy/');
					add_option('gcccn_open_new_tab_'.$langSlug,'yes');
					add_option('gcccn_cookie_expiry_duration_'.$langSlug, '365' );

					add_option('gcccn_popup_hide_pages_'.$langSlug, '' );
					$gcccnPreviewOptions = '{"border":"thin","corners":"normal","colors": {"popup":{"background": "#f6f6f6", "text": "#000000", "border": "#555555"},"button": {"background": "#555555", "text": "#ffffff"}}, "position":"bottom-left","padding":"large","margin": "small","transparency": "5","fontsize" :"default"}';
						add_option('gcccn_layout_configuration_'.$langSlug,$gcccnPreviewOptions);
				}
			} 
		}
		elseif ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) &&(function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' )))
		 {
		 	$codeAndName = [];
			$allAvailbleLanguage = icl_get_languages('skip_missing=0');
	    	foreach ($allAvailbleLanguage as $mbLangSlug => $mbLangName) {
	      		//$codeAndName[$mbLangSlug] = $mbLangName['display_name'];
	      		$codeAndName[] = $mbLangSlug;
	    	}
		    if($codeAndName){
		    	/*foreach ( $getLanguagesList as $langSlug => $langName) {*/
		    	foreach ( $codeAndName as $mbLangKey => $langSlug) {
		    		add_option('gcccn_main_message_'.$langSlug,'This website uses cookies to ensure you get the best experience on our websites.');
					add_option('gcccn_policy_link_text_'.$langSlug,'Learn More');
					add_option('gcccn_dismiss_button_text_'.$langSlug,'Got it!');
					add_option('gcccn_cookie_policy_url_type_'.$langSlug,'custom_link');
					add_option('gcccn_url_cookie_policy_link_'.$langSlug,'https://www.yoursite.com/cookie-policy/');
					add_option('gcccn_open_new_tab_'.$langSlug,'yes');
					add_option('gcccn_cookie_expiry_duration_'.$langSlug, '365' );

					add_option('gcccn_popup_hide_pages_'.$langSlug, '' );
					$gcccnPreviewOptions = '{"border":"thin","corners":"normal","colors": {"popup":{"background": "#f6f6f6", "text": "#000000", "border": "#555555"},"button": {"background": "#555555", "text": "#ffffff"}}, "position":"bottom-left","padding":"large","margin": "small","transparency": "5","fontsize" :"default"}';
					add_option('gcccn_layout_configuration_'.$langSlug,$gcccnPreviewOptions);		
	    		}
    		}
		}
		else{
			add_option('gcccn_main_message','This website uses cookies to ensure you get the best experience on our website.');
			add_option('gcccn_policy_link_text','Learn More');
			add_option('gcccn_dismiss_button_text','Got it!');
			add_option('gcccn_cookie_policy_url_type','custom_link');
			add_option('gcccn_url_cookie_policy_link','https://www.yoursite.com/cookie-policy/');
			add_option('gcccn_open_new_tab','yes');
			add_option('gcccn_cookie_expiry_duration', '365' );
			add_option('gcccn_popup_hide_pages', '' );
			$gcccnPreviewOptions = '{"border":"thin","corners":"normal","colors": {"popup":{"background": "#f6f6f6", "text": "#000000", "border": "#555555"},"button": {"background": "#555555", "text": "#ffffff"}}, "position":"bottom-left","padding":"large","margin": "small","transparency": "5","fontsize" :"default"}';
			add_option('gcccn_layout_configuration',$gcccnPreviewOptions);
		}
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function load_dependencies() {
		require_once GCCCN_DIR_PATH . 'classes/class-gcccn-i18n.php';
		require_once GCCCN_DIR_PATH . 'classes/class-gcccn-admin.php';
		require_once GCCCN_DIR_PATH . 'classes/class-gcccn-front.php';
	}
	
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the BSR_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function set_locale() {
		$gcccn_i18n = new GCCCN_LOAD_TEXT_DOMAIN();
		$gcccn_i18n->set_domain( $this->plugin_name );
	}
	
	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function register_admin_hooks() {
		$gcccn_admin = new GCCCN_ADMIN( $this->plugin_name, $this->version );		
	}

	/**
	 * Register all of the hooks related to the front-end functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function register_front_hooks() {
		$gcccn_front = new GCCCN_FRONT();
	}
}