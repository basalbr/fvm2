$(function () {
    $('#left-menu ul a').on('click', function (e) {
        if ($(this).parent().has('ul').length > 0){
            e.preventDefault();
            $(this).toggleClass('open');
            $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            $(this).next('ul').toggleClass('open');
        }
    });
});
