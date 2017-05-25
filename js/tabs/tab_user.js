var classColor = 'success';
var $table = $('#table_user');
var $alert_add = $('#wrong_fields');
var $alert_edit = $('#wrong_fields_edit');
var add_user = $('#add-user');
var edit_user = $('#edit-user');
$table
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
    $("#editUser").on('click', function () {
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length > 1) {
            $("#modal-ch-multi").modal({backdrop: "static"});
        } else if (selection.length === 1) {
            $("#modal_edit_user").modal({backdrop: "static"});
        } else if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        }
    });
    $("#addUser").on('click', function () {
        $("#modal_add_user").modal({backdrop: "static"});
    });
    $("#deleteUser").on('click', function () {
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        } else {
            $("#modal_delete_user").modal({backdrop: "static"});
        }
    });
});
$('#username').on('keyup', function () {
    var $user_field = $(this);
    var username = $.trim($user_field.val());
    var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
    if ((username === '') || ( !regex.test($(this).val()) )) {
        $user_field.removeClass('accepted_field').addClass('required_field');
    } else {
        $user_field.removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#add-user')) {
        $alert_add.addClass('hidden');
    } else {
        $alert_add.removeClass('hidden');
    }
}).on('keydown', function (e) {
    if (e.keyCode === 32) {
        return false;
    }
});
$('#password').on('keyup', function () {
    var $pass_field = $(this);
    var password = $.trim($pass_field.val());
    var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    if ((password === '') || ( !regex.test($pass_field.val()) )) {
        $pass_field.removeClass('accepted_field').addClass('required_field');
    } else {
        $pass_field.removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#add-user')) {
        $alert_add.addClass('hidden');
    } else {
        $alert_add.removeClass('hidden');
    }
}).on('keydown', function (e) {
    if (e.keyCode === 32) {
        return false;
    }
});
$('#pib').on('keyup', function () {
    var $field = $(this);
    var pib = $.trim($field.val());
    if (pib === '') {
        $field.removeClass('accepted_field').addClass('required_field');
    } else {
        $field.removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#add-user')) {
        $alert_add.addClass('hidden');
    } else {
        $alert_add.removeClass('hidden');
    }
});
$('#memberof').on('change', function () {
    if ($(this).val() !== '') {
        $(this).removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#add-user')) {
        $alert_add.addClass('hidden');
    } else {
        $alert_add.removeClass('hidden');
    }
});
$('#ltoggle').on('click', function () {
    var chbox = $('#activeUser');
    var title = $('#title');
    if (chbox.is(':checked')) {
        $(this).removeClass('btn-success').addClass('btn-danger');
        chbox.prop('checked', false);
        title.html("<i class='fa fa-ban'></i> Ні");
    } else {
        $(this).removeClass('btn-danger').addClass('btn-success');
        chbox.prop('checked', true);
        title.html("<i class='fa fa-check'></i> Так");
    }
});
$('#ltoggle_edit').on('click', function () {
    var chbox = $('#activeUser_edit');
    var title = $('#title_edit');
    if (chbox.is(':checked')) {
        $(this).removeClass('btn-success').addClass('btn-danger');
        chbox.prop('checked', false);
        title.html("<i class='fa fa-ban'></i> Ні");
    } else {
        $(this).removeClass('btn-danger').addClass('btn-success');
        chbox.prop('checked', true);
        title.html("<i class='fa fa-check'></i> Так");
    }
});

add_user.on('submit', function () {
    var noError = true;

    var $username = $('#username');
    var user = $.trim($username.val());
    var $password = $('#password');
    var pass = $.trim($password.val());
    var $pib = $('#pib');
    var full_name = $.trim($pib.val());
    var $member = $('#memberof');
    var group = $.trim($member.val());

    if (user === '') {
        $alert_add.removeClass('hidden');
        $username.addClass('required_field');
        noError = false;
    }
    if (pass === '') {
        $alert_add.removeClass('hidden');
        $password.addClass('required_field');
        noError = false;
    }
    if (full_name === '') {
        $alert_add.removeClass('hidden');
        $pib.addClass('required_field');
        noError = false;
    }
    if (group === '') {
        $alert_add.removeClass('hidden');
        $member.addClass('required_field');
        noError = false;
    }
    if (!$alert_add.hasClass('hidden')) {
        noError = false;
    }
    return noError;
});
function checkFields(form) {
    var fields = $(form).find(".form-control").filter('.required_field');
    var bool = true;
    if (fields.length !== 0) {
        bool = false;
    }
    return bool;
}

