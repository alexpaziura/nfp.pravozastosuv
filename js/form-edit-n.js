var $alert_edit = $('#wrong_fields_edit');
var edit_form_n = $('#edit-form-n');
var $nzp_fieldE  = $('#nzpE');
var $short_name_fuE = $('#short_name_fuE');
var $edrpoEE = $('#edrpoEE');
var $type_foE = $('#type_foE');
var $vid_perevirkiSE = $('#vid_perevirkiSE');
var $pidstava_pozaplanSE = $('#pidstava_pozaplanSE');
edit_form_n.on('submit', function () {
    var noError = true;
    var nzp = $.trim($nzp_fieldE.val());
    var short_name_fu = $.trim($short_name_fuE.val());
    var edrpoE = $.trim($edrpoEE.val());
    var type_fo = $.trim($type_foE.val());

    if (nzp === '') {
        $alert_edit.removeClass('hidden');
        $nzp_fieldE.addClass('required_field');
        noError = false;
    }
    if (short_name_fu === '') {
        $alert_edit.removeClass('hidden');
        $short_name_fuE.addClass('required_field');
        noError = false;
    }
    if (edrpoE === '') {
        $alert_edit.removeClass('hidden');
        $edrpoEE.addClass('required_field');
        noError = false;
    }
    if (type_fo === '') {
        $alert_edit.removeClass('hidden');
        $type_foE.addClass('required_field');
        noError = false;
    }
    if (!$alert_edit.hasClass('hidden')) {
        noError = false;
    }
    return noError;
});
$nzp_fieldE.on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /^[0-9]{1,11}$/;
    if ( (val === '') || ( !regex.test( $field.val() ) ) ) {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields_edit()) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});
$short_name_fuE.on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    if (val === '') {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields_edit()) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});
$edrpoEE.keyup(function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /(([A-Z]{1,2}) ([0-9]{6}))|([0-9]{8,12})/;
    if ( (val === '') || ( !regex.test( val ) ) ) {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields_edit()) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});
