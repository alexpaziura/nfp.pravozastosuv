var classColor = 'success';
$("#table_type_fu")
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
    $("#edit_row").click(function () {
        var $table = $('#table_type_fu');
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length > 1) {
            $("#modal-ch-multi").modal({backdrop: "static"});
        } else if (selection.length === 1) {
            $("#modal_edit_user").modal({backdrop: "static"});
        } else if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        }
    });
    $("#add_row").click(function () {
        $("#modal_add_row").modal({backdrop: "static"});
    });
    $("#delete_row").click(function () {
        var $table = $('#table_type_fu');
        var selection = $table.bootstrapTable('getSelections');
        if (selection.length === 0) {
            $("#modal-ch-0").modal({backdrop: "static"});
        } else {
            $("#modal_delete_user").modal({backdrop: "static"});
        }
    });
});