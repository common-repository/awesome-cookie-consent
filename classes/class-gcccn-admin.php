<?php 
defined( 'GCCCN_DIR_PATH' ) or die( 'No script kiddies please!' );

class GCCCN_ADMIN{
	
	private $textDomain;
	
	private $version;

	public function __construct( $textDomain, $version ) {
		$this->textDomain = $textDomain;
		$this->version = $version;
		add_action( 'admin_init', array( $this,  'save_gcccn_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'gcccn_menu_pages' ) );
	}
	
	public function enqueue_scripts( $hook ) {
		if ( 'settings_page_ta_gcccn' === $hook ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'gcccn-select2', GCCCN_ASSETS_URL . 'css/select2.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'gcccn-admin', GCCCN_ASSETS_URL . 'css/gcccn-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'gcccn-front', GCCCN_ASSETS_URL . 'css/gcccn-front.css', array(), $this->version, 'all' );			
			
			wp_enqueue_script ( 'wp-color-picker' );
			wp_enqueue_script(  'gcccn-select2', GCCCN_ASSETS_URL . 'js/select2.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script(  'gcccn-admin', GCCCN_ASSETS_URL . 'js/gcccn-admin.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script(  'gcccn-front', GCCCN_ASSETS_URL . 'js/gcccn-front.js', array( 'jquery' ), $this->version, true );

			global $sitepress;
			$polylangLang = get_option( 'polylang' );

    		if ( isset($polylangLang['default_lang']) && ( function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language' ))) {
    			$getCurrentLangSlug = pll_current_language('slug');
				$defaultLang = pll_default_language(); 

				$getGccnCurrentLangSlug = $defaultLang;
			    if(isset($_GET['section'])){
						$getGccnCurrentLangSlug = $_GET['section'];
				}
				if($getCurrentLangSlug){
			    	$getGccnCurrentLangSlug = $getCurrentLangSlug;
			    } 


			    add_option('gcccn_main_message_'.$getGccnCurrentLangSlug,'This website uses cookies to ensure you get the best experience on our website.');
					add_option('gcccn_policy_link_text_'.$getGccnCurrentLangSlug,'Learn More');
					add_option('gcccn_dismiss_button_text_'.$getGccnCurrentLangSlug,'Got it!');
					add_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug,'custom_link');
					add_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug,'https://www.yoursite.com/cookie-policy/');
					add_option('gcccn_open_new_tab_'.$getGccnCurrentLangSlug,'yes');
					add_option('gcccn_cookie_expiry_duration_'.$getGccnCurrentLangSlug, '365' );

					add_option('gcccn_popup_hide_pages_'.$getGccnCurrentLangSlug, '' );
					$gcccnPreviewOptions = '{"border":"thin","corners":"normal","colors": {"popup":{"background": "#f6f6f6", "text": "#000000", "border": "#555555"},"button": {"background": "#555555", "text": "#ffffff"}}, "position":"bottom-left","padding":"large","margin": "small","transparency": "5","fontsize" :"default"}';
						add_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug,$gcccnPreviewOptions);


				$openInTab =  ( get_option('gcccn_open_new_tab_'.$getGccnCurrentLangSlug) == 'yes' ) ? "_blank" : "_self";
				$cookiePolicyUrl = ( get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug) == "custom_link" ) ? get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug) : get_the_permalink( get_option('gcccn_url_cookie_policy_option_'.$getGccnCurrentLangSlug) );
				$displayLinkText = (get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug) == 'custom_link' && get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug) == '')?  '' : get_option('gcccn_policy_link_text_'.$getGccnCurrentLangSlug);
				$gcccn_main_message = get_option('gcccn_main_message_'.$getGccnCurrentLangSlug);
				$gcccn_dismiss_button_text = get_option('gcccn_dismiss_button_text_'.$getGccnCurrentLangSlug);
				$gcccn_layout_configuration = get_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug);
			}
			elseif ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) && (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {
				$getCurrentLangSlug = ICL_LANGUAGE_CODE;
				$defaultLang = $sitepress->get_default_language();
				$getGccnCurrentLangSlug = $defaultLang;
			   
				if($getCurrentLangSlug != 'all' ){
			    	$getGccnCurrentLangSlug = $getCurrentLangSlug;
			    }elseif($getCurrentLangSlug == "all" && isset($_GET['section']) && $_GET['section'] != '' ){
					$getGccnCurrentLangSlug = $_GET['section'];
							
				}else{
					$getGccnCurrentLangSlug = $defaultLang;
				}
				$openInTab =  ( get_option('gcccn_open_new_tab_'.$getGccnCurrentLangSlug) == 'yes' ) ? "_blank" : "_self";
				$cookiePolicyUrl = ( get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug) == "custom_link" ) ? get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug) : get_the_permalink( get_option('gcccn_url_cookie_policy_option_'.$getGccnCurrentLangSlug) );
				$displayLinkText = (get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug) == 'custom_link' && get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug) == '')?  '' : get_option('gcccn_policy_link_text_'.$getGccnCurrentLangSlug);
				$gcccn_main_message = get_option('gcccn_main_message_'.$getGccnCurrentLangSlug);
				$gcccn_dismiss_button_text = get_option('gcccn_dismiss_button_text_'.$getGccnCurrentLangSlug);
				$gcccn_layout_configuration = get_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug);
			}
			else {
				$openInTab =  ( get_option('gcccn_open_new_tab') == 'yes' ) ? "_blank" : "_self";
				$cookiePolicyUrl = ( get_option('gcccn_cookie_policy_url_type') == "custom_link" ) ? get_option('gcccn_url_cookie_policy_link') : get_the_permalink( get_option('gcccn_url_cookie_policy_option') );
				$displayLinkText = (get_option('gcccn_cookie_policy_url_type') == 'custom_link' && get_option('gcccn_url_cookie_policy_link') == '')?  '' : get_option('gcccn_policy_link_text');
				$gcccn_main_message = get_option('gcccn_main_message');
				$gcccn_dismiss_button_text = get_option('gcccn_dismiss_button_text');
				$gcccn_layout_configuration = get_option("gcccn_layout_configuration");
			}

			$cookie_consent_popup_data = array(
				'gcccn_main_message' => $gcccn_main_message,
				'gcccn_policy_link_text' => $displayLinkText,
				'gcccn_dismiss_button_text' => $gcccn_dismiss_button_text,
				'gcccn_url_cookie_policy' => $cookiePolicyUrl,
				'gcccn_open_new_tab' => $openInTab,
				'gcccn_layout_configuration' => $gcccn_layout_configuration
			);
			wp_localize_script( 'gcccn-admin', 'cookie_consent_popup_object',$cookie_consent_popup_data  );
		}
	}

	public function gcccn_menu_pages() {
		add_submenu_page( 'options-general.php', __( GCCCN_NAME, 'gcccn' ), __( 'Awesome Cookie Consent', 'gcccn' ), 'manage_options', 'ta_'.$this->textDomain, array( $this, 'gcccn_menu_pages_callback' ) );
	}
	
	public function gcccn_menu_pages_callback() {
		$active_tab = 'gcccn-genral-settings';	
 		if( isset( $_GET[ 'tab' ] ) ) {
        	$active_tab = $_GET[ 'tab' ];
        }       
        if( $active_tab == 'gcccn-layout-configuration') {
			require_once GCCCN_DIR_PATH . 'templates/gcccn-layout-configuration.php';
		}
		else if ( $active_tab == 'gcccn-cookie-consent-text' ) {			
			require_once GCCCN_DIR_PATH . 'templates/gcccn-cookie-consent-text.php';
		} else {
			require_once GCCCN_DIR_PATH . 'templates/gcccn-general-settings.php'; 
		}
	}

	public function save_gcccn_settings() {

		global $sitepress;
		$polylangLang = get_option( 'polylang' );
		if ( isset($polylangLang['default_lang']) && ( function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language' ))) {
			$getCurrentLangSlug = pll_current_language('slug');
			$defaultLang = pll_default_language(); 
			$getLanguagesNameList = pll_languages_list(['fields'=>'name']);
		    $getLanguagesSlugList = pll_languages_list(['fields'=>'slug']);
		    $getLanguagesList = array_combine( $getLanguagesSlugList, $getLanguagesNameList);
		    if($getLanguagesList){ 
		    	foreach ( $getLanguagesList as $langSlug => $langName) {
		    		register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_discourage_cookie_consent_'.$langSlug );
	 				register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_cookie_expiry_duration_'.$langSlug );
	 				register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_popup_hide_pages_'.$langSlug);

	 				register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_main_message_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_dismiss_button_text_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_policy_link_text_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_cookie_policy_url_type_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_url_cookie_policy_link_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_url_cookie_policy_option_'.$langSlug );
			 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_open_new_tab_'.$langSlug );

			 		register_setting( 'gcccn_layout_configuration_group_'.$langSlug, 'gcccn_layout_configuration_'.$langSlug );
		    	}

	    	} 
		}
		elseif ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) && (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {

			$allAvailbleLanguage = icl_get_languages('skip_missing=0');
		    foreach ($allAvailbleLanguage as $key => $value) {
		      $codeAndName[$key] = $value['translated_name'];
		    }
		    foreach ( $codeAndName as $langSlug => $langName) {
		    	register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_discourage_cookie_consent_'.$langSlug );
	 			register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_cookie_expiry_duration_'.$langSlug );
	 			register_setting( 'gcccn_genral_settings_group_'.$langSlug, 'gcccn_popup_hide_pages_'.$langSlug);
 				register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_main_message_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_dismiss_button_text_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_policy_link_text_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_cookie_policy_url_type_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_url_cookie_policy_link_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_url_cookie_policy_option_'.$langSlug );
		 		register_setting( 'gcccn_cookie_Consent_text_group_'.$langSlug, 'gcccn_open_new_tab_'.$langSlug );
		 		register_setting( 'gcccn_layout_configuration_group_'.$langSlug, 'gcccn_layout_configuration_'.$langSlug );
		    
			}
		}
		else {
			register_setting( 'gcccn_genral_settings_group', 'gcccn_discourage_cookie_consent' );
	 		register_setting( 'gcccn_genral_settings_group', 'gcccn_cookie_expiry_duration' );
	 		register_setting( 'gcccn_genral_settings_group', 'gcccn_popup_hide_pages');
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_main_message' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_dismiss_button_text' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_policy_link_text' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_cookie_policy_url_type' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_url_cookie_policy_link' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_url_cookie_policy_option' );
	 		register_setting( 'gcccn_cookie_Consent_text_group', 'gcccn_open_new_tab' );
	 		register_setting( 'gcccn_layout_configuration_group', 'gcccn_layout_configuration' );
	    }
 	}
}