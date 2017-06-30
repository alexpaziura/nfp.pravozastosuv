/**
 * Обработчики для модального окна формы на добавление записи
 * в 1 таблицу для надзорных департаментов
 */

var add_form = $('#add-form');
var $alert = $('#wrong_fields');
var $nzp_field  = $('#nzp');
var $short_name_fu = $('#short_name_fu');
var $edrpoE = $('#edrpoE');
var $type_fo = $('#type_fo');
var $pidstava_pozaplanS = $('#pidstava_pozaplanS');
var $modal_progress = $("#modal-progress");
add_form.on('submit', function () {

    var noError = true;
    var nzp = $.trim($nzp_field.val());
    var short_name_fu = $.trim($short_name_fu.val());
    var edrpoE = $.trim($edrpoE.val());
    var type_fo = $.trim($type_fo.val());
    if (nzp === '') {
        $alert.removeClass('hidden');
        $nzp_field.addClass('required_field');
        noError = false;
    }
    if (short_name_fu === '') {
        $alert.removeClass('hidden');
        $short_name_fu.addClass('required_field');
        noError = false;
    }
    if (edrpoE === '') {
        $alert.removeClass('hidden');
        $edrpoE.addClass('required_field');
        noError = false;
    }
    if (type_fo === '') {
        $alert.removeClass('hidden');
        $type_fo.addClass('required_field');
        noError = false;
    }
    if(!$alert.hasClass('hidden')) {
        noError = false;
    }
    return noError;
});

