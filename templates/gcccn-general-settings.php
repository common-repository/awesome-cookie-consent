<?php
global $sitepress;
$polylangLang = get_option( 'polylang' );

if (isset($polylangLang['default_lang']) && (function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language'))) {
    $getCurrentLangSlug = pll_current_language('slug');
    $getCurrentLangName = pll_current_language('name');
    $getLanguagesNameList = pll_languages_list(['fields'=>'name']);
    $getLanguagesSlugList = pll_languages_list(['fields'=>'slug']);
    $getLanguagesList = array_combine( $getLanguagesSlugList, $getLanguagesNameList);
    $getAllLang = pll_languages_list();
    $defaultLang = pll_default_language(); 
    $defaultLang2 = $defaultLang;
    
    if(isset($_GET['section'])){
			$defaultLang2 = $_GET['section'];
	}
	if($getCurrentLangSlug){
    	$defaultLang2 = $getCurrentLangSlug;
    } 
?>
    <div class="wrap">
        <h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
        <nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
            <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$defaultLang2 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'General Settings', 'gcccn' ); ?></a>
            <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2 ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
            <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$defaultLang2 ); ?>" class="nav-tab"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
        </nav>
        <?php
        if($getCurrentLangSlug){
            $getGccnCurrentLangSlug = $getCurrentLangSlug;
        ?>
            <h2><?php _e('Selected Language is - ', 'gcccn'); echo $getCurrentLangName;  ?></h2>
        <?php } else { ?>
		<ul class="displaysubmenu">
		    <?php
		    	foreach ( $getLanguagesList as $langSlug => $langName) {
		    		
		    		$cActive = '';
		    		if(isset($_GET['section'])){
		    			if( $langSlug == $_GET['section'] ){
		    				$cActive = 'b polySection';
		    				$getGccnCurrentLangSlug = $langSlug;
		    			}
		    		} else {
		    			if( $langSlug == $defaultLang ){
		    				$cActive = 'b polyDefaultLang';
		    				$getGccnCurrentLangSlug = $langSlug;
		    			}
		    		}

		        ?>
		    	<li>
		        	<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$langSlug); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
		    	</li>
		    	<?php	
		        }
		        ?>
		</ul>
	<?php } ?>
	 	
    <form method="post" action="options.php">
        <?php settings_fields( 'gcccn_genral_settings_group_'.$getGccnCurrentLangSlug ); ?>
        <table class="form-table" role="presentation">
            <tbody>
                <tr class="option-site-visibility">
                    <th scope="row"><?php _e( 'Cookie Consent Visibility','gcccn');?> </th>
                    <td>
                        <fieldset>
                            <label for="gcccn_discourage_cookie_consent">
                            <input name="gcccn_discourage_cookie_consent_<?php echo $getGccnCurrentLangSlug; ?>" type="checkbox" id="gcccn_discourage_cookie_consent" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_discourage_cookie_consent_'.$getGccnCurrentLangSlug ), false ); ?> ><?php _e( 'If checked then Cookie Consent popup is hide.','gcccn');?>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr class="option-site-visibility">
                    <th scope="row"><label for="gcccn_cookie_expiry_duration"><?php _e( 'Cookie Expiry Duration','gcccn');?></label></th>
                    <td>
                        <?php 
                            $cookieExpiryDurations = array(
                            	1 	=> __( '1 day','gcccn'), 
                            	7 	=> __( '1 week','gcccn'), 
                            	30	=> __( '1 Month','gcccn'),
                            	90	=> __( '3 Months','gcccn'), 
                            	180	=> __( '6 Months','gcccn'),
                            	365	=> __( '1 Year', 'gcccn')
                            );
                            ?>
                        <select name="gcccn_cookie_expiry_duration_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_cookie_expiry_duration">
                        <?php
                            foreach ( $cookieExpiryDurations as $cookieExpiryValue => $cookieExpiryLabel ){
                            	echo '<option value="'.$cookieExpiryValue.'" '.selected( get_option( "gcccn_cookie_expiry_duration_".$getGccnCurrentLangSlug ), $cookieExpiryValue, false ).'>'. $cookieExpiryLabel .'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="hide_popup_pages">
                    <th><label for="gcccn_popup_hide_pages[]"><?php _e( 'Select pages for hide popup','gcccn');?></label></th>
                    <td>
                        <select name="gcccn_popup_hide_pages_<?php echo $getGccnCurrentLangSlug; ?>[]" id="gcccn_popup_hide_pages"  multiple="multiple">
                            <option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
                            <?php
                                $getPopupHidePagesValue = get_option( 'gcccn_popup_hide_pages_'.$getGccnCurrentLangSlug );
                                $popupHidePages = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'page', 'post_status' => 'publish','lang' => $getGccnCurrentLangSlug ) );
                                if($popupHidePages){
                                    foreach( $popupHidePages as $popupHidePage ){
                                        if($getPopupHidePagesValue){
                                            $selectedPages = in_array( $popupHidePage->ID, $getPopupHidePagesValue ) ? 'selected' : '';     
                                        } else {
                                            $selectedPages = '';
                                        }
                                        echo '<option '.$selectedPages.' value="'.$popupHidePage->ID.'">'.$popupHidePage->post_title.'</option>';
                                    }
                                }
                                ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="btns">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes','gcccn'); ?>">
        </div>
    </form>
