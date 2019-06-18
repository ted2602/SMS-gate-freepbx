<?php
/**
 * Created by Itach-soft.
 */


?>
<table id="statistic"
       data-url="ajax.php?module=smsgate&view=stat&command=getJSON&jdata=statistic"
       data-toolbar="#toolbar-main"
       data-cache="false"
       data-toggle="table"
       data-search="true"
       data-pagination="true"
       data-show-export="true"
       data-show-refresh="true"
       data-page-list="[50, 100, 300, 700, 1000, 'All']"
       class="table table-striped">
    <thead>
    <tr>
        <th data-field="datetime" data-sortable="true"><?php echo _("Date") ?></th>
        <th data-field="mesid" data-sortable="true"><?php echo _("Message id") ?></th>
        <th data-field="type" data-sortable="true"><?php echo _("Type") ?></th>
        <th data-field="gateid" data-sortable="true"><?php echo _("Gate ID") ?></th>
        <th data-field="portid" data-sortable="true"><?php echo _("Port") ?></th>
        <th data-field="number" data-sortable="true"><?php echo _("Number") ?></th>
        <th data-field="text" data-sortable="true"><?php echo _("Text") ?></th>
            <th data-field="status" data-sortable="true"><?php echo _("Status") ?></th>

    </tr>
    </thead>
</table>