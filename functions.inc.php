<?php
/**
 * Created by Itach-soft.
 */

function smsgate_editsettings($request)
{
    extract($request);
    global $db;
/*    $query = $db->prepare("
			UPDATE smsgate_settings SET `gateid` = :gateid, `gateip`=:gateip, `gatebrand`=:gatebrand,
			  `gateapiport`=:gateapiport,  `gateusername`=:gateusername,
			   `gatepassword`=:gatepassword, `gateports`=:gateports WHERE `gateid` = :gateid");
    $query->bindParam(':gateip', $gateip);
    $query->bindParam(':gatebrand', $gatebrand);
    $query->bindParam(':gateapiport', $gateapiport);
    $query->bindParam(':gateusername', $gateusername);
    $query->bindParam(':gatepassword', $gatepassword);
    $query->bindParam(':gateports', $gateports);
    $query->bindParam(':gateid', $gateid);
    $query->execute();*/

    $sql = 'UPDATE smsgate_settings SET `gateid` = "'.$gateid.'", `gateip`="'.$gateip.'", `gatebrand`="'.$gatebrand.'",
			  `gateapiport`="'.$gateapiport.'",  `gateusername`="'.$gateusername.'",
			   `gatepassword`="'.$gatepassword.'", `gateports`="'.$gateports.'" WHERE `gateid` = "'.$gateid.'"';
    $query=sql($sql);
    if (DB::IsError($query)) {
        die_freepbx( "Can not create table: " . $query->getMessage() .  "\n");
    }
    return ($sql);
}