</div>
<?php
}
else if ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) &&  (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {

    $defaultLang = $sitepress->get_default_language();
    $getGccnCurrentLangSlug1 = ICL_LANGUAGE_CODE;
    $defaultLang2 = $defaultLang;
    $lang_nm = ICL_LANGUAGE_NAME;
    if($lang_nm && $getGccnCurrentLangSlug1){
        $defaultLang2 = $getGccnCurrentLangSlug1;
    }
    if(isset($_GET['section'])){
            $defaultLang2 = $_GET['section'];
    }
    $allAvailbleLanguage = icl_get_languages();
    foreach ($allAvailbleLanguage as $key => $value) {
      $codeAndName[$key] = $value['translated_name'];
    }

    ?>
        <div class="wrap">
            <h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
            <nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
                <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'General Settings', 'gcccn' ); ?></a>
                <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
                <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
            </nav>
            <?php
            if($getGccnCurrentLangSlug1 && $getGccnCurrentLangSlug1 != "all"){
                $getGccnCurrentLangSlug = $getGccnCurrentLangSlug1;
            ?>
                <h2><?php _e('Selected Language is - ', 'gcccn'); echo $lang_nm;  ?></h2>
            <?php } else { ?>
                <ul class="displaysubmenu">
                <?php
                    foreach ( $codeAndName as $langSlug => $langName) {
                        $cActive = '';
                        if(isset($_GET['section'])){
                            if( $langSlug == $_GET['section'] ){
                                $cActive = 'b iclSection';
                                $getGccnCurrentLangSlug = $langSlug;
                            }
                        } else {
                            if( $langSlug == $defaultLang ){
                                $cActive = 'b icldefaultLang';
                                $getGccnCurrentLangSlug = $langSlug;
                            }
                        }
                ?>
                <li>
                    <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$langSlug.'&lang='.$getGccnCurrentLangSlug1); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
                </li>
                <?php } ?>
                </ul>
            <?php } ?>
            <form method="post" action="options.php">
                <?php settings_fields( 'gcccn_genral_settings_group_'.$getGccnCurrentLangSlug); ?>
                <table class="form-table" role="presentation">
                <tbody>
                    <tr class="option-site-visibility">
                        <th scope="row"><?php _e( 'Cookie Consent Visibility','gcccn');?> </th>
                        <td>
                            <fieldset>
                                <label for="gcccn_discourage_cookie_consent">
                                <input name="gcccn_discourage_cookie_consent_<?php echo $getGccnCurrentLangSlug; ?>" type="checkbox" id="gcccn_discourage_cookie_consent" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_discourage_cookie_consent_'.$getGccnCurrentLangSlug ), false ); ?> ><?php _e( 'If checked then Cookie Consent popup is hide.','gcccn');?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr class="option-site-visibility">
                        <th scope="row"><label for="gcccn_cookie_expiry_duration"><?php _e( 'Cookie Expiry Duration','gcccn');?></label></th>
                        <td>
                            <?php 
                                $cookieExpiryDurations = array(
                                    1   => __( '1 day','gcccn'), 
                                    7   => __( '1 week','gcccn'), 
                                    30  => __( '1 Month','gcccn'),
                                    90  => __( '3 Months','gcccn'), 
                                    180 => __( '6 Months','gcccn'),
                                    365 => __( '1 Year', 'gcccn')
                                );
                                ?>
                            <select name="gcccn_cookie_expiry_duration_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_cookie_expiry_duration">
                                <?php
                                    if($cookieExpiryDurations){
                                        foreach ( $cookieExpiryDurations as $cookieExpiryValue => $cookieExpiryLabel ){
                                            echo '<option value="'.$cookieExpiryValue.'" '.selected( get_option( "gcccn_cookie_expiry_duration_".$getGccnCurrentLangSlug ), $cookieExpiryValue, false ).'>'. $cookieExpiryLabel .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="hide_popup_pages">
                        <th><label for="gcccn_popup_hide_pages[]"><?php _e( 'Select pages for hide popup','gcccn');?></label></th>
                        <td>
                            <select name="gcccn_popup_hide_pages_<?php echo $getGccnCurrentLangSlug; ?>[]" id="gcccn_popup_hide_pages"  multiple="multiple">
                                <option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
                                <?php
                                    $getPopupHidePagesValue = get_option( 'gcccn_popup_hide_pages_'.$getGccnCurrentLangSlug );
                                    $my_current_lang = apply_filters( 'wpml_current_language', NULL ); //Store current language
                                    do_action( 'wpml_switch_language', $getGccnCurrentLangSlug );
                                    $popupHidePages = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'page', 'post_status' => 'publish','suppress_filters' => 0 ) );
                                    if($popupHidePages){
                                        foreach( $popupHidePages as $popupHidePage ){
                                            if($getPopupHidePagesValue){
                                                $selectedPages = in_array( $popupHidePage->ID, $getPopupHidePagesValue ) ? 'selected' : '';     
                                            } else {
                                                $selectedPages = '';
                                            }
                                            echo '<option '.$selectedPages.' value="'.$popupHidePage->ID.'">'.$popupHidePage->post_title.'</option>';
                                        }
                                    }
                                    do_action( 'wpml_switch_language', $my_current_lang );
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
                </table>
            <div class="btns">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes','gcccn'); ?>">
            </div>
        </form>
    </div>
