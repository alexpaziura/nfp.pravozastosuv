<?php
$state_add = '';
$state_edit = '';
if(isset($_POST['add_user'])){
    if (add_user()) {
        $state_add = 'success';
    } else {
        $state_add = 'error';
    }
}
if(isset($_POST['edit_user'])){
    if (add_user()) {
        $state_edit = 'success';
    } else {
        $state_edit = 'error';
    }
}

?>
<div class="container-fluid" id="content-body" style="height: 90%">
    <!--<div class="toolbar">
<button id="button" class="btn btn-default">getSelectedRow</button></div>-->
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_add == 'success' ? '' : 'hidden' ?>"
                 id="success_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Запис успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_add == 'error' ? '' : 'hidden' ?>"
                 id="error_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Виникла помилка при додаванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_edit == 'success' ? '' : 'hidden' ?>"
                 id="success_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Запис успішно змінено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_edit == 'error' ? '' : 'hidden' ?>"
                 id="error_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Виникла помилка при редагуванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -20px;">
        <div class="container">
            <div id="toolbar" class="btn-toolbar">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-labeled add" id="addUser">
                        <span class="btn-label"><i class="fa fa-user-plus fa-lg"></i></span>Додати користувача
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning btn-labeled edit" id="editUser">
                        <span class="btn-label"><i class="fa fa-pencil fa-lg"></i></span>Редагувати користувача
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-labeled" id="deleteUser">
                        <span class="btn-label"><i class="fa fa-user-times fa-lg"></i></span>Видалити користувача
                    </button>
                </div>
            </div>
            <div class="">
                <table
                    data-toggle="table"
                    id="table_user"
                    class="table table-striped table-bordered table-fixed-header table-condensed"
                    data-sort-name="id_user"
                    data-sort-order="asc"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-searchOnEnterKey="true"
                    data-click-to-select="true"
                    data-checkbox-header="false"
                    data-resizable="true"
                    style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>

                        <th data-field="state" data-checkbox="true" data-events="clickCheck"></th>
                        <th data-field="id_user" data-sortable="true" data-halign="center" data-align="center"
                        class="hidden">
                            id
                        </th>
                        <th data-field="username" data-sortable="true" data-halign="center" data-align="center">
                            Ім'я користувача
                        </th>
                        <th data-field="full_name" data-sortable="true" data-halign="center" data-align="center">
                            ПІБ
                        </th>
                        <th data-field="memberof" data-sortable="true" data-halign="center" data-align="center">
                            Член групи
                        </th>
                        <th data-field="active_user" data-sortable="true"  data-halign="center" data-align="center">
                            Статус
                        </th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php $table_users = get_users();
                    foreach ($table_users as $row): ?>
                        <tr>
                            <td></td>
                            <td class="hidden"><?= $row['id_user'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['memberof'] ?></td>
                            <td><?= $row['active_user']=='1'?
                                    "<i class='fa fa-check' style='color:#5cb85c;'></i>"
                                    :"<i class='fa fa-ban' style='color: #d9534f;'></i>"?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
echo '<pre>';
var_dump($_POST);
echo '</pre>';
echo '<pre>';
mb_list_encodings();
echo '</pre><br>';
echo mb_detect_encoding('ДеРЗІТ');

?>
<div class="modal fade container-fluid" id="modal_add_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title"><i class="fa fa-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Додавання користувача</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #e8e1ca;"> <!--cae8ca-->
                <form id="add-user" method="post" autocomplete="off">
                        <p style="color: red">
                            <sup>
                                <i class="fa fa-asterisk" style="color: red"></i>
                            </sup> - Обов'язкове поле!</p>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="username">Ім'я користувача <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="username" type="text" class="form-control" id="username" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="username">Пароль
                                        <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup>
                                    </label>
                                    <input name="password" type="password" class="form-control" id="password" maxlength="255">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="pib">ПІБ <sup>
                                            <i class="fa fa-asterisk" style="color: red"></i>
                                        </sup></label>
                                    <input name="pib" type="text" class="form-control" id="pib" maxlength="255">
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="memberof">Член групи <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <select name="memberof" id="memberof" class="form-control">
                                    <option value="" hidden></option>
                                    <option value="UR">ЮР</option>
                                    <option value="SK">СК</option>
                                    <option value="FK">ФК</option>
                                    <option value="KS">КС</option>
                                    <option value="NPZ">НПЗ</option>
                                    <option value="RRFP">РРФП</option>
                                    <option value="DeRZIT">ДеРЗІТ</option>
                                    <option value="All_read">Всі на читання</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="active">Активний</label>
                                    <label class="btn btn-lg btn-success tog btn-group-justified" id="ltoggle"
                                           style="padding-top: 4px; padding-bottom: 4px">
                                        <input type="checkbox" name="active" autocomplete="off"
                                               class="hidden" checked="checked" id="activeUser">
                                        <div id="title"><i class="fa fa-check"></i> Так</div>
                                    </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #cae8ca;">
                <button class="btn btn-success center-block btn-labeled" name="add_user" type="submit" form="add-user">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade container-fluid" id="modal_edit_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title"><i class="fa fa-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Редагування користувача</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields_edit">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #e8e1ca;">
                <form id="edit-user" method="post" autocomplete="off">
                    <p style="color: red">
                        <sup>
                            <i class="fa fa-asterisk" style="color: red"></i>
                        </sup> - Обов'язкове поле!</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="username_edit">Ім'я користувача <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <input name="username_edit" type="text" class="form-control" id="username_edit" maxlength="255">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="password_edit">Пароль
                                    <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup>
                                </label>
                                <input name="password_edit" type="password" class="form-control" id="password_edit" maxlength="255">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pib_edit">ПІБ <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <input name="pib_edit" type="text" class="form-control" id="pib_edit" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="memberof_edit">Член групи <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <select name="memberof_edit" id="memberof_edit" class="form-control">
                                    <option value="" hidden></option>
                                    <option value="UR">ЮР</option>
                                    <option value="SK">СК</option>
                                    <option value="FK">ФК</option>
                                    <option value="KS">КС</option>
                                    <option value="NPZ">НПЗ</option>
                                    <option value="RRFP">РРФП</option>
                                    <option value="DeRZIT">ДеРЗІТ</option>
                                    <option value="All_read">Всі на читання</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="active">Активний</label>
                                <label class="btn btn-lg btn-success tog btn-group-justified" id="ltoggle_edit"
                                       style="padding-top: 4px; padding-bottom: 4px">
                                    <input type="checkbox" name="active_edit" autocomplete="off"
                                           class="hidden" checked="checked" id="activeUser_edit">
                                    <div id="title_edit"><i class="fa fa-check"></i> Так</div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" name="id_user" id="id_user" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer" style="background-color: #e8e1ca;">
                <button class="btn btn-success center-block btn-labeled" name="edit_user" type="submit" form="edit-user">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>