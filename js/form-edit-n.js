var noError = true;
$('#edit-form-n').submit(function () {

    var $alert = $('#wrong_fields_edit');
    var $nzp_field  = $('#nzpE');
    var nzp = $.trim($nzp_field.val());
    var $short_name_fu = $('#short_name_fuE');
    var short_name_fu = $.trim($short_name_fu.val());
    var $edrpoE = $('#edrpoEE');
    var edrpoE = $.trim($edrpoE.val());
    var $type_fo = $('#type_fo');
    var type_fo = $.trim($type_fo.val());

    if (nzp === '') {
        $('#wrong_fields').removeClass('hidden');
        $nzp_field.addClass('required_field');
        noError = false;
    }
    if (short_name_fu === '') {
        $('#wrong_fields').removeClass('hidden');
        $short_name_fu.addClass('required_field');
        noError = false;
    }
    if (edrpoE === '') {
        $('#wrong_fields').removeClass('hidden');
        $edrpoE.addClass('required_field');
        noError = false;
    }
    if (type_fo === '') {
        $('#wrong_fields').removeClass('hidden');
        $type_fo.addClass('required_field');
        noError = false;
    }
    /*if (($('#vid_perevirkiS').val()!=3)&&($('#pidstava_pozaplanS').isDisabled)) {
     alert("($('#vid_perevirkiS').val()!=2)&&($('#pidstava_pozaplanS').isDisabled()");
     $('#pidstava_pozaplanS').addClass('required_field');
     noError = false;
     }*/
    noError = $alert.hasClass('hidden');
    return noError;
});

$('#nzpE').keyup(function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /^[0-9]{1,11}$/;
    if ( (val === '') || ( !regex.test( val ) ) ) {
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
});
$('#short_name_fuE').keyup(function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    if (val === '') {
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
});
$('#edrpoEE').keyup(function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /(([A-Z]{1,2}) ([0-9]{6}))|([0-9]{8,12})/;
    if ( (val === '') || ( !regex.test( val ) ) ) {
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
});
$('#suma_shtraf').keyup(function() {
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
});
$('#type_fo').on('change', function () {
    if ($(this).val() != '') {
        $(this).removeClass('required_field');
        $(this).addClass('accepted_field');
    }
});
$(document).ready(function(){
    $('#nzpE').popover({title: "Поле обов'язкове для заповнення!", content: "Допускаються тільки цифри!",
        trigger: "manual", placement: "top", animation:true });
    $('#short_name_fuE').popover({content: "Поле обов'язкове для заповнення!", trigger: "manual", placement: "top",
        animation: true});
    $('#edrpoEE').popover({title: "Поле обов'язкове для заповнення!",
        content: "Формат запису: 99999999999 або АА 999999", trigger: "manual", placement: "top",
        animation: true});
    $('#suma_shtraf').popover({title: "Допускаються тільки цифри і крапка!",
        content: "Формат запису: 999999999.99", trigger: "manual", placement: "top",
        animation: true});
});
$(document).ready(function () {
    $("#modal_edit_n").on('show.bs.modal', function () {
        var $table = $('#table');
        var selection = $table.bootstrapTable('getSelections');
        var selectedRow = selection[0];
        var selectedRowJS = JSON.stringify(selectedRow);
        $("#nzpE").val(selectedRow.nzp);
        $('#short_name_fuE').val(selectedRow.short_name_fu);
        $('#edrpoEE').val(selectedRow.edrpo);
    });
    $('#vid_perevirkiS').on('change', function () {
        if ($(this).val() == '3') {
            $('#pidstava_pozaplanS').prop('disabled', false);
            $('#pidstava_pozaplanS').multiselect('refresh');
            $("#pidstava_pozaplanS").multiselect('enable');
        }
        else {
            $('#pidstava_pozaplanS').prop('disabled', 'disabled');
            $('#pidstava_pozaplanS').multiselect('refresh');
            $('#pidstava_pozaplanS').multiselect('disable');
        }
    });
    $('#pidstava_pozaplanS').multiselect({
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