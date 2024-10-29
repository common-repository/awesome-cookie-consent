<?php
	global $sitepress;		
	$polylangLang = get_option( 'polylang' );

    if ( isset($polylangLang['default_lang']) && ( function_exists( 'pll_current_language' ) || function_exists('pll_languages_list') || function_exists( 'pll_default_language' ))) {
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
				<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$defaultLang2 ); ?>" class="nav-tab"><?php _e( 'General Settings', 'gcccn' ); ?></a>
				<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
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
					if($getLanguagesList){
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
					}
				?>
				<li>
					<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$langSlug); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
				</li>
		    <?php } ?>
			</ul>
			<?php } ?>
			<div class="gcccn_cookieconsent">
				<form method="post" action="options.php">
					<?php settings_fields( 'gcccn_cookie_Consent_text_group_'.$getGccnCurrentLangSlug ); ?>
					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th scope="row">
									<label for="gcccn_main_message"><?php _e( 'Main message','gcccn');?></label>
								</th>
								<td>
									<textarea required name="gcccn_main_message_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'This website uses cookies to ensure you get the best experience on our website.', 'gcccn'); ?>" rows="10" cols="50" id="gcccn_main_message" class="large-text code"><?php echo get_option('gcccn_main_message_'.$getGccnCurrentLangSlug); ?></textarea>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="gcccn_dismiss_button_text"><?php _e( 'Dismiss button text','gcccn');?></label>
								</th>
								<td>
									<input required name="gcccn_dismiss_button_text_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'Got it!', 'gcccn'); ?>" type="text" id="gcccn_dismiss_button_text" value="<?php echo get_option('gcccn_dismiss_button_text_'.$getGccnCurrentLangSlug)?>" class="regular-text">
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="gcccn_policy_link_text"><?php _e( 'Policy link text','gcccn');?></label>
								</th>
								<td>
									<input name="gcccn_policy_link_text_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'Learn More', 'gcccn'); ?>" type="text" id="gcccn_policy_link_text" value="<?php echo get_option('gcccn_policy_link_text_'.$getGccnCurrentLangSlug); ?>" class="regular-text code">
								</td>
							</tr>

							<tr>
								<th>
								<label for="gcccn_cookie_policy_url_type"><?php _e( 'Cookie policy URL','gcccn');?></label>
								</label>
							</th>
								<td>
								<select class="" name="gcccn_cookie_policy_url_type_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_cookie_policy_url_type">
									<option <?php selected( get_option( "gcccn_cookie_policy_url_type_".$getGccnCurrentLangSlug ), 'custom_link', true ); ?> value="custom_link"><?php _e('Custom URL', 'gcccn'); ?></option>
									<option <?php selected( get_option( "gcccn_cookie_policy_url_type_".$getGccnCurrentLangSlug ), 'page_link', true ); ?> value="page_link"><?php _e('Page Link', 'gcccn'); ?></option>
								</select>
								<?php $gcccnCookiePolicyURLType = get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug, 'custom_link'); ?>
									<input class="regular-text <?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? '' : 'hidden'; ?>" name="gcccn_url_cookie_policy_link_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="https://www.yoursite.com/cookie-policy/" type="url" id="gcccn_url_cookie_policy_link" aria-describedby="coolie-policy-url" value="<?php echo get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug); ?>">
									
							 		<span id="gcccn_url_cookie_policy_option_span" class="<?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? 'hidden' : ''; ?>">
										<select id="gcccn_url_cookie_policy_option" name='gcccn_url_cookie_policy_option_<?php echo $getGccnCurrentLangSlug; ?>' class="pages">
											<option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
					    				<?php 
					    					$getAllPagesArgs = array( 'numberposts' => -1, 'post_type' => 'page');
					    					$getAllPages = get_posts($getAllPagesArgs);
					    					
												foreach( $getAllPages as $getPage ) {
					    				?>
					        				<option value='<?php echo $getPage->ID; ?>' <?php selected( get_option( "gcccn_url_cookie_policy_option_".$getGccnCurrentLangSlug ), $getPage->ID, true ); ?> ><?php echo $getPage->post_title; ?></option>
					    				<?php } ?>
									</select>
							</span>
							<label for="gcccn_open_new_tab" class="gcccn_label">
								<input name="gcccn_open_new_tab_<?php echo $getGccnCurrentLangSlug; ?>" type="checkbox" id="gcccn_open_new_tab" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_open_new_tab_'.$getGccnCurrentLangSlug ), false ); ?> ><?php _e( 'Check to open in new tab','gcccn');?>
							</label>			
							</td>
							</tr>
						</tbody>
					</table>
					<div class="btns">
						<?php submit_button(); ?>
					</div>
				</form>
			</div>
		</div>
