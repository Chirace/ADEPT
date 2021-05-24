$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
});

$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
});

/*let modal_radio_redirection
if($('#id_bouton_radio').is(':checked'))
{
    modal_radio_redirection = 
}*/
