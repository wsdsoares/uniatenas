function isNumber (event) {
    var keycode = event.keyCode;
    if(keycode > 47 && keycode < 58){
        return true;
    }else{
        return false;
    }
}