$(document).ready(function () {
    $("#modal_add_user").on('shown.bs.modal', function () {
        add_user.find('.form-control').val('').removeClass('required_field')
            .removeClass('accepted_field');
    });
    $("#modal_edit_user").on('show.bs.modal', function () {
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
            $('#ltoggle_edit').removeClass('btn-danger').addClass('btn-success');
            $('#activeUser_edit').prop('checked', true);
            $('#title_edit').html("<i class='fa fa-check'></i> Так");
        } else {
            $('#ltoggle_edit').removeClass('btn-success').addClass('btn-danger');
            $('#activeUser_edit').prop('checked', false);
            $('#title_edit').html("<i class='fa fa-ban'></i> Ні");
        }
    });
    $("#modal_delete_user").on('show.bs.modal', function () {
        var selection = $table.bootstrapTable('getSelections');
        var selectedJS = JSON.stringify(selection, null, 4);
        $('#del_user_textT').html("<pre>"+selectedJS+"</pre>");
        var ids = '';
        var usernames = '';
        $.each(selection, function (i, row) {
            ids += row['id_user']+"; ";
            usernames += "<li>"+row['username']+" ("+row['full_name']+")"+"</li>";
        });
        $('#id_user_delete').val(ids);
        $('#del_user_text').html("<ul>"+usernames+"</ul>");
    });
});

edit_user.on('submit', function () {
    var noError_edit = true;
    var $username = $('#username_edit');
    var user = $.trim($username.val());
    var $pib = $('#pib_edit');
    var full_name = $.trim($pib.val());
    var $member = $('#memberof_edit');
    var group = $.trim($member.val());

    if (user === '') {
        $alert_edit.removeClass('hidden');
        $username.addClass('required_field');
        noError_edit = false;
    }
    if (full_name === '') {
        $alert_edit.removeClass('hidden');
        $pib.addClass('required_field');
        noError_edit = false;
    }
    if (group === '') {
        $alert_edit.removeClass('hidden');
        $member.addClass('required_field');
        noError_edit = false;
    }
    if (!$alert_edit.hasClass('hidden')) {
        noError_edit = false;
    }
    return noError_edit;
});
$('#username_edit').on('keyup', function () {
    var $user_field = $(this);
    var username = $.trim($user_field.val());
    var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
    if ((username === '') || ( !regex.test($user_field.val()) )) {
        $user_field.removeClass('accepted_field').addClass('required_field');
    } else {
        $user_field.removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#edit-user')) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
}).on('keydown', function (e) {
    if (e.keyCode === 32) {
        return false;
    }
});
$('#password_edit').on('keyup', function () {
    var $pass_field = $(this);
    var password = $.trim($pass_field.val());
    var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    if  ( !regex.test($pass_field.val()) ) {
        $pass_field.removeClass('accepted_field').addClass('required_field');
    } else {
        $pass_field.removeClass('required_field').addClass('accepted_field');
    }
    if (password === '') {
        $pass_field.removeClass('required_field');
    }
    if(checkFields('#edit-user')) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
}).on('keydown', function (e) {
    if (e.keyCode === 32) {
        return false;
    }
});
$('#pib_edit').on('keyup', function () {
    var $field = $(this);
    var pib = $.trim($field.val());
    if (pib === '') {
        $field.removeClass('accepted_field').addClass('required_field');
    } else {
        $field.removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#edit-user')) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});
$('#memberof_edit').on('change', function () {
    if ($(this).val() !== '') {
        $(this).removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields('#edit-user')) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});