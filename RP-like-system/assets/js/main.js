
function rp_btn_position_select(){
    var currentval = jQuery("#btnPosition").val();
    if(currentval == 3) {
        jQuery(".rp-short-code-notice").show();
    } else {
        jQuery(".rp-short-code-notice").hide();
    }

}