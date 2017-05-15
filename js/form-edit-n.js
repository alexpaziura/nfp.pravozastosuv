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
        var rowTable = [];

        /*$.post("requests.php", { id_inst_row: selectedRow.id_inspekt })
            .done(function(data) {
                alert("Data Loaded: " +  data);
                rowTable = $.parseJSON(data);
            });*/
        $('#id_inspekt').val(selectedRow.id_inspekt);
        $("#nzpE").val(selectedRow.nzp);
        //$('#short_name_fuE').val(selectedRow.short_name_fu);
        $('#short_name_fuE').val(selectedRowJS);
        $('#edrpoEE').val(selectedRow.edrpo);
        var tmp1 = selectedRow.type_fo.substring(20);
        var typeFU = tmp1.substring(0,tmp1.indexOf("</div>"));
        $('#type_foE').find('option').filter(function( index ) {
            return $( this ).attr( "visib" ) === "0";
        }).attr("hidden", "hidden");
        $('#type_foE').find('option').attr("selected", false);
        $("#type_foE [value='"+typeFU+"']").attr("selected", "selected");
        tmp1 = selectedRow.vid_perevirki.substring(20);
        var vid_perev = tmp1.substring(0, tmp1.indexOf("</div>"));
        $('#vid_perevirkiSE').find('option').filter(function ( index ) {
            return $(this).attr("visib") === "0";
        }).attr("hidden", "hidden");
        $('#vid_perevirkiSE').find('option').attr("selected", false);
        $("#vid_perevirkiSE [value='"+vid_perev+"']").prop("selected","selected");
        tmp1 = selectedRow.pidstava_pozaplan.trim().substring(20);
        var pozaplan = tmp1.substring(0, tmp1.indexOf("</div>"));
        if ($('#vid_perevirkiSE').val() === '3') {
            $('#pidstava_pozaplanSE').prop('disabled', false);
            $('#pidstava_pozaplanSE').multiselect('refresh');
            $("#pidstava_pozaplanSE").multiselect('enable');
        }
        else {
            $('#pidstava_pozaplanSE').prop('disabled', 'disabled');
            $('#pidstava_pozaplanSE').multiselect('refresh');
            $('#pidstava_pozaplanSE').multiselect('disable');
        }
        $('#pidstava_pozaplanSE').multiselect('deselectAll', false);
        $('#pidstava_pozaplanSE').multiselect('refresh');
        if (pozaplan.length !== 0) {
            var re = /\s*;\s*/;
            var pidstavs = pozaplan.split(re);
            for (var i=0; i<pidstavs.length-1;i++) {
                $('#pidstava_pozaplanSE').multiselect('select', pidstavs[i])
            }
        }


    });
    $('#vid_perevirkiSE').on('change', function () {
        if ($(this).val() == '3') {
            $('#pidstava_pozaplanSE').prop('disabled', false);
            $('#pidstava_pozaplanSE').multiselect('refresh');
            $("#pidstava_pozaplanSE").multiselect('enable');
        }
        else {
            $('#pidstava_pozaplanSE').prop('disabled', 'disabled');
            $('#pidstava_pozaplanSE').multiselect('refresh');
            $('#pidstava_pozaplanSE').multiselect('disable');
        }
    });
    $('#pidstava_pozaplanSE').multiselect({
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