$("#submit_add").on("click", function () {
    var noError = true;
    var nzp = $.trim($nzp_field.val());
    var short_name_fu = $.trim($short_name_fu.val());
    var edrpoE = $.trim($edrpoE.val());
    var type_fo = $.trim($type_fo.val());
    if (nzp === '') {
        $alert.removeClass('hidden');
        $nzp_field.addClass('required_field');
        noError = false;
    }
    if (short_name_fu === '') {
        $alert.removeClass('hidden');
        $short_name_fu.addClass('required_field');
        noError = false;
    }
    if (edrpoE === '') {
        $alert.removeClass('hidden');
        $edrpoE.addClass('required_field');
        noError = false;
    }
    if (type_fo === '') {
        $alert.removeClass('hidden');
        $type_fo.addClass('required_field');
        noError = false;
    }
    if(!$alert.hasClass('hidden')) {
        noError = false;
    }
    if(!noError) {return false;}
    var ser = add_form.serialize();
    alert(ser);
    $modal_progress.modal({backdrop: "static"});
    //var status = "";
    var curr_page = 1;
/*    $.ajax({
        type:'POST',
        url:'../src/add-forms.php',
        data: ({
            table: "inspekt",
            nzp: nzp,
            short_name_fu: short_name_fu,
            edrpoE: edrpoE,
            type_fo: type_fo}),
        dataType: 'html',
        success:function(mydata){
            mydata = JSON.parse(mydata);
            status = mydata.state;
            curr_page = mydata.page;
            //alert("status: "+status+"\npage: "+curr_page);
            loadData(curr_page);
        },
        error: function () {
            alert("error");
            loadData(1);
        }
    });  */
    $.ajax({
        type:'POST',
        url:'../src/add-forms.php',
        data: ser + "&table=inspekt" ,
        dataType: 'html',
        success:function(mydata){
            mydata = JSON.parse(mydata);
            var status = mydata.state;
            curr_page = mydata.page;
            //alert("status: "+status+"\npage: "+curr_page);
            loadData(curr_page);
            if(status === "success") {
                $('#success_add').removeClass("hidden");
/*                $('#success_add').bind('afterShow', function() {
                    setTimeout(function () {
                        $('#success_add').alert("close");
                    }, 7000);
                });*/
            }
            else {
                $('#error_add').removeClass("hidden");
/*                $('#error_add').bind('afterShow', function() {
                    setTimeout(function () {
                        $('#error_add').alert("close");
                    }, 7000);
                });*/
            }
        },
        error: function () {
            alert("error");
            $('#error_add').removeClass("hidden");
            $('#error_add').bind('afterShow', function() {
                setTimeout(function () {
                    $('#error_add').alert("close");
                }, 7000);
            });
            loadData(1);
        }
    });
    //alert("status: "+status+"\npage: "+curr_page);
    //loadData(curr_page);
    $("#modal-add-naglyad").modal('toggle');

});
$nzp_field.on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /^[0-9]{1,11}$/;
    if ( (val === '') || ( !regex.test( val ) ) ) {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields()) {
        $alert.addClass('hidden');
    } else {
        $alert.removeClass('hidden');
    }
});
$short_name_fu.on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    if (val === '') {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields()) {
        $alert.addClass('hidden');
    } else {
        $alert.removeClass('hidden');
    }
});
$edrpoE.on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /(([A-Z]{1,2}) ([0-9]{6}))|([0-9]{8,12})/;
    if ( (val === '') || ( !regex.test( val ) ) ) {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if(checkFields()) {
        $alert.addClass('hidden');
    } else {
        $alert.removeClass('hidden');
    }
});
add_form.find('.suma').on('keyup', function() {
    var $field  = $(this);
    var val = $.trim($field.val());
    var regex = /^\d+(\.\d{1,2})?$/;
    if ( !regex.test( val ))   {
        $field.removeClass('accepted_field').addClass('required_field').popover('show');
    } else {
        $field.removeClass('required_field').addClass('accepted_field').popover('hide');
    }
    if (val === '') {
        $field.removeClass('required_field').removeClass('accepted_field').popover('hide');
    }
    if(checkFields()) {
        $alert.addClass('hidden');
    } else {
        $alert.removeClass('hidden');
    }
});
$type_fo.on('change', function () {
    if ($(this).val() !== '') {
        $(this).removeClass('required_field').addClass('accepted_field');
    }
    if(checkFields()) {
        $alert.addClass('hidden');
    } else {
        $alert.removeClass('hidden');
    }
});
function checkFields() {
    //var fields = add_form.find(".form-control").filter('.required_field');
    var fields = add_form.find(".form-control").filter('.required_field');
    var bool = true;
    if (fields.length !== 0) {
        bool = false;
    }
    return bool;
}
add_form.find('.input-nomer').on('keydown', function (e) {
    if ( (e.keyCode === 32) || ( (e.shiftKey === true)&&(e.keyCode === 51) )) {
        return false;
    }
});
$("#modal-add-naglyad").on('shown.bs.modal', function () {
    add_form.find('.form-control').val('').removeClass('required_field')
        .removeClass('accepted_field').popover('hide');
});
$(document).ready(function(){
    $nzp_field.popover({title: "Поле обов'язкове для заповнення!", content: "Допускаються тільки цифри!",
        trigger: "manual", placement: "top", animation:true });
    $short_name_fu.popover({content: "Поле обов'язкове для заповнення!", trigger: "manual", placement: "top",
        animation: true});
    $edrpoE.popover({title: "Поле обов'язкове для заповнення!",
        content: "Формат запису: 99999999999 або АА 999999", trigger: "manual", placement: "top",
        animation: true});
    add_form.find('.suma').popover({title: "Допускаються тільки цифри і крапка!",
        content: "Формат запису: 999999999.99", trigger: "manual", placement: "top",
        animation: true});

    $('#vid_perevirkiS').on('change', function () {
        if ($(this).val() === '3') {
            $pidstava_pozaplanS.prop('disabled', false).multiselect('refresh').multiselect('enable');
        }
        else {
            $pidstava_pozaplanS.prop('disabled', 'disabled').multiselect('refresh').multiselect('disable');
        }
    });
    $pidstava_pozaplanS.multiselect({
        nonSelectedText: 'Виберіть підставу!',
        allSelectedText: 'Вибрано всі підстави',
        disabledText: 'Заблоковано!',
        delimiterText: '; ',
        selectAllName: 'select-all-name',
        inheritClass: true,
        buttonWidth: '100%'
    });
});