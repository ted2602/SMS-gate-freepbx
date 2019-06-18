<?php
/**
 * Created by Itach-soft.
 */

if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
global $db;
global $amp_conf;

$heading = _("SMS Gate Module");
$request = $_REQUEST;
isset($request['action'])?$action = $request['action']:$action='';

//получаем настройки из базы
//$dev=core_users_get($vars["extension"]);
//var_export($dev);
?>
<h2><?php echo $heading;?></h2>

<div class = "display full-border">
    <div class="container-fluid">
        <a href="?display=smsgate" class="btn btn-default"></i>&nbsp;<?php echo(_("Send SMS")); ?></a>
        <a href="?display=smsgate&amp;view=ressms" class="btn btn-default"></i>&nbsp;<?php echo(_("Recieve SMS")); ?></a>
        <a href="?display=smsgate&amp;view=sendussd" class="btn btn-default"></i>&nbsp;<?php echo(_("Send USSD")); ?></a>
        <a href="?display=smsgate&amp;view=settings" class="btn btn-default"></i>&nbsp;<?php echo(_("Smsgate Settings")); ?></a>
        <a href="?display=smsgate&amp;view=stat" class="btn btn-default"></i>&nbsp;<?php echo(_("Smsgate Statistics")); ?></a>
        <br>



        <?php
        if (isset($_REQUEST['view']))
        {
            switch ($request['view']) {
                case 'settings':
                    require(dirname(__FILE__).'/view/settings.php');
                    break;
                case 'ressms':
                    require(dirname(__FILE__) . '/view/ressms.php');
                    break;
                case 'sendussd':
                    require(dirname(__FILE__) . '/view/sendussd.php');
                    break;
                case 'stat':
                    require(dirname(__FILE__) . '/view/stat.php');
                    break;
                case 'test':
                    require(dirname(__FILE__) . '/test.php');
                    break;
                case 'sendsms':
                    require(dirname(__FILE__) . '/view/sendsms.php');
                    break;
                default:
                    break;
            }
        }
        else
        {
            require(dirname(__FILE__).'/view/sendsms.php');


        }



        echo("<h6 align='center'>"._("SMSGate module for FreePBX. <a target=\"_blank\" href=http://www.itach.by>Itach-soft LLC</a>. Minsk ".date(Y))."</h6>");

        ?>

    </div>
</div>

<?php

//КОНЕЦ СКРИПТА
unset($data);
?>