<?php
}else if ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) && (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {

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
	if($allAvailbleLanguage){
		foreach ($allAvailbleLanguage as $key => $value) {
			$codeAndName[$key] = $value['translated_name'];
		}
	}
    ?>
	<div class="wrap">
		<h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
		<nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
			<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab"><?php _e( 'General Settings', 'gcccn' ); ?></a>
			<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
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
				if($codeAndName){
                foreach ( $codeAndName as $langSlug => $langName) {
                    $cActive = '';
                    if(isset($_GET['section'])){
                        if( $langSlug == $_GET['section'] ){
                            $cActive = 'b iclSection';
                            $getGccnCurrentLangSlug = $langSlug;
                        }
                    } else {
                        if( $langSlug == $defaultLang ){
                            $cActive = 'b iclDefaultLang';
                            $getGccnCurrentLangSlug = $langSlug;
                        }
                    }
					
                ?>
                <li>
                    <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$langSlug.'&lang='.$getGccnCurrentLangSlug1); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
                </li>
                <?php   
            }
                }
                ?>
        </ul>
    <?php } ?>    
	<div class="gcccn_cookieconsent">
		<form method="POST" action="options.php">
		<?php settings_fields( 'gcccn_cookie_Consent_text_group_'.$getGccnCurrentLangSlug ); ?>
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="gcccn_main_message"><?php _e('Main message','gcccn');?></label>
				</th>
				<td>
					<textarea required name="gcccn_main_message_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'This website uses cookies to ensure you get the best experience on our website.', 'gcccn'); ?>" rows="10" cols="50" id="gcccn_main_message" class="large-text code"><?php echo get_option('gcccn_main_message_'.$getGccnCurrentLangSlug); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="gcccn_dismiss_button_text"><?php _e( 'Dismiss button text','gcccn');?></label>
				</th>
				<td>
					<input required name="gcccn_dismiss_button_text_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'Got it!', 'gcccn'); ?>" type="text" id="gcccn_dismiss_button_text" value="<?php echo get_option('gcccn_dismiss_button_text_'.$getGccnCurrentLangSlug)?>" class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="gcccn_policy_link_text"><?php _e( 'Policy link text','gcccn');?></label>
				</th>
				<td>
					<input name="gcccn_policy_link_text_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="<?php _e( 'Learn More', 'gcccn'); ?>" type="text" id="gcccn_policy_link_text" value="<?php echo get_option('gcccn_policy_link_text_'.$getGccnCurrentLangSlug); ?>" class="regular-text code">
				</td>
			</tr>
			<tr>
				<th>
					<label for="gcccn_cookie_policy_url_type"><?php _e( 'Cookie policy URL','gcccn');?></label>
				</th>
				<td>
					<select name="gcccn_cookie_policy_url_type_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_cookie_policy_url_type">
						<option <?php selected( get_option( "gcccn_cookie_policy_url_type_".$getGccnCurrentLangSlug ), 'custom_link', true ); ?> value="custom_link"><?php _e('Custom URL', 'gcccn'); ?></option>
						<option <?php selected( get_option( "gcccn_cookie_policy_url_type_".$getGccnCurrentLangSlug ), 'page_link', true ); ?> value="page_link"><?php _e('Page Link', 'gcccn'); ?></option>
					</select>
					<?php $gcccnCookiePolicyURLType = get_option('gcccn_cookie_policy_url_type_'.$getGccnCurrentLangSlug); ?>
					<input class="regular-text <?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? '' : 'hidden'; ?>" name="gcccn_url_cookie_policy_link_<?php echo $getGccnCurrentLangSlug; ?>" placeholder="https://www.yoursite.com/cookie-policy/" type="url" id="gcccn_url_cookie_policy_link" aria-describedby="coolie-policy-url" value="<?php echo get_option('gcccn_url_cookie_policy_link_'.$getGccnCurrentLangSlug); ?>">
			 		<span id="gcccn_url_cookie_policy_option_span" class="<?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? 'hidden' : ''; ?>">
						<select id="gcccn_url_cookie_policy_option" name='gcccn_url_cookie_policy_option_<?php echo $getGccnCurrentLangSlug; ?>' class="pages">
							<option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
	    				<?php 
	    					$getAllPagesArgs = array( 'numberposts' => -1, 'post_type' => 'page');
	    					$getAllPages = get_posts($getAllPagesArgs);
	    					if($getAllPages){
								foreach( $getAllPages as $getPage ) {
	    				?>
	        				<option value='<?php echo $getPage->ID; ?>' <?php selected( get_option( "gcccn_url_cookie_policy_option_".$getGccnCurrentLangSlug ), $getPage->ID, true ); ?> ><?php echo $getPage->post_title; ?></option>
	    				<?php } ?>
						<?php } ?>
					</select>
			</span>
			<label for="gcccn_open_new_tab" class="gcccn_label">
				<input name="gcccn_open_new_tab_<?php echo $getGccnCurrentLangSlug; ?>" type="checkbox" id="gcccn_open_new_tab" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_open_new_tab' ), false ); ?> ><?php _e( 'Check to open in new tab','gcccn');?>
			</label>			
			</td>
			</tr>
		</tbody>
	</table>
	<div class="btns">
		<?php submit_button(); ?>
	</div>
