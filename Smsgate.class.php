<?php
/**
 * Created by Itach-soft.
 */

namespace FreePBX\modules;
class Smsgate implements \BMO

{

    //функции инициализации класса модуля для Freepbx
    public function __construct($freepbx = null)
    {
        if ($freepbx == null) {
            throw new Exception("Not given a FreePBX Object");
        }
        $this->FreePBX = $freepbx;
        $this->db = $freepbx->Database;
    }

    public function install()
    {
    }

    public function uninstall()
    {
    }

    public function backup()
    {
    }

    public function restore($backup)
    {
    }

    //конец функции инициализации класса модуля для Freepbx
    public static function myConfigPageInits()
    {
        return array();
    }


    public function doConfigPageInit($page)
    {

        isset($_REQUEST['action']) ? $action = $_REQUEST['action'] : $action = '';
        isset($_REQUEST['itemid']) ? $itemid = $_REQUEST['itemid'] : $itemid = '';
        switch ($action) {
            case "settings":
                $res = editsettings($_REQUEST);
                needreload();
                break;


        }
    }


//функция для построения boostrap таблиц
    public function ajaxHandler()
    {
        switch ($_REQUEST['command']) {
            case 'getJSON':
                switch ($_REQUEST['jdata']) {

                   case 'statistic':
                        return array_values($this->statistic());
                        break;
                    default:
                        return false;
                        break;
                }
                break;

            default:
                return false;
                break;
        }


    }

    public function ajaxRequest($req, &$setting)
    {
        switch ($req) {
            case 'getJSON':
                return true;
                break;
            default:
                return false;
                break;
        }
    }
    public function statistic(){
        $query = $this->db->prepare("
			SELECT *
            FROM  `smsgate_stat`
            ORDER BY  `smsgate_stat`.`date` DESC
			");
        $row=$query->execute();
        $i=0;
        //$row = $query->fetchall(\PDO::FETCH_BOTH);
        while ($row = $query->fetch(\PDO::FETCH_BOTH)) {
            $res[$i]["datetime"] = $row["date"];
            $res[$i]["mesid"] = $row["mesid"];
            $res[$i]["type"] = $row["type"];
            $res[$i]["gateid"] = $row["gateid"];
            $res[$i]["portid"] = $row["portid"];
            $res[$i]["number"] = $row["number"];
            $res[$i]["text"] = $row["text"];
            $res[$i]["status"] = $row["status"];

            $i++;
        }
        if (!isset($res)) $res=array();
        return ($res);
    }

}
