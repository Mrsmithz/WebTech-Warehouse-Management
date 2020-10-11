function validateform(){
    var username = document.forms['myform']['username'].value;
    var password = document.forms['myform']['password'].value;
    var name = document.forms['myform']['name'].value;
    var lastname = document.forms['myform']['lastname'].value;
    var age = document.forms['myform']['age'].value;
    var email = document.forms['myform']['email'].value;
    var address = document.forms['myform']['address'].value;
    var tel = document.forms['myform']['telephone'].value;
    return false;
}
function usernameValidate(username){
    var regex = RegExp(/^[a-zA-Z0-9]+$/);
    if (regex.test(username)){
        return true;
    }
    else{
        return false;
    }
}
function passwordValidate(password){
    var regex = RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/);
    if (regex.test(password)){
        return true;
    }
    else{
        return false;
    }
}
function nameAndlastnameValidate(name, lastname){
    var regex = RegExp(/^[a-zA-Z]+$/);
    if (regex.test(name) && regex.test(lastname)){
        return true;
    }
    else{
        return false;
    }
}
function ageValidate(age){
    var regex = RegExp(/^[1-9]+[0-9]*$/);
    if (regex.test(age)){
        return true;
    }
    else{
        return false;
    }
}
function emailValidate(email){
    var regex = RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    if (regex.test(email)){
        return true;
    }
    else{
        return false;
    }
}
function addressValidate(address){

}
function telephoneValidate(tel){
    var regex = RegExp(/^[0-9]{10}$/);
    if (regex.test(tel)){
        return true;
    }
    else{
        return false;
    }
}
