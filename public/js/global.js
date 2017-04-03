function showFormValidationError(form, errors) {
    var alertDiv = form.find('div.alert');
    alertDiv.on('animationend', function(){
        $(this).removeClass('animated shake')
    });
    alertDiv.empty()
    form.find('[name="'+i+'"]').parent().removeClass('alert-warning');
    for (var i in errors) {
        alertDiv.append('<p>' + errors[i][0] + '</p>');
        form.find('[name="'+i+'"]').parent().addClass('alert-warning');
    }
    alertDiv.show().addClass('animated shake');
}