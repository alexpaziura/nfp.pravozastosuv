<?php
$for_date_change = 'd.m.Y H:i:s';
?>
<div class="container-fluid" id="content-body" style="margin-top:15px; height: 90%">
    <!--<div class="toolbar">
<button id="button" class="btn btn-default">getSelectedRow</button></div>-->
    <div class="row" style="margin-top: -20px;">
        <div class="container">
            <div class="">
                <table
                    data-toggle="table"
                    id="table_user"
                    class="table table-striped table-bordered table-fixed-header table-condensed"
                    data-sort-name="time_exec"
                    data-sort-order="desc"
                    data-height="850"
                    data-click-to-select="true"
                    data-checkbox-header="false"
                    data-resizable="true"
                    style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>
                        <th data-field="id_log" data-sortable="true" data-halign="center" data-align="center">
                            ID
                        </th>
                        <th data-field="time_exec" data-sortable="true" data-halign="center" data-align="center">
                            Час
                        </th>
                        <th data-field="type" data-sortable="true" data-halign="center" data-align="center">
                            Тип
                        </th>
                        <th data-field="username" data-sortable="true" data-halign="center" data-align="center">
                            Ім'я користувача
                        </th>
                        <th data-field="query" data-sortable="true" data-halign="center" data-align="center">
                            Запит
                        </th>
                        <th data-field="status" data-sortable="true"  data-halign="center" data-align="center">
                            Статус
                        </th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php $table_logs = get_logs();
                    foreach ($table_logs as $row): ?>
                        <tr>
                            <td><?= $row['id_log'] ?></td>
                            <td><?= date($for_date_change, $row['time_exec']) ?></td>
                            <td><?= $row['type'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['query'] ?></td>
                            <td><?= $row['status']=='1'?
                                    "<i class='fa fa-check' style='color:#5cb85c;'></i>"
                                    :"<i class='fa fa-times' style='color: #d9534f;'></i>"?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
