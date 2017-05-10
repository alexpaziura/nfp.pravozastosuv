<div class="modal container-fluid" id="modal_edit_n">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-5">
                        <h2 class="modal-title"><i class="fa fa-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Редагування запису</h2>
                    </div>
                    <div class="col-sm-6" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields_edit">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #e8e1ca;">
                <form id="edit-form-n" method="post" autocomplete="off">
                    <div id="modal-page-1e" class="modal-page-edit">
                        <p style="color: red">
                            <sup>
                                <i class="fa fa-asterisk" style="color: red"></i>
                            </sup> - Обов'язкове поле!</p>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nzpE">№ з/п <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="nzpE" type="text" class="form-control" id="nzpE" maxlength="11"
                                           data-toggle="popover" data-trigger="hover" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="short_name_fuE">Скорочена назва ФУ
                                        <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup>
                                    </label>
                                    <input name="short_name_fuE" type="text" class="form-control" id="short_name_fuE" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edrpoEE">ЄДРПОУ ФУ або ІНН або паспорт <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="edrpoEE" type="text" class="form-control" id="edrpoEE" maxlength="12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="type_foE">Тип суб'єкта нагляду <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <select name="type_foE" id="type_foE" class="form-control">
                                    <option value="" hidden></option>
                                    <?php foreach ($table_type_fu as $row): ?>
                                        <option value="<?= $row['id_type_fu'] ?>" visib="<?=$row['visible']?>"><?= $row['name_type_fu'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vid_perevirkiSE">Вид перевірки</label>
                                <select name="vid_perevirkiSE" id="vid_perevirkiSE" class="form-control">
                                    <?php foreach ($table_vid_perevirki as $row): ?>
                                        <option value="<?=$row['id_vid_perevirki'] ?>" visib="<?=$row['visible']?>"><?= $row['name_vid_perevirki'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pidstava_pozaplanSE">Підстава проведення позапланової перевірки</label>
                                <select name="pidstava_pozaplanSE[]" multiple="multiple" id="pidstava_pozaplanSE" class="form-control" disabled>
                                    <?php foreach ($table_p as $row): ?>
                                        <?php if ($row['visible']=='0') continue;?>
                                        <option value="<?=$row['id_pozaplan'] ?>"><?= $row['name_pozaplan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="modal-page-2e" class="modal-page-edit">

                    </div>
                    <div id="modal-page-3e" class="modal-page-edit">

                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #e8e1ca;">
                <nav class="text-center" style="margin-top: -20px; margin-bottom: -15px;">
                    <ul class="pagination">
                        <li id="page-1e"><a href="#" onclick="click1e()">1</a></li>
                        <li id="page-2e"><a href="#" onclick="click2e()">2</a></li>
                        <li id="page-3e"><a href="#" onclick="click3e()">3</a></li>
                        <!--<li><a href="#">4</a></li>-->
                    </ul>
                </nav>
                <button class="btn btn-warning center-block btn-labeled" name="edit_nag" type="submit" form="edit-form-n">
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
/*    $('#modal_edit_n').ready(function () {
        $('.modal-page-edit').addClass('hidden');
        $('#modal-page-1e').removeClass('hidden');
        $('#page-1e').addClass('active-warning');
    });*/
    function click1e() {
        $('.modal-page-edit').addClass('hidden');
        $('#modal-page-1e').removeClass('hidden');
        $('.pagination li').removeClass('active-warning');
        $('#page-1e').addClass('active-warning');
    }
    function click2e() {
        $('.modal-page-edit').addClass('hidden');
        $('#modal-page-2e').removeClass('hidden');
        $('.pagination li').removeClass('active-warning');
        $('#page-2e').addClass('active-warning');
    }
    function click3e() {
        $('.modal-page-edit').addClass('hidden');
        $('#modal-page-3e').removeClass('hidden');
        $('.pagination li').removeClass('active-warning');
        $('#page-3e').addClass('active-warning');
    }
</script>

