$("#table_user").on('click-row.bs.table', function (e, row, $element) {
    var classColor = 'success';
    if($($element).hasClass(classColor)) {
        $($element).removeClass(classColor);
    } else {
        $($element).addClass(classColor);
    }
});
$(document).ready(function () {
    $("#editUser").click(function () {
        var $table = $('#table_user');
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length > 1) {
            $("#modal-ch-multi").modal({backdrop: "static"});
        } else if (selection.length == 1) {
            $("#modal_edit_n").modal({backdrop: "static"});
        } else if (selection.length == 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        }
    });
    $("#addUser").click(function () {
        $("#modal_add_user").modal({backdrop: "static"});
    });
});
$('#username').keyup(function() {
    var $user_field  = $('#username');
    var username = $.trim($user_field.val());
    var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
    if ( (username === '') || ( !regex.test( $(this).val() ) ) ) {
        $user_field.removeClass('accepted_field');
        $user_field.addClass('required_field');
        $('#wrong_fields').removeClass('hidden');
    } else {
        $user_field.removeClass('required_field');
        $user_field.addClass('accepted_field');
        $('#wrong_fields').addClass('hidden');
    }
});
$('#password').keyup(function() {
    var $pass_field = $('#password');
    var password = $.trim($pass_field.val());
    var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    if ( (password === '') || ( !regex.test( $(this).val() ) ) ) {
        $pass_field.removeClass('accepted_field');
        $pass_field.addClass('required_field');
        $('#wrong_fields').removeClass('hidden');
    } else {
        $pass_field.removeClass('required_field');
        $pass_field.addClass('accepted_field');
        $('#wrong_fields').addClass('hidden');
    }
});
$('#pib').keyup(function() {
    var $field = $(this);
    var pib = $.trim($field.val());
    if (pib === '') {
        $field.removeClass('accepted_field');
        $field.addClass('required_field');
        $('#wrong_fields').removeClass('hidden');
    } else {
        $field.removeClass('required_field');
        $field.addClass('accepted_field');
        $('#wrong_fields').addClass('hidden');
    }
});
$('#memberof').on('change', function () {
    if ($(this).val() != '') {
        $(this).removeClass('required_field');
        $(this).addClass('accepted_field');
    }
});
$('#ltoggle').on('click', function () {
    var chbox = $('#activeUser');
    var title = $('#title');
    if (chbox.is(':checked')) {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        chbox.prop('checked',false);
        title.html("<i class='fa fa-ban'></i> Ні");
    } else {
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-success');
        chbox.prop('checked',true);
        title.html("<i class='fa fa-check'></i> Так");
    }
});
var noError = true;
$('#add-user').submit(function () {

    var $alert = $('#wrong_fields');
    var $username = $('#username');
    var user = $.trim($username.val());
    var $password = $('#password');
    var pass = $.trim($password.val());
    var $pib = $('#pib');
    var full_name = $.trim($pib.val());
    var $member = $('#memberof');
    var group = $.trim($member.val());

    if (user === '') {
        $alert.removeClass('hidden');
        $username.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    if (pass === '') {
        $alert.removeClass('hidden');
        $password.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }

    if (full_name === '') {
        $alert.removeClass('hidden');
        $pib.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    if (group === '') {
        $alert.removeClass('hidden');
        $member.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    /*if (($('#vid_perevirkiS').val()!=3)&&($('#pidstava_pozaplanS').isDisabled)) {
     alert("($('#vid_perevirkiS').val()!=2)&&($('#pidstava_pozaplanS').isDisabled()");
     $('#pidstava_pozaplanS').addClass('required_field');
     noError = false;
     }*/
    if(!$alert.hasClass('hidden')) {
        noError = false;
    }
    return noError;
});