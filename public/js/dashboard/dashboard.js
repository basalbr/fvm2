$(function () {
    if(!checkIfInView($('#left-menu a.active'))){
        $('#left-menu').animate({
            scrollTop:  $("#left-menu a.active").offset().top
        }, 500);
    }
    $("#left-menu ul li ul a.active").parent().parent().addClass('open').parent();
    $('#left-menu ul a').on('click', function (e) {
        if ($(this).parent().has('ul').length > 0) {
            e.preventDefault();
            $(this).toggleClass('open');
            $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            $(this).next('ul').toggleClass('open');
        }
    });
    $('.form-control').on('focus', function () {
        $(this).parent().addClass('focused');
    });
    $('.form-control').on('blur', function () {
        $(this).parent().removeClass('focused');
    });
    $('.back').on('click', function (e) {
        e.preventDefault();
        $('.nav-tabs li.active').prev().find('a').tab('show');
    });
    $('.next').on('click', function (e) {
        e.preventDefault();
        $('.nav-tabs li.active').next().find('a').tab('show');
    });
    $('#open-left-menu').on('click', function(e){
        e.preventDefault()
        $('#left-menu').toggleClass('open');
        $(this).toggleClass('active');
    });
});

function checkIfInView(element){
    var offset =( element.offset().top + 50 ) - $(window).scrollTop();

    if(offset > window.innerHeight){
        return false;
    }
    return true;
}

function showModalAlert(message){
    $('#modal-alert').find('.message').text(message);
    $('#modal-alert').modal('show');
}