function smsgate_addsettings($request)
{
    extract($request);
    global $db;
    $query = $db->prepare("
    INSERT INTO `smsgate_settings`(`gateid`, `gateip`, `gateapiport`, `gateusername`, `gatepassword`, `gateports`, `gatebrand`)
                  VALUES        (:gateid, :gateip, :gateapiport, :gateusername, :gatepassword, :gateports, :gatebrand)
			   ");
    $query->bindParam(':gateip', $gateip);
    $query->bindParam(':gatebrand', $gatebrand);
    $query->bindParam(':gateapiport', $gateapiport);
    $query->bindParam(':gateusername', $gateusername);
    $query->bindParam(':gatepassword', $gatepassword);
    $query->bindParam(':gateports', $gateports);
    $query->bindParam(':gateid', $gateid);
    $query->execute();
}

function smsgate_getsettings($gateid = NULL)
{
    global $db;
    $sql = 'SELECT * FROM `smsgate_settings` WHERE `gateid` = :gateid;';
    $query = $db->prepare($sql);
    $query->bindParam(':gateid', $gateid);
    $query->execute();
    $results = $query->fetchall(\PDO::FETCH_ASSOC);
    if ($gateid == NULL) {
        $sql = 'SELECT * FROM `smsgate_settings`';
        $query = $db->prepare($sql);
        $query->execute();
        $results = $query->fetchall(\PDO::FETCH_ASSOC);
        if (is_array($results)) {
            return $results;
        }
    } else {
        $sql = 'SELECT * FROM `smsgate_settings` WHERE `gateid` = :gateid;';
        $query = $db->prepare($sql);
        $query->bindParam(':gateid', $gateid);
        $query->execute();
        $results = $query->fetchall(\PDO::FETCH_ASSOC);
        if (is_array($results)) {
            return $results[0];
        }
    }
    return array();
}

function smsgate_sendsms($gateid,$gateport,$number,$smstext)
{

    global $db;
    $smsgatesettings=smsgate_getsettings($gateid);
    $gateip=$smsgatesettings['gateip'];
    $gateapiport=$smsgatesettings['gateapiport'];
    $gateusername=$smsgatesettings['gateusername'];
    $gatepassword=$smsgatesettings['gatepassword'];
    $time=time();
    $datetime=date("Y-m-d H:i:s", $time);
    $rand=rand(1111,9999);
    $mesid=$time;
    $status='ok';
    $type='sms';
    //послать sms
    //curl -u adm   in:admin  '{"text":"Hello,#param#.","port":[2],"param":[{"number":"80297073990","text_param":["John"],"user_id":1}]};' http://192.168.85.53:80/api/send_sms
    $res=exec('curl -u '.$gateusername.':'.$gatepassword.' -H "Content-Type: application/json" -X POST -d \'{"text":"'.$smstext.'#param#",    "port":['.$gateport.'],
        "param":[{"number":"'.$number.'","user_id":'.$mesid.'}]};\' http://'.$gateip.':'.$gateapiport.'/api/send_sms');
    //Занести в базу
    sleep(10);
    $res=exec('curl -u '.$gateusername.':'.$gatepassword.' -H "Content-Type: application/json" -X POST -d \'{"user_id":['.$mesid.']}\' http://'.$gateip.':'.$gateapiport.'/api/query_sms_result');
    $res=json_decode($res,true);
    //var_export($res);
    $status=$res['result'][0]['status'];

    $query = $db->prepare("
    INSERT INTO `smsgate_stat`(`date`, `gateid`, `type`, `mesid`, `portid`, `number`, `text`, `status`)
                  VALUES (       :datetime, :gateid, :mestype, :mesid, :portid, :clnumber, :text, :status)
			   ");
    $query->bindParam(':mesid', $mesid, PDO::PARAM_STR);
    $query->bindParam(':portid', $gateport, PDO::PARAM_STR);
    $query->bindParam(':clnumber', $number, PDO::PARAM_STR);
    $query->bindParam(':datetime', $datetime, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':gateid', $gateid, PDO::PARAM_STR);
    $query->bindParam(':text', $smstext, PDO::PARAM_STR);
    $query->bindParam(':mestype', $type, PDO::PARAM_STR);
    $query->execute();
    return ($status);
}

function smsgate_sendussd($gateid,$gateport,$number)
{

    global $db;
    $smsgatesettings=smsgate_getsettings($gateid);
    $gateip=$smsgatesettings['gateip'];
    $gateapiport=$smsgatesettings['gateapiport'];
    $gateusername=$smsgatesettings['gateusername'];
    $gatepassword=$smsgatesettings['gatepassword'];
    $time=time();
    $datetime=date("Y-m-d H:i:s", $time);
    $rand=rand(1111,9999);
    $mesid=substr($time,0,-4).$rand;
    $status='1р.30kopeek.';
    $type='ussd';
    //послать USSD
    $system_res=exec('curl -u '.$gateusername.':'.$gatepassword.' -H "Content-Type: application/json" -X POST -d \'{"command":"send","text":"'.$number.'","port":['.$gateport.']};\' http://'.$gateip.':'.$gateapiport.'/api/send_ussd');

    //узнать результат с паузой n сек
    sleep(10);
    $res=exec('curl -u '.$gateusername.':'.$gatepassword.'  -X POST -d \'port='.$gateport.'\' http://'.$gateip.':'.$gateapiport.'/api/query_ussd_reply');
    //Занести в базу
    $res=json_decode($res, true);
    $status=$res['reply'][0]['text'];
    //var_export($res['reply'][0]['text']);
    $query = $db->prepare("
    INSERT INTO `smsgate_stat`(`date`, `gateid`, `type`, `mesid`, `portid`, `number`, `status`)
                  VALUES (       :datetime, :gateid, :mestype, :mesid, :portid, :clnumber, :status)
			   ");
    $query->bindParam(':mesid', $mesid, PDO::PARAM_STR);
    $query->bindParam(':portid', $gateport, PDO::PARAM_STR);
    $query->bindParam(':clnumber', $number, PDO::PARAM_STR);
    $query->bindParam(':datetime', $datetime, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':gateid', $gateid, PDO::PARAM_STR);
    $query->bindParam(':mestype', $type, PDO::PARAM_STR);
    $query->execute();



    return ($status);
}


function smsgate_ressms($gateid,$gateport)
{

    global $db;
    $smsgatesettings=smsgate_getsettings($gateid);
    $gateip=$smsgatesettings['gateip'];
    $gateapiport=$smsgatesettings['gateapiport'];
    $gateusername=$smsgatesettings['gateusername'];
    $gatepassword=$smsgatesettings['gatepassword'];
    $time=time();
    $datetime=date("Y-m-d H:i:s", $time);
    $rand=rand(0001,9999);
    $mesid=substr($time,0,-4).$rand;
    $status='';
    $type='Recieved';
    //послать Запрос

    $res=exec('curl -u '.$gateusername.':'.$gatepassword.'  -X POST -d \'flag=unread&port='.$gateport.'\' http://'.$gateip.':'.$gateapiport.'/api/query_incoming_sms');
    //Занести в базу

    $status=$res;
    $res=json_decode($res,true);
    $incomsms=$res['sms'];
    //var_export($res['sms']);
    $i=0;
    foreach ($incomsms as $sms)
    {
        //echo "<br>";
        //var_export($sms);
        //echo "<br>";
        $status='incoming';
        $time=time();
        $datetime=date("Y-m-d H:i:s", $time);
        $rand=rand(0001,9999);
        $mesid=substr($time,0,-4).$rand;
        $number=$sms['number'];
        $gateport=$sms['port'];
        $timesms=$sms['timestamp'];
        $text=$timesms.' '.$sms['text'];

        $query = $db->prepare("
    INSERT INTO `smsgate_stat`(`date`, `gateid`, `type`, `mesid`, `portid`, `number`, `text`, `status`)
                  VALUES (       :datetime, :gateid, :mestype, :mesid, :portid, :clnumber, :text, :status)
			   ");
        $query->bindParam(':mesid', $mesid, PDO::PARAM_STR);
        $query->bindParam(':portid', $gateport, PDO::PARAM_STR);
        $query->bindParam(':clnumber', $number, PDO::PARAM_STR);
        $query->bindParam(':datetime', $datetime, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':gateid', $gateid, PDO::PARAM_STR);
        $query->bindParam(':text', $text, PDO::PARAM_STR);
        $query->bindParam(':mestype', $type, PDO::PARAM_STR);
        $query->execute();
        $incomingsms[$i]="<br>"._("Time sms:").$timesms.'. '._("Number:").$number.'. '._("Text sms:").$sms['text'];
        $i++;
    }

    return ($incomingsms);
}