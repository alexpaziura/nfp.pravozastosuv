var classColor = 'success';
$("#table_user")
    .on('click-row.bs.table', function (e, row, $element) {
    if ($($element).hasClass(classColor)) {
        $($element).removeClass(classColor);
    } else {
        $($element).addClass(classColor);
    }
    })
    .on('check.bs.table', function (e, row, $element) {
        $($element).parent().parent().addClass(classColor);
    })
    .on('uncheck.bs.table', function (e, row, $element) {
        $($element).parent().parent().removeClass(classColor);
    })
    .on('check-all.bs.table', function (e, $element) {
        $($element).parent().parent().addClass(classColor);
    })
    .on('uncheck-all.bs.table', function (e, $element) {
        $($element).parent().parent().removeClass(classColor);
    });
$(document).ready(function () {
    $("#editUser").click(function () {
        var $table = $('#table_user');
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length > 1) {
            $("#modal-ch-multi").modal({backdrop: "static"});
        } else if (selection.length == 1) {
            $("#modal_edit_user").modal({backdrop: "static"});
        } else if (selection.length == 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        }
    });
    $("#addUser").click(function () {
        $("#modal_add_user").modal({backdrop: "static"});
    });
});
$('#username').keyup(function () {
    var $user_field = $('#username');
    var username = $.trim($user_field.val());
    var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
    if ((username === '') || ( !regex.test($(this).val()) )) {
        $user_field.removeClass('accepted_field');
        $user_field.addClass('required_field');
        $('#wrong_fields').removeClass('hidden');
    } else {
        $user_field.removeClass('required_field');
        $user_field.addClass('accepted_field');
        $('#wrong_fields').addClass('hidden');
    }
});
$('#password').keyup(function () {
    var $pass_field = $('#password');
    var password = $.trim($pass_field.val());
    var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    if ((password === '') || ( !regex.test($(this).val()) )) {
        $pass_field.removeClass('accepted_field');
        $pass_field.addClass('required_field');
        $('#wrong_fields').removeClass('hidden');
    } else {
        $pass_field.removeClass('required_field');
        $pass_field.addClass('accepted_field');
        $('#wrong_fields').addClass('hidden');
    }
});
$('#pib').keyup(function () {
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
        chbox.prop('checked', false);
        title.html("<i class='fa fa-ban'></i> Ні");
    } else {
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-success');
        chbox.prop('checked', true);
        title.html("<i class='fa fa-check'></i> Так");
    }
});
$('#ltoggle_edit').on('click', function () {
    var chbox = $('#activeUser_edit');
    var title = $('#title_edit');
    if (chbox.is(':checked')) {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        chbox.prop('checked', false);
        title.html("<i class='fa fa-ban'></i> Ні");
    } else {
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-success');
        chbox.prop('checked', true);
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
    if (!$alert.hasClass('hidden')) {
        noError = false;
    }
    return noError;
});
$(document).ready(function () {
    $("#modal_edit_user").on('show.bs.modal', function () {
        var $table = $('#table_user');
        var selection = $table.bootstrapTable('getSelections');
        var selectedRow = selection[0];
        var selectedRowJS = JSON.stringify(selectedRow);
        $('#id_user').val(selectedRow.id_user);
        $('#username_edit').val(selectedRow.username);
        $('#pib_edit').val(selectedRow.full_name);
        var memberof = '';
        switch (selectedRow.memberof) {
            case "ДеРЗІТ":
                memberof = 'DeRZIT';
                break;
            case "НПЗ":
                memberof = 'NPZ';
                break;
            case "ЮР":
                memberof = 'UR';
                break;
            case "СК":
                memberof = 'SK';
                break;
            case "ФК":
                memberof = 'FK';
                break;
            case "КС":
                memberof = 'KS';
                break;
            case "РРФП":
                memberof = 'RRFP';
                break;
            case "Read":
                memberof = 'All_read';
                break;
        }
        $('#memberof_edit').val(memberof);
        if(selectedRow.active_user === '<i class="fa fa-check" style="color:#5cb85c;"></i>') {
            $('#ltoggle_edit').removeClass('btn-danger');
            $('#ltoggle_edit').addClass('btn-success');
            $('#activeUser_edit').prop('checked', true);
            $('#title_edit').html("<i class='fa fa-check'></i> Так");
        } else {
            $('#ltoggle_edit').removeClass('btn-success');
            $('#ltoggle_edit').addClass('btn-danger');
            $('#activeUser_edit').prop('checked', false);
            $('#title_edit').html("<i class='fa fa-ban'></i> Ні");
        }
    });
});