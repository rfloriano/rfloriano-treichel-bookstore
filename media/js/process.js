function validation(form_id){
    var is_valid = true;
    $("#" + form_id + " input").each(function(i){
        if (!$(this).val()){
            is_valid = false;
        }
    });
    return is_valid;
}