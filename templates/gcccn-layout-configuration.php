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

		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2 ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>

		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$defaultLang2 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
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
		    				$cActive = 'b';
		    				$getGccnCurrentLangSlug = $langSlug;
		    			}
		    		} else {
		    			if( $langSlug == $defaultLang ){
		    				$cActive = 'b';
		    				$getGccnCurrentLangSlug = $langSlug;
		    			}
		    		}

		        ?>
		    	<li>
		        	<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$langSlug); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
		    	</li>
		    	<?php	
		        }
		        ?>
		</ul>
	<?php } ?>

	<div class="gcccn_cookieconsent">
		<form method="post" action="options.php">
			<?php settings_fields( 'gcccn_layout_configuration_group_'.$getGccnCurrentLangSlug ); ?>
			<div class="steps">
				<div class="step step1 style-position">
					<h2 class="title"><?php _e( 'Style and Position', 'gcccn' ); ?></h2>
					<p><?php _e( 'Choose the display style and position of the cookie consent banner.', 'gcccn' ); ?></p>
					<div class="panel">
						<div class="content">
							<ul class="choices positions gcccn-row">
								<li class="gcccn-col-2 position-bottom-left">
									<a data-position="bottom-left" title="Bottom left" href="#">
										<span><?php _e( 'Tooltip Bottom left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom-right">
									<a data-position="bottom-right" title="Bottom right" href="#">
										<span><?php _e( 'Tooltip Bottom right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-left">
									<a data-position="top-left" title="Top left" href="#">
										<span><?php _e( 'Tooltip Top left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-right">
									<a data-position="top-right" title="Top right" href="#">
										<span><?php _e( 'Tooltip Top right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom">
									<a data-position="bottom" title="Bottom" href="#">
										<span><?php _e( 'Bar Bottom', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top">
									<a data-position="top" title="Top" href="#">
										<span><?php _e( 'Bar Top', 'gcccn' ); ?></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="step step2 layout">
					<h2 class="title"><?php _e( 'Layout', 'gcccn' ); ?></h2>
					<div class="panel">
						<div class="content">
							<table class="form-table" role="presentation">
								<tbody>
								<tr class="layout-border">
									<th scope="row"><label for="gcccn_popup_border"><?php _e( 'Border', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_border" id="gcccn_popup_border" onchange="gcccnPreviewSetBorder(this.value)" name="popup_border_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="thin"><?php _e( 'Thin', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="thick"><?php _e( 'Thick', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-corners">
									<th scope="row"><label for="gcccn_popup_corners"> <?php _e( 'Corners', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_corners" id="gcccn_popup_corners" onchange="gcccnPreviewSetCorners(this.value)" name="popup_corners_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-padding">
									<th scope="row"><label for="gcccn_popup_padding"><?php _e( 'Padding', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_padding" id="gcccn_popup_padding" onchange="gcccnPreviewSetPadding(this.value)" name="popup_padding_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-margin">
									<th scope="row"><label for="gcccn_popup_margin"><?php _e( 'Margin', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_margin" id="gcccn_popup_margin" onchange="gcccnPreviewSetMargin(this.value)" name="popup_margin_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-transparency">
									<th scope="row"><label for="gcccn_popup_transparency"><?php _e( 'Transparency', 'gcccn' ); ?> </label></th>
									<td>
										<select class="gcccn_popup_transparency" id="gcccn_popup_transparency" onchange="gcccnPreviewSetTransparency(this.value)" name="popup_transparency_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="5">5%</option>
											<option value="10">10%</option>
											<option value="15">15%</option>
											<option value="20">20%</option>
											<option value="25">25%</option>
										</select>
									</td>
								</tr>
								<tr class="layout-fontsize">
									<th scope="row"><label for="gcccn_popup_fontsize"><?php _e( 'Font size', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_fontsize" id="gcccn_popup_fontsize" onchange="gcccnPreviewSetFontSize(this.value)" name="popup_fontsize_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="tiny"><?php _e( 'Tiny', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="default"><?php _e( 'Default', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="step step3 colors">
					<h2 class="title"><?php _e( 'Colors', 'gcccn' ); ?></h2>
					<div class="panel">
					<div class="content">
						<div id="custom-colors-box" class="custom">
							<table class="form-table" role="presentation">
								<tbody>
									<tr class="colors-popup-background">
										<th scope="row"><?php _e( 'Popup background', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_background_color gcccn_color_picker" id="gcccn_popup_background_color" type="text" name="popup_background_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#f6f6f6"/>
										</td>
									</tr>
									<tr class="colors-popup-text">
										<th scope="row"><?php _e( 'Popup text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_text_color gcccn_color_picker" id="gcccn_popup_text_color" type="text" name="popup_text_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#000000" />
										</td>
									</tr>
									<tr class="colors-popup-border">
										<th scope="row"><?php _e( 'Popup border', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_border_color gcccn_color_picker" id="gcccn_popup_border_color" type="text" name="popup_border_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#555555" />
										</td>
									</tr>
									<tr class="colors-button-background">
										<th scope="row"><?php _e( 'Button background', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_background_color gcccn_color_picker" id="gcccn_button_background_color" type="text" name="button_background_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#555555"/>
										</td>
									</tr>
									<tr class="colors-button-text">
										<th scope="row"><?php _e( 'Button text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_text_color gcccn_color_picker" id="gcccn_button_text_color" type="text" name="button_text_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#ffffff" />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="btns">
			<textarea name="gcccn_layout_configuration_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_layout_configuration" class="large-text code"><?php echo get_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug); ?></textarea>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'gcccn' ); ?>">
			<a class="button gcccn-preview" id="gcccn_layout_preview" href="#"><?php _e( 'Click to preview', 'gcccn' ); ?></a>
		</div>
		</form>

	</div>
</div>
<?php
}

else if ((isset($sitepress) && 1 <= count(icl_get_languages('skip_missing=0'))) && (function_exists('icl_get_languages') || defined( 'ICL_LANGUAGE_CODE' ))) {
    $defaultLang = $sitepress->get_default_language();
    $getGccnCurrentLangSlug1 = ICL_LANGUAGE_CODE;
    $defaultLang2 = $defaultLang;
    $lang_nm = ICL_LANGUAGE_NAME;
    if($getGccnCurrentLangSlug1){
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
			<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>
			<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$defaultLang2.'&lang='.$getGccnCurrentLangSlug1 ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
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
                            $cActive = 'b';
                            $getGccnCurrentLangSlug = $langSlug;
                        }
                    } else {
                        if( $langSlug == $defaultLang ){
                            $cActive = 'b';
                            $getGccnCurrentLangSlug = $langSlug;
                        }
                    }

                ?>
                <li>
                    <a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration&section='.$langSlug.'&lang='.$getGccnCurrentLangSlug1); ?>" class="sub-active <?php echo $cActive; ?>"><?php echo $langName; ?></a> 
                </li>
                <?php   
                }
                ?>
				<?php   
                }
                ?>
        </ul>
    <?php } ?>
    <div class="gcccn_cookieconsent">
		<form method="post" action="options.php" class="currentLang_<?php echo $getGccnCurrentLangSlug; ?>">
			<?php settings_fields( 'gcccn_layout_configuration_group_'.$getGccnCurrentLangSlug ); ?>
			<div class="steps">
				<div class="step step1 style-position">
					<h2 class="title"><?php _e( 'Style and Position', 'gcccn' ); ?></h2>
					<p><?php _e( 'Choose the display style and position of the cookie consent banner.', 'gcccn' ); ?></p>
					<div class="panel">
						<div class="content">
							<ul class="choices positions gcccn-row">
								<li class="gcccn-col-2 position-bottom-left">
									<a data-position="bottom-left" title="Bottom left" href="#">
										<span><?php _e( 'Tooltip Bottom left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom-right">
									<a data-position="bottom-right" title="Bottom right" href="#">
										<span><?php _e( 'Tooltip Bottom right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-left">
									<a data-position="top-left" title="Top left" href="#">
										<span><?php _e( 'Tooltip Top left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-right">
									<a data-position="top-right" title="Top right" href="#">
										<span><?php _e( 'Tooltip Top right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom">
									<a data-position="bottom" title="Bottom" href="#">
										<span><?php _e( 'Bar Bottom', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top">
									<a data-position="top" title="Top" href="#">
										<span><?php _e( 'Bar Top', 'gcccn' ); ?></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="step step2 layout">
					<h2 class="title"><?php _e( 'Layout', 'gcccn' ); ?></h2>
					<div class="panel">
						<div class="content">
							<table class="form-table" role="presentation">
								<tbody>
								<tr class="layout-border">
									<th scope="row"><label for="gcccn_popup_border"><?php _e( 'Border', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_border" id="gcccn_popup_border" onchange="gcccnPreviewSetBorder(this.value)" name="popup_border_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="thin"><?php _e( 'Thin', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="thick"><?php _e( 'Thick', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-corners">
									<th scope="row"><label for="gcccn_popup_corners"> <?php _e( 'Corners', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_corners" id="gcccn_popup_corners" onchange="gcccnPreviewSetCorners(this.value)" name="popup_corners_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-padding">
									<th scope="row"><label for="gcccn_popup_padding"><?php _e( 'Padding', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_padding" id="gcccn_popup_padding" onchange="gcccnPreviewSetPadding(this.value)" name="popup_padding_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-margin">
									<th scope="row"><label for="gcccn_popup_margin"><?php _e( 'Margin', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_margin" id="gcccn_popup_margin" onchange="gcccnPreviewSetMargin(this.value)" name="popup_margin_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-transparency">
									<th scope="row"><label for="gcccn_popup_transparency"><?php _e( 'Transparency', 'gcccn' ); ?> </label></th>
									<td>
										<select class="gcccn_popup_transparency" id="gcccn_popup_transparency" onchange="gcccnPreviewSetTransparency(this.value)" name="popup_transparency_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="5">5%</option>
											<option value="10">10%</option>
											<option value="15">15%</option>
											<option value="20">20%</option>
											<option value="25">25%</option>
										</select>
									</td>
								</tr>
								<tr class="layout-fontsize">
									<th scope="row"><label for="gcccn_popup_fontsize"><?php _e( 'Font size', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_fontsize" id="gcccn_popup_fontsize" onchange="gcccnPreviewSetFontSize(this.value)" name="popup_fontsize_<?php echo $getGccnCurrentLangSlug; ?>">
											<option value="tiny"><?php _e( 'Tiny', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="default"><?php _e( 'Default', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="step step3 colors">
					<h2 class="title"><?php _e( 'Colors', 'gcccn' ); ?></h2>
					<div class="panel">
					<div class="content">
						<div id="custom-colors-box" class="custom">
							<table class="form-table" role="presentation">
								<tbody>
									<tr class="colors-popup-background">
										<th scope="row"><?php _e( 'Popup background', 'gcccn' ); ?></th>
										<td>
											<input class="123 gcccn_popup_background_color gcccn_color_picker" id="gcccn_popup_background_color" type="text" name="popup_background_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#000"/>
										</td>
									</tr>
									<tr class="colors-popup-text">
										<th scope="row"><?php _e( 'Popup text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_text_color gcccn_color_picker" id="gcccn_popup_text_color" type="text" name="popup_text_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#000000" />
										</td>
									</tr>
									<tr class="colors-popup-border">
										<th scope="row"><?php _e( 'Popup border', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_border_color gcccn_color_picker" id="gcccn_popup_border_color" type="text" name="popup_border_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#555555" />
										</td>
									</tr>
									<tr class="colors-button-background">
										<th scope="row"><?php _e( 'Button background', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_background_color gcccn_color_picker" id="gcccn_button_background_color" type="text" name="button_background_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#555555"/>
										</td>
									</tr>
									<tr class="colors-button-text">
										<th scope="row"><?php _e( 'Button text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_text_color gcccn_color_picker" id="gcccn_button_text_color" type="text" name="button_text_color_<?php echo $getGccnCurrentLangSlug; ?>" data-default-color="#ffffff" />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="btns">
			<?php
			$gcccn_layout_configuration_json =  get_option('gcccn_layout_configuration');
			if(get_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug)){
				$gcccn_layout_configuration_json =  get_option('gcccn_layout_configuration_'.$getGccnCurrentLangSlug);
			} 
			?>	
			<textarea name="gcccn_layout_configuration_<?php echo $getGccnCurrentLangSlug; ?>" id="gcccn_layout_configuration" class="large-text code wpml"><?php echo $gcccn_layout_configuration_json; ?></textarea>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'gcccn' ); ?>">
			<a class="button gcccn-preview" id="gcccn_layout_preview" href="#"><?php _e( 'Click to preview', 'gcccn' ); ?></a>
		</div>
		</form>

	</div>
</div>
<?php
}
else{
?>
<div class="wrap">
	<h1 id="gcccn-title"><?php _e( GCCCN_NAME, 'gcccn' ); ?></h1>
	<nav class="nav-tab-wrapper gcccn-nav-tab-wrapper">
		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-genral-settings' ); ?>" class="nav-tab"><?php _e( 'General Settings', 'gcccn' ); ?></a>

		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-cookie-consent-text' ); ?>" class="nav-tab"><?php _e( 'Cookie Consent Text', 'gcccn' ); ?></a>

		<a href="<?php echo admin_url( 'options-general.php?page=ta_gcccn&tab=gcccn-layout-configuration' ); ?>" class="nav-tab nav-tab-active"><?php _e( 'Layout Configuration', 'gcccn' ); ?></a>
	</nav>
	<div class="gcccn_cookieconsent">
		<form method="post" action="options.php">
			<?php settings_fields( 'gcccn_layout_configuration_group' ); ?>
			<div class="steps">
				<div class="step step1 style-position">
					<h2 class="title"><?php _e( 'Style and Position', 'gcccn' ); ?></h2>
					<p><?php _e( 'Choose the display style and position of the cookie consent banner.', 'gcccn' ); ?></p>
					<div class="panel">
						<div class="content">
							<ul class="choices positions gcccn-row">
								<li class="gcccn-col-2 position-bottom-left">
									<a data-position="bottom-left" title="Bottom left" href="#">
										<span><?php _e( 'Tooltip Bottom left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom-right">
									<a data-position="bottom-right" title="Bottom right" href="#">
										<span><?php _e( 'Tooltip Bottom right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-left">
									<a data-position="top-left" title="Top left" href="#">
										<span><?php _e( 'Tooltip Top left', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top-right">
									<a data-position="top-right" title="Top right" href="#">
										<span><?php _e( 'Tooltip Top right', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-bottom">
									<a data-position="bottom" title="Bottom" href="#">
										<span><?php _e( 'Bar Bottom', 'gcccn' ); ?></span>
									</a>
								</li>
								<li class="gcccn-col-2 position-top">
									<a data-position="top" title="Top" href="#">
										<span><?php _e( 'Bar Top', 'gcccn' ); ?></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="step step2 layout">
					<h2 class="title"><?php _e( 'Layout', 'gcccn' ); ?></h2>
					<div class="panel">
						<div class="content">
							<table class="form-table" role="presentation">
								<tbody>
								<tr class="layout-border">
									<th scope="row"><label for="gcccn_popup_border"><?php _e( 'Border', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_border" id="gcccn_popup_border" onchange="gcccnPreviewSetBorder(this.value)" name="popup_border">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="thin"><?php _e( 'Thin', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="thick"><?php _e( 'Thick', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-corners">
									<th scope="row"><label for="gcccn_popup_corners"> <?php _e( 'Corners', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_corners" id="gcccn_popup_corners" onchange="gcccnPreviewSetCorners(this.value)" name="popup_corners">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-padding">
									<th scope="row"><label for="gcccn_popup_padding"><?php _e( 'Padding', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_padding" id="gcccn_popup_padding" onchange="gcccnPreviewSetPadding(this.value)" name="popup_padding">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-margin">
									<th scope="row"><label for="gcccn_popup_margin"><?php _e( 'Margin', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_margin" id="gcccn_popup_margin" onchange="gcccnPreviewSetMargin(this.value)" name="popup_margin">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="normal"><?php _e( 'Normal', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="layout-transparency">
									<th scope="row"><label for="gcccn_popup_transparency"><?php _e( 'Transparency', 'gcccn' ); ?> </label></th>
									<td>
										<select class="gcccn_popup_transparency" id="gcccn_popup_transparency" onchange="gcccnPreviewSetTransparency(this.value)" name="popup_transparency">
											<option value="none"><?php _e( 'None', 'gcccn' ); ?></option>
											<option value="5">5%</option>
											<option value="10">10%</option>
											<option value="15">15%</option>
											<option value="20">20%</option>
											<option value="25">25%</option>
										</select>
									</td>
								</tr>
								<tr class="layout-fontsize">
									<th scope="row"><label for="gcccn_popup_fontsize"><?php _e( 'Font size', 'gcccn' ); ?></label></th>
									<td>
										<select class="gcccn_popup_fontsize" id="gcccn_popup_fontsize" onchange="gcccnPreviewSetFontSize(this.value)" name="popup_fontsize">
											<option value="tiny"><?php _e( 'Tiny', 'gcccn' ); ?></option>
											<option value="small"><?php _e( 'Small', 'gcccn' ); ?></option>
											<option value="default"><?php _e( 'Default', 'gcccn' ); ?></option>
											<option value="large"><?php _e( 'Large', 'gcccn' ); ?></option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="step step3 colors">
					<h2 class="title"><?php _e( 'Colors', 'gcccn' ); ?></h2>
					<div class="panel">
					<div class="content">
						<div id="custom-colors-box" class="custom">
							<table class="form-table" role="presentation">
								<tbody>
									<tr class="colors-popup-background">
										<th scope="row"><?php _e( 'Popup background', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_background_color gcccn_color_picker" id="gcccn_popup_background_color" type="text" name="popup_background_color" data-default-color="#f6f6f6"/>
										</td>
									</tr>
									<tr class="colors-popup-text">
										<th scope="row"><?php _e( 'Popup text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_text_color gcccn_color_picker" id="gcccn_popup_text_color" type="text" name="popup_text_color" data-default-color="#000000" />
										</td>
									</tr>
									<tr class="colors-popup-border">
										<th scope="row"><?php _e( 'Popup border', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_popup_border_color gcccn_color_picker" id="gcccn_popup_border_color" type="text" name="popup_border_color" data-default-color="#555555" />
										</td>
									</tr>
									<tr class="colors-button-background">
										<th scope="row"><?php _e( 'Button background', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_background_color gcccn_color_picker" id="gcccn_button_background_color" type="text" name="button_background_color" data-default-color="#555555"/>
										</td>
									</tr>
									<tr class="colors-button-text">
										<th scope="row"><?php _e( 'Button text', 'gcccn' ); ?></th>
										<td>
											<input class="gcccn_button_text_color gcccn_color_picker" id="gcccn_button_text_color" type="text" name="button_text_color" data-default-color="#ffffff" />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="btns">
			<textarea name="gcccn_layout_configuration" id="gcccn_layout_configuration" class="large-text code"><?php echo get_option('gcccn_layout_configuration'); ?></textarea>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'gcccn' ); ?>">
			<a class="button gcccn-preview" id="gcccn_layout_preview" href="#"><?php _e( 'Click to preview', 'gcccn' ); ?></a>
		</div>
		</form>
	</div>
</div>
<?php
}