<?php
} else {
?>
<div class="wrap">
	<h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
	<nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings' ); ?>" class="nav-tab nav-tab-active"><?php _e( 'General Settings', 'gcccn' ); ?></a>
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text' ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration' ); ?>" class="nav-tab"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
	</nav>
	<form method="post" action="options.php">
		<?php settings_fields( 'gcccn_genral_settings_group' ); ?>
		<table class="form-table" role="presentation">
		<tbody>
			<tr class="option-site-visibility">
			<th scope="row"><?php _e( 'Cookie Consent Visibility','gcccn');?> </th>
			<td>
				<fieldset>
				<label for="gcccn_discourage_cookie_consent">
					<input name="gcccn_discourage_cookie_consent" type="checkbox" id="gcccn_discourage_cookie_consent" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_discourage_cookie_consent' ), false ); ?> ><?php _e( 'If checked then Cookie Consent popup is hide.','gcccn');?>
				</label>
				</fieldset>
			</td>
			</tr>
			<tr class="option-site-visibility">
			<th scope="row"><label for="gcccn_cookie_expiry_duration"><?php _e( 'Cookie Expiry Duration','gcccn');?></label></th>
			<td>
				<?php 
					$cookieExpiryDurations = array(
						1 	=> __( '1 day','gcccn'), 
						7 	=> __( '1 week','gcccn'), 
						30	=> __( '1 Month','gcccn'),
						90	=> __( '3 Months','gcccn'), 
						180	=> __( '6 Months','gcccn'),
						365	=> __( '1 Year', 'gcccn')
					);
				?>
				<select name="gcccn_cookie_expiry_duration" id="gcccn_cookie_expiry_duration">
					<?php
					foreach ( $cookieExpiryDurations as $cookieExpiryValue => $cookieExpiryLabel ){
						echo '<option value="'.$cookieExpiryValue.'" '.selected( get_option( "gcccn_cookie_expiry_duration" ), $cookieExpiryValue, false ).'>'. $cookieExpiryLabel .'</option>';
					}
					?>
				</select>
			</td>
			</tr>
			 <tr class="hide_popup_pages">
                    <th><label for="gcccn_popup_hide_pages[]"><?php _e( 'Select pages for hide popup','gcccn');?></label></th>
                    <td>
                        <select name="gcccn_popup_hide_pages[]" id="gcccn_popup_hide_pages"  multiple="multiple">
                            <option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
                            <?php
                                $getPopupHidePagesValue = get_option( 'gcccn_popup_hide_pages'	);
                                $popupHidePages = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'page', 'post_status' => 'publish') );
                                if($popupHidePages){
                                    foreach( $popupHidePages as $popupHidePage ){
                                        if($getPopupHidePagesValue){
                                            $selectedPages = in_array( $popupHidePage->ID, $getPopupHidePagesValue ) ? 'selected' : '';     
                                        } else {
                                            $selectedPages = '';
                                        }
                                        echo '<option '.$selectedPages.' value="'.$popupHidePage->ID.'">'.$popupHidePage->post_title.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
		</tbody>
	</table>
	<div class="btns">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes','gcccn'); ?>">
	</div>
</form>
</div>
<?php
}