</form>
</div>
</div>
<?php
} else {
?>
<div class="wrap">
	<h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
	<nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings' ); ?>" class="nav-tab"><?php _e( 'General Settings', 'gcccn' ); ?></a>
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text' ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration' ); ?>" class="nav-tab"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
	</nav>
<div class="gcccn_cookieconsent">
<form method="post" action="options.php">
	<?php settings_fields( 'gcccn_cookie_Consent_text_group' ); ?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="gcccn_main_message"><?php _e( 'Main message','gcccn');?></label>
				</th>
				<td>
					<textarea name="gcccn_main_message" placeholder="This website uses cookies to ensure you get the best experience on our website." rows="10" cols="50" id="gcccn_main_message" class="large-text code"><?php echo get_option('gcccn_main_message'); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="gcccn_dismiss_button_text"><?php _e( 'Dismiss button text','gcccn');?></label>
				</th>
				<td>
					<input name="gcccn_dismiss_button_text" placeholder="Got it!" type="text" id="gcccn_dismiss_button_text" value="<?php echo get_option('gcccn_dismiss_button_text')?>" class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="gcccn_policy_link_text"><?php _e( 'Policy link text','gcccn');?></label>
				</th>
				<td>
					<input name="gcccn_policy_link_text" placeholder="Learn More" type="text" id="gcccn_policy_link_text" value="<?php echo get_option('gcccn_policy_link_text'); ?>" class="regular-text code">
				</td>
			</tr>
			<tr>
				<th><label for="gcccn_cookie_policy_url_type"><?php _e( 'Cookie policy URL','gcccn');?></label></th>
				<td>
				<select class="" name="gcccn_cookie_policy_url_type" id="gcccn_cookie_policy_url_type">
					<option <?php selected( get_option( "gcccn_cookie_policy_url_type" ), 'custom_link', true ); ?> value="custom_link"><?php _e('Custom URL', 'gcccn'); ?></option>
					<option <?php selected( get_option( "gcccn_cookie_policy_url_type" ), 'page_link', true ); ?> value="page_link"><?php _e('Page Link', 'gcccn'); ?></option>
				</select>
				<?php $gcccnCookiePolicyURLType = get_option('gcccn_cookie_policy_url_type'); ?>
				<input class="regular-text <?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? '' : 'hidden'; ?>" name="gcccn_url_cookie_policy_link" placeholder="https://www.yoursite.com/cookie-policy/" type="url" id="gcccn_url_cookie_policy_link" aria-describedby="coolie-policy-url" value="<?php echo get_option('gcccn_url_cookie_policy_link'); ?>">
				<span id="gcccn_url_cookie_policy_option_span" class="<?php echo ( $gcccnCookiePolicyURLType ==  'custom_link') ? 'hidden' : ''; ?>">
						<select id="gcccn_url_cookie_policy_option" name='gcccn_url_cookie_policy_option' class="pages">
							<option value='0'><?php _e('Select a Page', 'gcccn'); ?></option>
	    				<?php 
	    					$getAllPagesArgs = array( 'numberposts' => -1, 'post_type' => 'page');
	    					$getAllPages = get_posts($getAllPagesArgs);
	    						if($getAllPages){
								foreach( $getAllPages as $getPage ) {
	    				?>
	        				<option value='<?php echo $getPage->ID; ?>' <?php selected( get_option( "gcccn_url_cookie_policy_option" ), $getPage->ID, true ); ?> ><?php echo $getPage->post_title; ?></option>
	    				<?php } ?>
						<?php } ?>
					</select>
				</span>
				<label for="gcccn_open_new_tab" class="gcccn_label">
					<input name="gcccn_open_new_tab" type="checkbox" id="gcccn_open_new_tab" value="yes" <?php echo checked( 'yes', get_option( 'gcccn_open_new_tab' ), false ); ?> ><?php _e( 'Check to open in new tab','gcccn');?>
				</label>			
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btns">
		<?php submit_button(); ?>
	</div>
</form>
</div>
</div>
<?php
}