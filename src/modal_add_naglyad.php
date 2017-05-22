<?php

?>

<div class="modal container-fluid" id="modal-add-naglyad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-5">
                        <h2 class="modal-title"><i class="fa fa-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Додавання
                            запису</h2>
                    </div>
                    <div class="col-sm-6" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;">
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
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                        <input name="nzp" type="text" class="form-control" id="nzp" maxlength="11"
                                               data-toggle="popover" data-trigger="hover">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="short_name_fu">Скорочена назва ФУ
                                        <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-font fa-lg"></i>
                                            </span>
                                    <input name="short_name_fu" type="text" class="form-control" id="short_name_fu"
                                           maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edrpoE">ЄДРПОУ ФУ або ІНН або паспорт <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                    <input name="edrpoE" type="text" class="form-control" id="edrpoE" maxlength="12">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-top: 20px;">
                                    <label for="type_fo">Тип суб'єкта нагляду <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <select name="type_fo" id="type_fo" class="form-control">
                                        <option value="" hidden></option>
                                        <?php foreach ($table_type_fu as $row): ?>
                                            <?php if ($row['visible'] == '0') continue; ?>
                                            <option value="<?= $row['id_type_fu'] ?>"><?= $row['name_type_fu'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-top: 20px;">
                                    <label for="vid_perevirkiS">Вид перевірки</label>
                                    <select name="vid_perevirkiS" id="vid_perevirkiS" class="form-control">
                                        <?php foreach ($table_vid_perevirki as $row): ?>
                                            <?php if ($row['visible'] == '0') continue; ?>
                                            <option value="<?= $row['id_vid_perevirki'] ?>" <?= $row['id_vid_perevirki'] == 1 ? 'selected' : '' ?>><?= $row['name_vid_perevirki'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pidstava_pozaplanS">Підстава проведення позапланової перевірки</label>
                                    <select name="pidstava_pozaplanS[]" multiple="multiple" id="pidstava_pozaplanS"
                                            class="form-control" disabled>
                                        <?php foreach ($table_p as $row): ?>
                                            <option value="<?= $row['id_pozaplan'] ?>"><?= $row['name_pozaplan'] ?></option>
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
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_start_perevirkiD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_start_perevirki" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_end_perevirki">Дата закінчення</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_end_perevirkiD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input type="text" name="d_end_perevirki" data-mask="99.99.9999"
                                                   class="form-control">
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
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_start_dialnist" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="d_end_dialnist">Дата закінчення</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_end_dialnistD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input type="text" name="d_end_dialnist" data-mask="99.99.9999"
                                                   class="form-control">
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
                                             <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_nak_zah" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_nak_zah">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_nak_zah" type="text" class="form-control input-nomer"
                                               id="n_nak_zah"
                                               maxlength="45">
                                        </div>
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
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_napr_proved" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_napr_proved">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_napr_proved" type="text" class="form-control input-nomer"
                                               id="n_napr_proved"
                                               maxlength="45">
                                        </div>
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
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="ker_inspekt_group" type="text" class="form-control"
                                               id="ker_inspekt_group" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ch_inspekt_group">П.І.Б. членів інспекційної групи</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="ch_inspekt_group" type="text" class="form-control"
                                               id="ch_inspekt_group" maxlength="255">
                                        </div>
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
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_akt_perevirki" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_akt_perevirki">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_akt_perevirki" type="text" class="form-control input-nomer"
                                               id="n_akt_perevirki" maxlength="45">
                                        </div>
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
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_akt_zu" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_akt_zu">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                        <input name="n_akt_zu" type="text" class="form-control input-nomer"
                                               id="n_akt_zu"
                                               maxlength="45">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="vid_akt_zu">Вид акту</label>
                                        <select name="vid_akt_zu" id="vid_akt_zu" class="form-control">
                                            <?php foreach ($table_akt_zu as $row): ?>
                                                <?php if ($row['visible'] == '0') continue; ?>
                                                <option value="<?= $row['id_akt_zu'] ?>" <?= $row['id_akt_zu'] === 1 ? 'selected' : '' ?>><?= $row['name_akt_zu'] ?></option>
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
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_rozp_usun" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="n_rozp_usun">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                        <input name="n_rozp_usun" type="text" class="form-control input-nomer"
                                               id="n_rozp_usun"
                                               maxlength="45">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="strok_usun_por">Строки усунення порушення</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="strok_usun_por" type="text" class="form-control"
                                               id="strok_usun_por" maxlength="45">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="b_usun_lic_umov" style="text-align: justify;">Застосоване
                                            розпорядження є розпорядження про усунення порушення ліц.умов</label>
                                        <select name="b_usun_lic_umov" id="b_usun_lic_umov" class="form-control">
                                            <option value="" selected></option>
                                            <option value="1">Так</option>
                                            <option value="2">Ні</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" style="margin-top: 20px;">
                                        <label for="info_vik_rozp">Інформація про виконання розпорядження</label>
                                        <select name="info_vik_rozp" id="info_vik_rozp" class="form-control">
                                            <?php foreach ($table_info_vik as $row): ?>
                                                <?php if ($row['visible'] == '0') continue; ?>
                                                <option value="<?= $row['id_info_vik'] ?>" <?= $row['id_info_vik'] === 1 ? 'selected' : '' ?>><?= $row['name_info_vik'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" style="margin-top: 20px;">
                                        <label for="d_dovidki_vik_rozp">Дата Довідки про виконання розпорядження</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_dovidki_vik_rozpD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_dovidki_vik_rozp" data-mask="99.99.9999" type="text"
                                                   class="form-control">
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
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-lg"></i>
                                        </span>
                                        <input name="d_akt_nevik" data-mask="99.99.9999" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="n_akt_nevik">Номер</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                        </span>
                                        <input name="n_akt_nevik" type="text" class="form-control input-nomer"
                                           id="dn_akt_nevik"
                                           maxlength="34">
                                    </div>
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
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_post_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="n_post_shtraf">№ постанови про штраф</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_post_shtraf" type="text" class="form-control input-nomer"
                                               id="n_post_shtraf" maxlength="45">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="suma_shtraf">Сума штрафу, грн</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-money fa-lg"></i>
                                                <!--<img src="../img/glyphicons-38-coins.png">-->
                                            </span>
                                            <input name="suma_shtraf" type="text" class="form-control input-nomer suma"
                                               id="suma_shtraf" maxlength="12">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="strok_splat_shtrafD">Строк сплати штрафу</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="strok_splat_shtrafD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="strok_splat_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="info_splat_shtrafD">Інформація про сплату штрафу (дата сплати по
                                            платіжному дорученню)</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="info_splat_shtrafD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="info_splat_shtraf" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="info_usun_por">Інформація про усунення порушення, за яке застосована
                                            штрафна санкція</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="info_usun_por" type="text" class="form-control"
                                               id="info_usun_por" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="d_dovidki_vik_postD">Дата Довідки про виконання постанови</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_dovidki_vik_postD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_dovidki_vik_post" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dn_sluj_ur">Дата та номер службової записки до ЮрДеп щодо стягнення штрафної
                                    санкції у судовому порядку</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="d_sluj_urD">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="d_sluj_urD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_sluj_ur" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="n_sluj_ur">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_sluj_ur" type="text" class="form-control input-nomer"
                                               id="n_sluj_ur"
                                               maxlength="34">
                                        </div>
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
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-font fa-lg"></i>
                                    </span>
                                    <input name="sluj_perep_splat" type="text" class="form-control"
                                       id="sluj_perep_splat" maxlength="255">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dn_doc_splat">Дата/номер документу (платіжного доручення) про сплату
                                            судового збору</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="d_doc_splatD">Дата</label>
                                                <div class="input-group date dp" data-provide="datepicker"
                                                     id="d_doc_splatD">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-lg"></i>
                                                    </span>
                                                    <input name="d_doc_splat" data-mask="99.99.9999" type="text"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="n_doc_splat">Номер</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-hashtag fa-lg"></i>
                                                    </span>
                                                    <input name="n_doc_splat" type="text" class="form-control input-nomer"
                                                       id="n_doc_splat"
                                                       maxlength="34">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dn_sluj_nap_mat">Дата/номер службової записки щодо направлення
                                            матеріалів для подання позовної заяви</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="d_sluj_nap_matD">Дата</label>
                                                <div class="input-group date dp" data-provide="datepicker"
                                                     id="d_sluj_nap_matD">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-lg"></i>
                                                    </span>
                                                    <input name="d_sluj_nap_mat" data-mask="99.99.9999" type="text"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="n_sluj_nap_mat">Номер</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-hashtag fa-lg"></i>
                                                    </span>
                                                    <input name="n_sluj_nap_mat" type="text"
                                                       class="form-control input-nomer"
                                                       id="n_sluj_nap_mat"
                                                       maxlength="34">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="modal-page-4" class="modal-page">
                        <fieldset>
                            <legend>Інформація щодо розподілу судових витрат</legend>
                            <div class="form-group">
                                <label>Повернуто судовий збір за рішенням суду до бюджету</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="n_povern_sud_zbir">№ п/д</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-hashtag fa-lg"></i>
                                                </span>
                                                <input name="n_povern_sud_zbir" type="text" class="form-control input-nomer"
                                                   id="n_povern_sud_zbir"
                                                   maxlength="34">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="d_povern_sud_zbir">Дата</label>
                                            <div class="input-group date dp" data-provide="datepicker"
                                                 id="d_povern_sud_zbirD">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar fa-lg"></i>
                                                </span>
                                                <input name="d_povern_sud_zbir" data-mask="99.99.9999" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="s_povern_sud_zbir">Сума, грн</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-money fa-lg"></i>
                                                </span>
                                                <input name="s_povern_sud_zbir" type="text" class="form-control input-nomer
                                                    suma"
                                                   id="s_povern_sud_zbir" maxlength="12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group" style="margin-top: -20px;">
                            <label for="dn_list_dobro_splat">Дата/номер листа до суб'єкту нагляду про добровільнк сплату
                                штрафної санкції (судового збору) за рішенням суду</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="d_list_dobro_splatD">Дата</label>
                                    <div class="input-group date dp" data-provide="datepicker"
                                         id="d_list_dobro_splatD">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar fa-lg"></i>
                                        </span>
                                        <input name="d_list_dobro_splat" data-mask="99.99.9999" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="n_list_dobro_splat">Номер</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-hashtag fa-lg"></i>
                                        </span>
                                        <input name="n_list_dobro_splat" type="text" class="form-control input-nomer"
                                           id="n_list_dobro_splat"
                                           maxlength="33">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Процедури примусового стягнення за рішенням суду</legend>
                            <div class="form-group">
                                <label>Штрафна санкція сплачена добровільно за рішенням суду</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="n_shtraf_splach_dobro">№ п/д</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-hashtag fa-lg"></i>
                                                </span>
                                                <input name="n_shtraf_splach_dobro" type="text"
                                                   class="form-control input-nomer"
                                                   id="n_shtraf_splach_dobro"
                                                   maxlength="34">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="d_shtraf_splach_dobroD">Дата</label>
                                            <div class="input-group date dp" data-provide="datepicker"
                                                 id="d_shtraf_splach_dobroD">
                                                <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-lg"></i>
                                                </span>
                                                <input name="d_shtraf_splach_dobro" data-mask="99.99.9999" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="s_shtraf_splach_dobro">Сума, грн</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-money fa-lg"></i>
                                                </span>
                                                <input name="s_shtraf_splach_dobro" type="text"
                                                   class="form-control input-nomer suma"
                                                   id="s_shtraf_splach_dobro" maxlength="12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Дата/номер службової записки щодо необхідності примусового
                                    виконання рішення суду</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="d_sluj_primus">Дата</label>
                                        <div class="input-group date dp" data-provide="datepicker"
                                             id="dn_sluj_primusD">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar fa-lg"></i>
                                            </span>
                                            <input name="d_sluj_primus" data-mask="99.99.9999" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="n_sluj_primus">Номер</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-hashtag fa-lg"></i>
                                            </span>
                                            <input name="n_sluj_primus" type="text" class="form-control input-nomer"
                                               id="n_sluj_primus"
                                               maxlength="34">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Додатково зібрана інформація</legend>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_zap_derjrei">
                                            Направлено запит до держреєстра на встановлення
                                            місцезнаходження</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_zap_derjrei" type="text" class="form-control"
                                               id="napr_zap_derjrei"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_zap_dfs">Направлено запит до органів ДФС щодо здійснення
                                            фінансово-господарської діяльності та пов'язаних осіб</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_zap_dfs" type="text" class="form-control" id="napr_zap_dfs"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="modal-page-5" class="modal-page">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_zai_police">
                                            Направлено запит до органів національної поліції про ухилення від
                                            виконання рішення суду</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_zai_police" type="text" class="form-control"
                                               id="napr_zai_police"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_info_bank">Направлено інформацію до банківських установ
                                            про наявність несплачених штрафних санкцій</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_info_bank" type="text" class="form-control"
                                               id="napr_info_bank"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_info_zasn">
                                            Направлено інформацію до засновників та посадових осіб про наявність
                                            несплаченої штрафної санкції</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_info_zasn" type="text" class="form-control"
                                               id="napr_info_zasn"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_info_prokuror">Направлено інформацію до органів прокуратури про
                                            наявність несплаченої штрафної санкції</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_info_prokuror" type="text" class="form-control"
                                               id="napr_info_prokuror"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="napr_info_oms">
                                            Направлено інформацію до органів місцевого самоврядування про наявність
                                            несплаченої штрафної санкції</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_info_oms" type="text" class="form-control" id="napr_info_oms"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" style="margin-top: 20px;">
                                        <label for="napr_info_dfs">Направлено інформацію до органів ДФС про наявність
                                            несплаченої штрафної санкції</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                            <input name="napr_info_dfs" type="text" class="form-control" id="napr_info_dfs"
                                               maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #d9d9d9;">
                <nav class="text-center" style="margin-top: -20px; margin-bottom: -15px;">
                    <ul class="pagination">
                        <li id="page-1"><a href="#" onclick="click1()">1</a></li>
                        <li id="page-2"><a href="#" onclick="click2()">2</a></li>
                        <li id="page-3"><a href="#" onclick="click3()">3</a></li>
                        <li id="page-4"><a href="#" onclick="click4()">4</a></li>
                        <li id="page-5"><a href="#" onclick="click5()">5</a></li>
                        <!--<li><a href="#">4</a></li>-->
                    </ul>
                </nav>
                <button class="btn btn-primary center-block btn-labeled" name="add_nag" type="submit" form="add-form">
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
        daysOfWeekHighlighted: [0, 6],
        immediateUpdates: true,
        todayHighlight: true
    });
    function click1() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-1').removeClass('hidden');
        $('.pagination li').removeClass('active-primary');
        $('#page-1').addClass('active-primary');
    }
    function click2() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-2').removeClass('hidden');
        $('.pagination li').removeClass('active-primary');
        $('#page-2').addClass('active-primary');
    }
    function click3() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-3').removeClass('hidden');
        $('.pagination li').removeClass('active-primary');
        $('#page-3').addClass('active-primary');
    }
    function click4() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-4').removeClass('hidden');
        $('.pagination li').removeClass('active-primary');
        $('#page-4').addClass('active-primary');
    }
    function click5() {
        $('.modal-page').addClass('hidden');
        $('#modal-page-5').removeClass('hidden');
        $('.pagination li').removeClass('active-primary');
        $('#page-5').addClass('active-primary');
    }
</script>


