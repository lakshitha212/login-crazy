/**
 * Created by ENCYTE-PC on 6/7/2016.
 */
$(function () {
    $('a[href*="account/login"],a[href*="account/register"]').click(function (event) {
        if ($(this).attr('href').indexOf("&key=register") == -1) {
            event.preventDefault();
            $("#modal-logincrazy").modal("show");
        }
    });
    $('#quick-login .loginaccount').click(function () {
        $.ajax({
            url: 'index.php?route=module/login_crazy/login',
            type: 'post',
            data: $('#quick-login input[type=\'text\'], #quick-login input[type=\'password\']'),
            dataType: 'json',
            beforeSend: function () {
                $('#quick-login .loginaccount').button('loading');
                $('#modal-logincrazy .alert-danger').remove();
            },
            complete: function () {
                $('#quick-login .loginaccount').button('reset');
            },
            success: function (json) {
                $('#modal-logincrazy .form-group').removeClass('has-error');
                if (json['islogged']) {
                    window.location.href = "index.php?route=account/account";
                }
                if (json['error']) {
                    $('#modal-logincrazy .modal-header').after('<div class="alert alert-danger" style="margin:5px;"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                    $('#quick-login #input-email').parent().addClass('has-error');
                    $('#quick-login #input-password').parent().addClass('has-error');
                    $('#quick-login #input-email').focus();
                }
                if (json['success']) {
                    location.reload();
                    $('#modal-logincrazy').modal('hide');
                }

            }
        });
    });
});
