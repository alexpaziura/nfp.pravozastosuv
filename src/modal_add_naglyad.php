<?php

?>

<div class="modal container-fluid" id="modal-add-naglyad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-5">
                        <h2 class="modal-title"><i class="fa fa-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Додавання запису</h2>
                    </div>
                    <div class="col-sm-6" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #cae8ca;">
                <form id="add-form" method="post" autocomplete="off">
                    <div id="modal-page-1" class="modal-page">
                        <p style="color: red">
                            <sup>
                                <i class="fa fa-asterisk" style="color: red"></i>
                            </sup> - Обов'язкове поле!</p>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nzp">№ з/п <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="nzp" type="text" class="form-control" id="nzp" maxlength="11"
                                           data-toggle="popover" data-trigger="hover">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="short_name_fu">Скорочена назва ФУ
                                        <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup>
                                    </label>
                                    <input name="short_name_fu" type="text" class="form-control" id="short_name_fu" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edrpoE">ЄДРПОУ ФУ або ІНН або паспорт <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="edrpoE" type="text" class="form-control" id="edrpoE" maxlength="12">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="type_fo">Тип суб'єкта нагляду <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <select name="type_fo" id="type_fo" class="form-control">
                                        <option value="" hidden></option>
                                        <?php foreach ($table_type_fu as $row): ?>
                                            <?php if ($row['visible']=='0') continue;?>
                                            <option value="<?= $row['id_type_fu'] ?>"><?= $row['name_type_fu'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="vid_perevirkiS">Вид перевірки</label>
                                    <select name="vid_perevirkiS" id="vid_perevirkiS" class="form-control">
                                        <?php foreach ($table_vid_perevirki as $row): ?>
                                            <?php if ($row['visible']=='0') continue;?>
                                        <option value="<?=$row['id_vid_perevirki'] ?>" <?=$row['id_vid_perevirki']=='1'?'selected':'' ?>><?= $row['name_vid_perevirki'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pidstava_pozaplanS">Підстава проведення позапланової перевірки</label>
                                    <select name="pidstava_pozaplanS[]" multiple="multiple" id="pidstava_pozaplanS" class="form-control" disabled>
                                        <?php foreach ($table_p as $row): ?>
                                            <option value="<?=$row['id_pozaplan'] ?>"><?= $row['name_pozaplan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Термін проведення перевірки</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_start_perevirki">Дата початку</label>
                                        <div class="input-group date dp" data-provide="datepicker" id="d_start_perevirkiD">
                                            <input name="d_start_perevirki" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_end_perevirki">Дата закінчення</label>
                                        <div class="input-group date dp" data-provide="datepicker" id="d_end_perevirkiD">
                                            <input type="text" name="d_end_perevirki" data-mask="99.99.9999"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Період діяльності, що охоплюються перевіркою</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_start_dialnist">Дата початку</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_start_dialnistD">
                                            <input name="d_start_dialnist" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_end_dialnist">Дата закінчення</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_end_dialnistD">
                                            <input type="text" name="d_end_dialnist" data-mask="99.99.9999"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Наказ про здійснення заходу державного нагляду</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_nak_zah">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_nak_zahD">
                                            <input name="d_nak_zah" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_nak_zah">Номер</label>
                                        <input name="n_nak_zah" type="text" class="form-control" id="n_nak_zah"
                                               maxlength="45">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Направлення (Подання) про проведення перевірки</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_napr_proved">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_napr_provedD">
                                            <input name="d_napr_proved" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_napr_proved">Номер</label>
                                        <input name="n_napr_proved" type="text" class="form-control" id="n_napr_proved"
                                        maxlength="45">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="modal-page-2" class="modal-page">
                        <fieldset>
                            <legend>Інспекційна група</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ker_inspekt_group">П.І.Б. керівника інспекційної групи</label>
                                        <input name="ker_inspekt_group" type="text" class="form-control"
                                               id="ker_inspekt_group" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ch_inspekt_group">П.І.Б. членів інспекційної групи</label>
                                        <input name="ch_inspekt_group" type="text" class="form-control"
                                               id="ch_inspekt_group" maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Акт перевірки</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_akt_perevirki">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_akt_perevirkiD">
                                            <input name="d_akt_perevirki" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_akt_perevirki">Номер</label>
                                        <input name="n_akt_perevirki" type="text" class="form-control"
                                               id="n_akt_perevirki" maxlength="45">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Акт, складений відповідно до ЗУ №222-VIII</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_akt_zu">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_akt_zuD">
                                            <input name="d_akt_zu" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_akt_zu">Номер</label>
                                        <input name="n_akt_zu" type="text" class="form-control" id="n_akt_zu"
                                        maxlength="45">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="vid_akt_zu">Вид акту</label>
                                        <select name="vid_akt_zu" id="vid_akt_zu" class="form-control">
                                            <?php foreach ($table_akt_zu as $row): ?>
                                                <?php if ($row['visible']=='0') continue;?>
                                                <option value="<?=$row['id_akt_zu'] ?>" <?=$row['id_akt_zu']=='1'?'selected':'' ?>><?= $row['name_akt_zu'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Розпорядження про усунення порушень</legend>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_rozp_usun">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_rozp_usunD">
                                            <input name="d_rozp_usun" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="n_rozp_usun">Номер</label>
                                        <input name="n_rozp_usun" type="text" class="form-control" id="n_rozp_usun"
                                        maxlength="45">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="strok_usun_por">Строки усунення порушення</label>
                                        <input name="strok_usun_por" type="text" class="form-control"
                                               id="strok_usun_por" maxlength="45">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="b_usun_lic_umov" style="text-align: justify;">Застосоване розпорядження є розпорядження про усунення порушення ліц.умов</label>
                                        <select name="b_usun_lic_umov" id="b_usun_lic_umov" class="form-control">
                                            <option value="" selected></option>
                                            <option value="1">Так</option>
                                            <option value="2">Ні</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="info_vik_rozp">Інформація про виконання розпорядження</label>
                                        <select name="info_vik_rozp" id="info_vik_rozp" class="form-control">
                                            <?php foreach ($table_info_vik as $row): ?>
                                                <?php if ($row['visible']=='0') continue;?>
                                                <option value="<?=$row['id_info_vik'] ?>" <?=$row['id_info_vik']=='1'?'selected':'' ?>><?= $row['name_info_vik'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_dovidki_vik_rozp">Дата Довідки про виконання розпорядження</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_dovidki_vik_rozpD">
                                            <input name="d_dovidki_vik_rozp" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="modal-page-3" class="modal-page">
                        <div class="form-group">
                            <label for="dn_akt_nevik">Акт у разі невиконання вимог розпорядження</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="d_akt_nevikD">Дата</label>
                                    <div class="input-group date dp" data-provide="datepicker"
                                         id="d_akt_nevikD">
                                        <input name="d_akt_nevik" data-mask="99.99.9999" type="text"
                                               class="form-control" >
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="n_akt_nevik">Номер</label>
                                    <input name="n_akt_nevik" type="text" class="form-control" id="dn_akt_nevik"
                                           maxlength="34">
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Постанова про застосування штрафної санкції</legend>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="d_post_shtrafD">Дата постанови про штраф</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_post_shtrafD">
                                            <input name="d_post_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="n_post_shtraf">№ постанови про штраф</label>
                                        <input name="n_post_shtraf" type="text" class="form-control"
                                               id="n_post_shtraf" maxlength="45">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="suma_shtraf">Сума штрафу, грн</label>
                                        <input name="suma_shtraf" type="text" class="form-control"
                                               id="suma_shtraf" maxlength="12">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="strok_splat_shtrafD">Строк сплати штрафу</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="strok_splat_shtrafD">
                                            <input name="strok_splat_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="info_splat_shtrafD">Інформація про сплату штрафу (дата сплати по платіжному дорученню)</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="info_splat_shtrafD">
                                            <input name="info_splat_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="info_usun_por">Інформація про усунення порушення, за яке застосована штрафна санкція</label>
                                        <input name="info_usun_por" type="text" class="form-control"
                                               id="info_usun_por" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_dovidki_vik_postD">Дата Довідки про виконання постанови</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_dovidki_vik_postD">
                                            <input name="d_dovidki_vik_post" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dn_sluj_ur">Дата та номер службової записки до ЮрДеп щодо стягнення штрафної санкції у судовому порядку</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="d_sluj_urD">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_sluj_urD">
                                            <input name="d_sluj_ur" data-mask="99.99.9999" type="text"
                                                   class="form-control" >
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="n_sluj_ur">Номер</label>
                                        <input name="n_sluj_ur" type="text" class="form-control" id="n_sluj_ur"
                                               maxlength="34">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Процедури стягнення в судовому порядку</legend>
                            <div class="form-group">
                                <label for="sluj_perep_splat">Службова переписка щодо сплати судового збору (дата/номер
                                    службової записки) (фіксується подання на сплату - поверення з причинами про
                                    неможливість сплати - повторне подання, інше)</label>
                                <input name="sluj_perep_splat" type="text" class="form-control"
                                       id="sluj_perep_splat" maxlength="255">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dn_doc_splat">Дата/номер документу (платіжного доручення) про сплату судового збору</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="d_doc_splatD">Дата</label>
                                                <div class="input-group date dp" data-provide="datepicker"
                                                     id="d_doc_splatD">
                                                    <input name="d_doc_splat" data-mask="99.99.9999" type="text"
                                                           class="form-control" >
                                                    <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="n_doc_splat">Номер</label>
                                                <input name="n_doc_splat" type="text" class="form-control" id="n_doc_splat"
                                                       maxlength="34">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dn_sluj_nap_mat">Дата/номер службової записки щодо направлення матеріалів для подання позовної заяви</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="d_sluj_nap_matD">Дата</label>
                                                <div class="input-group date dp" data-provide="datepicker"
                                                     id="d_sluj_nap_matD">
                                                    <input name="d_sluj_nap_mat" data-mask="99.99.9999" type="text"
                                                           class="form-control" >
                                                    <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="n_sluj_nap_mat">Номер</label>
                                                <input name="n_sluj_nap_mat" type="text" class="form-control" id="n_sluj_nap_mat"
                                                       maxlength="34">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #cae8ca;">
                <nav class="text-center" style="margin-top: -20px; margin-bottom: -15px;">
                    <ul class="pagination">
                        <li id="page-1"><a href="#" onclick="click1()">1</a></li>
                        <li id="page-2"><a href="#" onclick="click2()">2</a></li>
                        <li id="page-3"><a href="#" onclick="click3()">3</a></li>
                        <!--<li><a href="#">4</a></li>-->
                    </ul>
                </nav>
                <button class="btn btn-success center-block btn-labeled" name="add_nag" type="submit" form="add-form">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.dp').datepicker({
        format: 'dd.mm.yyyy',
        language: 'uk',
        clearBtn: true,
        autoclose: true,
        assumeNearbyYear: true,
        daysOfWeekHighlighted: [0,6],
        immediateUpdates:true,
        todayHighlight: true
    });
/*    $('#modal-add-naglyad').ready(function () {
        $('.modal-page').addClass('hidden');
        $('#modal-page-1').removeClass('hidden');
        $('#page-1').addClass('active-success');
    });*/
    function click1() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-1').removeClass('hidden');
        $('.pagination li').removeClass('active-success');
        $('#page-1').addClass('active-success');
    }
    function click2() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-2').removeClass('hidden');
        $('.pagination li').removeClass('active-success');
        $('#page-2').addClass('active-success');
    }
    function click3() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-3').removeClass('hidden');
        $('.pagination li').removeClass('active-success');
        $('#page-3').addClass('active-success');
    }

    /*var formIsOk = true;
    $('#add-form').submit(function () {

        var $user_field  = $('#username');
        var $pass_field = $('#password');

        var username = $.trim($user_field.val());
        var password = $.trim($pass_field.val());
        var noError = true;
        if ((username === '')||(password === '')) {
            $('#wrong_field').removeClass('hidden');
            noError = false;
        }
        if (username === '') {
            $user_field.addClass('required_field');
        } else {
            $user_field.removeClass('required_field');
        }
        if (password === '') {
            $pass_field.addClass('required_field');
        } else {
            $pass_field.removeClass('required_field')
        }
        return noError;
    });
    $('#username').keyup(function() {
        var $user_field  = $('#username');
        var username = $.trim($user_field.val());
        var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
        if ( (username === '') || ( !regex.test( $(this).val() ) ) ) {
            $('#login').prop('disabled',true);
            $user_field.removeClass('accepted_field');
            $user_field.addClass('required_field');
        } else {
            $user_field.removeClass('required_field');
            $user_field.addClass('accepted_field');
            if ($('#password').val()!=='') {
                $('#login').prop('disabled',false);
            }
        }
    });
    $('#password').keyup(function() {
        var $pass_field = $('#password');
        var password = $.trim($pass_field.val());
        var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
        if ( (password === '') || ( !regex.test( $(this).val() ) ) ) {
            $('#login').prop('disabled',true);
            $pass_field.removeClass('accepted_field');
            $pass_field.addClass('required_field');
        } else {
            $pass_field.removeClass('required_field');
            $pass_field.addClass('accepted_field');
            if ($('#username').val()!=='') {
                $('#login').prop('disabled',false);
            }
        }
    });*/
</script>


