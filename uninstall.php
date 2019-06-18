<?php
/**
 * Created by Itach-soft.
 */

global $db;

out("Dropping all relevant tables");
$sql = "
DROP TABLE `smsgate_settings`;
DROP TABLE `smsgate_stat`;
";
$check = sql($sql);
if (DB::IsError($check)) {
    echo ( "Can not delete table: " . $check->getMessage() .  "\n");
}