/*$('#suma_shtraf').keyup(function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /^\d+(\.\d{1,2})?$/;
    if ( !regex.test( val ))   {
        $('#wrong_fields').removeClass('hidden');
        $field.removeClass('accepted_field');
        $field.addClass('required_field');
        $field.popover('show');
    } else {
        $('#wrong_fields').addClass('hidden');
        $field.removeClass('required_field');
        $field.addClass('accepted_field');
        $field.popover('hide');
    }
    if (val === '') {
        $('#wrong_fields').addClass('hidden');
        $field.removeClass('required_field');
        $field.removeClass('accepted_field');
        $field.popover('hide');
    }
});*/
$type_foE.on('change', function () {
    if ($(this).val() !== '') {
        $(this).removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields_edit()) {
        $alert_edit.addClass('hidden');
    } else {
        $alert_edit.removeClass('hidden');
    }
});
function checkFields_edit() {
    var fields = edit_form_n.find(".form-control").filter('.required_field');
    var bool = true;
    if (fields.length !== 0) {
        bool = false;
    }
    return bool;
}
$(document).ready(function(){
    $nzp_fieldE.popover({title: "Поле обов'язкове для заповнення!", content: "Допускаються тільки цифри!",
        trigger: "manual", placement: "top", animation:true });
    $short_name_fuE.popover({content: "Поле обов'язкове для заповнення!", trigger: "manual", placement: "top",
        animation: true});
    $edrpoEE.popover({title: "Поле обов'язкове для заповнення!",
        content: "Формат запису: 99999999999 або АА 999999", trigger: "manual", placement: "top",
        animation: true});
/*    $('#suma_shtrafE').popover({title: "Допускаються тільки цифри і крапка!",
        content: "Формат запису: 999999999.99", trigger: "manual", placement: "top",
        animation: true});*/
});
$(document).ready(function () {

    $("#modal_edit_n")
        .on('show.bs.modal', function () {
        $(this).find('.form-control').removeClass('required_field')
            .removeClass('accepted_field').popover('hide');
    })
        .on('shown.bs.modal', function () {
        var $table = $('#table');
        var selection = $table.bootstrapTable('getSelections');
        var selectedRow = selection[0];
        var selectedRowJS = JSON.stringify(selectedRow);
        var rowTable = [];

        $('#id_inspekt').val(selectedRow.id_inspekt);
        $nzp_fieldE.val(selectedRow.nzp);
        $short_name_fuE.val(selectedRow.short_name_fu);
        //$('#short_name_fuE').val(selectedRowJS);
        $edrpoEE.val(selectedRow.edrpo);

        var tmp1 = selectedRow.type_fo.substring(20);
        var typeFU = tmp1.substring(0,tmp1.indexOf("</div>"));

        $type_foE.find('option').filter(function( index ) {
            return $( this ).prop( "visib" ) === "0";
        }).attr("hidden", "hidden");
        $type_foE.find('option').prop("selected", false);
        $type_foE.find("[value='"+typeFU+"']").prop("selected", "selected");

        var tmp2 = selectedRow.vid_perevirki.substring(20);
        var vid_perev = tmp2.substring(0, tmp2.indexOf("</div>"));

        $vid_perevirkiSE.find('option').filter(function ( index ) {
            return $(this).prop("visib") === "0";
        }).attr("hidden", "hidden");
        $vid_perevirkiSE.find('option').prop("selected", false);
        $vid_perevirkiSE.find("[value='"+vid_perev+"']").prop("selected","selected");

        var tmp3 = selectedRow.pidstava_pozaplan.trim().substring(20);
        var pozaplan = tmp3.substring(0, tmp3.indexOf("</div>"));
        if ($vid_perevirkiSE.val() === '3') {
            $pidstava_pozaplanSE.prop('disabled', false).multiselect('refresh').multiselect('enable');
        }
        else {
            $pidstava_pozaplanSE.prop('disabled', 'disabled').multiselect('refresh').multiselect('disable');
        }
        $pidstava_pozaplanSE.multiselect('deselectAll', false).multiselect('refresh');
        if (pozaplan.length !== 0) {
            var re = /\s*;\s*/;
            var pidstavs = pozaplan.split(re);
            for (var i=0; i<pidstavs.length-1;i++) {
                $pidstava_pozaplanSE.multiselect('select', pidstavs[i])
            }
        }
        $("#d_start_perevirkiDE").datepicker("update", selectedRow.d_start_perevirki);
        $("#d_end_perevirkiDE").datepicker("update", selectedRow.d_end_perevirki);
        $("#d_start_dialnistDE").datepicker("update", selectedRow.d_start_dialnist);
        $("#d_end_dialnistDE").datepicker("update", selectedRow.d_end_dialnist);
        $("#d_nak_zahDE").datepicker("update", selectedRow.d_nak_zah);
        $('#n_nak_zahE').val(selectedRow.n_nak_zah);
        $("#d_napr_provedDE").datepicker("update", selectedRow.d_napr_proved);
        $('#n_napr_provedE').val(selectedRow.n_napr_proved);


    });
    edit_form_n.find('.input-nomer').on('keydown', function (e) {
        if ( (e.keyCode === 32) || ( (e.shiftKey === true)&&(e.keyCode === 51) )) {
            return false;
        }
    });
    $vid_perevirkiSE.on('change', function () {
        if ($(this).val() === '3') {
            $pidstava_pozaplanSE.prop('disabled', false).multiselect('refresh').multiselect('enable');
        }
        else {
            $pidstava_pozaplanSE.prop('disabled', 'disabled').multiselect('refresh').multiselect('disable');
        }
    });
    $pidstava_pozaplanSE.multiselect({
        nonSelectedText: 'Виберіть підставу!',
        allSelectedText: 'Вибрано всі підстави',
        disabledText: 'Заблоковано!',
        delimiterText: '; ',
        selectAllName: 'select-all-name',
        inheritClass: true,
        buttonWidth: '100%'
    });

    /*$("#vid_akt_zu").selectBoxIt({
     theme: "default",
     autoWidth: false
     });*/
});