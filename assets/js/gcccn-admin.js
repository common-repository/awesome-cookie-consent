var gcccnPreviewInstance=null;
gcccnPreviewOptions = JSON.parse(cookie_consent_popup_object.gcccn_layout_configuration);
gcccnDefaultContent= {
    message: cookie_consent_popup_object.gcccn_main_message,
    link: cookie_consent_popup_object.gcccn_policy_link_text,
    href: cookie_consent_popup_object.gcccn_url_cookie_policy,
    button: cookie_consent_popup_object.gcccn_dismiss_button_text
};
function gcccnPreviewSetPosition(e) {
    gcccnPreviewOptions.position=e;
    gcccnPreviewSetOptions();
}

function gcccnPreviewSetBorder(e) {
    gcccnPreviewOptions.border=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetCorners(e) {
    gcccnPreviewOptions.corners=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetTransparency(e) {
    gcccnPreviewOptions.transparency=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetFontSize(e) {
    gcccnPreviewOptions.fontsize=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetPadding(e) {
    gcccnPreviewOptions.padding=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetMargin(e) {
    gcccnPreviewOptions.margin=e,
    gcccnPreviewSetOptions()
}

function gcccnPreviewSetOptions() {

    for(var e in gcccnPreviewOptions.colors.popup.background=jQuery("#gcccn_popup_background_color").val(), 
        gcccnPreviewOptions.colors.popup.text=jQuery("#gcccn_popup_text_color").val(), 
        gcccnPreviewOptions.colors.popup.border=jQuery("#gcccn_popup_border_color").val(), 
        gcccnPreviewOptions.colors.button.background=jQuery("#gcccn_button_background_color").val(), 
        gcccnPreviewOptions.colors.button.text=jQuery("#gcccn_button_text_color").val(), 
        void 0===gcccnPreviewOptions.content&&(gcccnPreviewOptions.content= {}
    ), gcccnDefaultContent)gcccnPreviewOptions.content[e]=gcccnDefaultContent[e]; 
    gccnPreviewShow()
}

function gccnPreviewShow() {
    null!=gcccnPreviewInstance&&(gcccnPreviewInstance.clearStatus(), 
    gcccnPreviewInstance.destroy()),
    gcccnPreviewOptions.cookie= {},
    gcccnPreviewOptions.cookie.name="",
    gcccn.init(gcccnPreviewOptions, function(e) {
        gcccnPreviewInstance=e
    }),
    delete gcccnPreviewOptions.cookie;
    delete gcccnPreviewOptions.content;
    jQuery("#gcccn_layout_configuration").val(JSON.stringify(gcccnPreviewOptions));
}

jQuery(function() {
    
    jQuery("#gcccn_layout_preview").on("click", function(event){
        event.preventDefault()
        gccnPreviewShow();
    });

    jQuery("div.gcccn_cookieconsent ul.positions li a").on("click", function(event){
        event.preventDefault();
        jQuery('div.gcccn_cookieconsent ul.positions li').removeClass('active');
        jQuery(this).parent().addClass('active');
        gcccnPreviewSetPosition(jQuery(this).data('position'));
    });

    jQuery('div.gcccn_cookieconsent ul.positions li').removeClass('active');
    jQuery('div.gcccn_cookieconsent ul.positions li.position-'+gcccnPreviewOptions['position']).addClass('active');
    
    jQuery('#gcccn_popup_border option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_border option[value=" + gcccnPreviewOptions['border'] +"]").attr("selected","selected");
    
    jQuery('#gcccn_popup_corners option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_corners option[value=" + gcccnPreviewOptions['corners'] +"]").attr("selected","selected");

    jQuery('#gcccn_popup_padding option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_padding option[value=" + gcccnPreviewOptions['padding'] +"]").attr("selected","selected");

    jQuery('#gcccn_popup_margin option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_margin option[value=" + gcccnPreviewOptions['margin'] +"]").attr("selected","selected");

    jQuery('#gcccn_popup_transparency option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_transparency option[value=" + gcccnPreviewOptions['transparency'] +"]").attr("selected","selected");

    jQuery('#gcccn_popup_fontsize option:selected').removeAttr('selected');
    jQuery("#gcccn_popup_fontsize option[value=" + gcccnPreviewOptions['fontsize'] +"]").attr("selected","selected");

    jQuery("#gcccn_popup_background_color").val(gcccnPreviewOptions['colors']['popup']['background']);
    jQuery("#gcccn_popup_text_color").val(gcccnPreviewOptions['colors']['popup']['text']); 
    jQuery("#gcccn_popup_border_color").val(gcccnPreviewOptions['colors']['popup']['border']); 
    jQuery("#gcccn_button_background_color").val(gcccnPreviewOptions['colors']['button']['background']); 
    jQuery("#gcccn_button_text_color").val(gcccnPreviewOptions['colors']['button']['text']);
    jQuery('.gcccn_color_picker').wpColorPicker({
        defaultColor: false,
        hide: true,
        palettes: true,
        change: function(event, ui){
            setTimeout(function(){
                gcccnPreviewSetOptions();
            }, 50)
        }
    });
    
	jQuery('#gcccn_url_cookie_policy_option').select2();
	
	jQuery('#gcccn_cookie_policy_url_type').change(function() {
	  var val = jQuery(this).val();
	  console.log(val);
	  if (val == 'custom_link') {   
	    jQuery("#gcccn_url_cookie_policy_link").show();
	    jQuery("#gcccn_url_cookie_policy_option_span").hide();
	    
	  } else {
	    jQuery("#gcccn_url_cookie_policy_option_span").show();
	    jQuery("#gcccn_url_cookie_policy_link").hide();
	  }
	});

    jQuery('#gcccn_popup_hide_pages').select2({
        placeholder: "Select a Page"
    });

});