/* Script Movie */

function showDocMovie() {
    $(".doc").show();
    $(".short").hide();
    scrollAdjustementMovie();
}
function showShortMovie() {
    $(".short").show();
    $(".doc").hide();
    scrollAdjustementMovie();
}
function showAllMovie() {
    $(".doc").show();
    $(".short").show();
    scrollAdjustementMovie();
}

function scrollAdjustementMovie() {
    $('html, body').animate({
        scrollTop: $("#choiceFilm").offset().top - 70
    }, 1000);
}

function demoSend(){
    if($("#validationServer01").val() && $("#validationServer02").val() && $("#validationServer05").val()){
        $("#feedbackSend").show();
        $("#feedbackSend").html("Votre réservation est bien prise en compte");
        setTimeout(function(){ $("#feedbackSend").html(""); $("#feedbackSend").hide() }, 9000);
    }
}


/* Script back to Top */

function scrollToTop() {
    $('html, body').animate({
        scrollTop: $('html, body').offset().top
    }, 1500);
}

/* Script check input file */

var valid = false;

function validate_fileupload(input_element)
{
    $("#feedback").show();
    var fileName = input_element.value;
    var allowedExtensions = new Array("jpg","png","pdf");
    var fileExtension = fileName.split('.').pop(); 
    for(var i = 0; i < allowedExtensions.length; i++)
    {
        if(allowedExtensions[i]==fileExtension)
        {
            valid = true;
            $("#feedback").hide();
            $("#feedback").html("");
            return;
        }
    }
    $("#feedback").removeClass("alert-success");
    $("#feedback").addClass("alert-danger");
    $("#feedback").html("Format incorrect")
    valid = false;
}

function valid_form()
{
    if(!valid){
        $("#feedback").show();
        $("#feedback").removeClass("alert-success");
        $("#feedback").addClass("alert-danger");
        $("#feedback").html("Formulaire incomplet")
    }else{
        $("#feedback").show();
        $("#feedback").removeClass("alert-danger");
        $("#feedback").addClass("alert-success");
        $("#feedback").html("Formulaire envoyé")
    }
    return valid;
}