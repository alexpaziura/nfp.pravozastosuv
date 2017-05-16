<?php
$state_add_1 = '';
$state_edit_1 = '';

?>
<div class="container-fluid" id="content-body" style="height: 90%">
    <!--<div class="toolbar">
<button id="button" class="btn btn-default">getSelectedRow</button></div>-->
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_add_1 == 'success' ? '' : 'hidden' ?>"
                 id="success_add_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Запис успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_add_1 == 'error' ? '' : 'hidden' ?>"
                 id="error_add_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Виникла помилка при додаванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_edit_1 == 'success' ? '' : 'hidden' ?>"
                 id="success_edit_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Запис успішно змінено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_edit_1 == 'error' ? '' : 'hidden' ?>"
                 id="error_edit_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Виникла помилка при редагуванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -20px;">
        <div class="container">
            <div id="toolbar_1" class="btn-toolbar">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-labeled add" id="addUser">
                        <span class="btn-label"><i class="fa fa-user-plus fa-lg"></i></span>Додати
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning btn-labeled edit" id="editUser">
                        <span class="btn-label"><i class="fa fa-pencil fa-lg"></i></span>Редагувати
                    </button>
                </div>
            </div>
            <div class="center-block">
                <table
                    data-toggle="table"
                    id="table_type_fu"
                    class="table table-striped table-bordered table-fixed-header table-condensed"
                    data-sort-name="id_user"
                    data-sort-order="asc"
                    data-toolbar="#toolbar_1"
                    data-search="true"
                    data-searchOnEnterKey="true"
                    data-click-to-select="true"
                    data-checkbox-header="false"
                    data-resizable="true"
                    style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>

                        <th data-field="state" data-checkbox="true" data-events="clickCheck"></th>
                        <th data-field="id_user" data-sortable="true" data-halign="center" data-align="center">
                            id
                        </th>
                        <th data-field="username" data-sortable="true" data-halign="center" data-align="center">
                            Тип суб'єкта нагляду
                        </th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php
                        $table_type_fu = get_dic('dic_type_fu');
                        foreach ($table_type_fu as $row):
                            if ($row['visible']=='0') continue;?>
                        <tr>
                            <td></td>
                            <td><?= $row['id_type_fu'] ?></td>
                            <td><?= $row['name_type_fu'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
