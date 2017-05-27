var classColor = 'success';
var $table = $('#table_type_fu');
var $form_add = $("#add-row");
var $alert_add = $('#wrong_fields');
var $type_sub = $('#type_sub');
$table
    .on('all.bs.table', function (e, name, args) {
        $('tbody').find('.selected').addClass(classColor);
    })
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
    $("#edit_row").on('click', function () {
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length > 1) {
            $("#modal-ch-multi").modal({backdrop: "static"});
        } else if (selection.length === 1) {
            $("#modal_edit_user").modal({backdrop: "static"});
        } else if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        }
    });
    $("#add_row").on('click', function () {
        $("#modal_add_row").modal({backdrop: "static"});
    });
    $("#delete_row").on('click', function () {
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        } else {
            $("#modal_delete_user").modal({backdrop: "static"});
        }
    });
    $form_add.on('shown.bs.modal', function () {
        $form_add.find('.form-control').val('').removeClass('required_field')
            .removeClass('accepted_field');
    });
    $form_add.on('submit', function () {
        var noError_add = true;
        var val = $.trim($type_sub.val());
        if (val === '') {
            $alert_add.removeClass('hidden');
            $type_sub.addClass('required_field');
            noError_add = false;
        }
        if (!$alert_add.hasClass('hidden')) {
            noError_add = false;
        }
        return noError_add;
    });
    $type_sub.on('keyup', function () {
        var $type_field = $(this);
        var type = $.trim($type_field.val());
        var regex = /[a-zA-Zа-яїєА-ЯЇЄ]{1,20}/;
        //var regex = /\w{1,20}/;
        if ((type === '') || ( !regex.test($type_field.val()) )) {
            $type_field.removeClass('accepted_field').addClass('required_field');
        } else {
            $type_field.removeClass('required_field').addClass('accepted_field');
        }
        if(checkFields($form_add)) {
            $alert_add.addClass('hidden');
        } else {
            $alert_add.removeClass('hidden');
        }
    });
    function checkFields(form) {
        var fields = form.find(".form-control").filter('.required_field');
        var bool = true;
        if (fields.length !== 0) {
            bool = false;
        }
        return bool;
    }
});