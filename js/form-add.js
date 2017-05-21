var noError = true;
$('#add-form').submit(function () {

    var $alert = $('#wrong_fields');
    var $nzp_field  = $('#nzp');
    var nzp = $.trim($nzp_field.val());
    var $short_name_fu = $('#short_name_fu');
    var short_name_fu = $.trim($short_name_fu.val());
    var $edrpoE = $('#edrpoE');
    var edrpoE = $.trim($edrpoE.val());
    var $type_fo = $('#type_fo');
    var type_fo = $.trim($type_fo.val());

    if (nzp === '') {
        $alert.removeClass('hidden');
        $nzp_field.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    if (short_name_fu === '') {
        $alert.removeClass('hidden');
        $short_name_fu.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    if (edrpoE === '') {
        $alert.removeClass('hidden');
        $edrpoE.addClass('required_field');
        noError = false;
    } else {
        noError = true;
    }
    if (type_fo === '') {
        $alert.removeClass('hidden');
        $type_fo.addClass('required_field');
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

$('#nzp').keyup(function() {
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
$('#short_name_fu').keyup(function() {
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
$('#edrpoE').keyup(function() {
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
$('.suma').keyup(function() {
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
$('.input-nomer').keydown(function (e) {
    if ( (e.keyCode === 32) || ( (e.shiftKey === true)&&(e.keyCode === 51) )) {
        return false;
    }
});
$("#modal-add-naglyad").on('shown.bs.modal', function () {
    $('#add-form input .form-control').val('');
    $('#add-form .form-control').removeClass('required_field');
    $('#add-form .form-control').removeClass('accepted_field');
    $('#add-form .form-control').popover('hide');
});
$(document).ready(function(){
    $('#nzp').popover({title: "Поле обов'язкове для заповнення!", content: "Допускаються тільки цифри!",
        trigger: "manual", placement: "top", animation:true });
    $('#short_name_fu').popover({content: "Поле обов'язкове для заповнення!", trigger: "manual", placement: "top",
        animation: true});
    $('#edrpoE').popover({title: "Поле обов'язкове для заповнення!",
        content: "Формат запису: 99999999999 або АА 999999", trigger: "manual", placement: "top",
        animation: true});
    $('.suma').popover({title: "Допускаються тільки цифри і крапка!",
        content: "Формат запису: 999999999.99", trigger: "manual", placement: "top",
        animation: true});

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