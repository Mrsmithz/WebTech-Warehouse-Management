$("#login_form").submit(function(event){
    event.preventDefault();
    var form = $(this);
    //var input = form.find('v-text-field');
    var serialize = form.serialize();
    //input.prop('disabled', true);
    console.log("done");
    request = $.ajax({
        url:"/assets/php/LoginTest.php",
        type:'post',
        data:serialize
    });
    request.done(function(reponse, textStatus, jqXHR){
        console.log('it worked');
    })
});
