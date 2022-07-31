<?php
class Sqlitesvc{
    public $db;
    public $dbfilename;

    function __construct($dbfilename)
    {
        $this->dbfilename = $dbfilename;
    }

    function dbconnect(){
        $this->db = new SQLite3($this->dbfilename);

        if(!$this->db) {
            return $this->db->lastErrorMsg();
        } else {
            return true;
        }
    }

    function dbinsert($tablename,$arrdata){
        $sql = "INSERT INTO ".$tablename;
        $arrcolname = array();
        $arrcolval = array();
        foreach ($arrdata as $key => $value) {
            $arrcolname[] = $key;
            $arrcolval[] = $value;
        }
        for ($idx=0; $idx < count($arrcolname); $idx++) { 
            if($idx == 0){
                $sql = $sql." (".$arrcolname[$idx];
            }else if($idx == count($arrcolname)-1){
                $sql = $sql.",".$arrcolname[$idx].")";
            }else{
                $sql = $sql.",".$arrcolname[$idx];
            }
        }
        for ($idx=0; $idx < count($arrcolval); $idx++) {
            if($idx == 0){
                $sql = $sql." VALUES (".$this->numorstring($arrcolval[$idx]);
            }else if($idx == count($arrcolval)-1){
                $sql = $sql.",".$this->numorstring($arrcolval[$idx]).");";
            }else{
                $sql = $sql.",".$this->numorstring($arrcolval[$idx]);
            }
        }
        // $this->debugrint($sql);
        $conn = $this->dbconnect();
        if($conn == true){
            $ret = $this->db->exec($sql);
            if(!$ret) {
                return $this->db->lastErrorMsg();
            } else {
                return true;                
            }
        }else{
            return $conn;
        }
        $this->dbclose();
    }

    function dbselect($tablename,$arrcolname,$where,$ordercolname,$ordermode){
        $sql = "SELECT ";
        if($arrcolname != null){
            for ($idx=0; $idx < count($arrcolname); $idx++) { 
                if($idx == 0){
                    $sql = $sql.$arrcolname[$idx];
                }else{
                    $sql = $sql.",".$arrcolname[$idx];
                }
            }
        }else{
            $sql = $sql."*";
        }
        $sql = $sql." FROM ".$tablename;
        if($where != null){
            $sql = $sql." WHERE ".$where." ";
        }
        if($ordercolname != null){
            $sql = $sql." ORDER BY ".$ordercolname;
            if($ordermode == null){
                $sql = $sql." ASC;";
            }else{
                $sql = $sql." ".$ordermode.";";
            }
        }
        // $this->debugrint($sql);
        $conn = $this->dbconnect();
        if($conn == true){
            $ret = $this->db->query($sql);
            if(!$ret) {
                return $this->db->lastErrorMsg();
            } else {
                $res = array();
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                    $res[] = $row;
                }
                return $res;
            }
        }else{
            return $conn;
        }
        $this->dbclose();
    }

    function dbupdate($tablename,$arrdata,$where){
        $sql = "UPDATE ".$tablename." SET ";
        foreach ($arrdata as $key => $value) {
            $arrcolname[] = $key;
            $arrcolval[] = $value;
        }
        for ($idx=0; $idx < count($arrdata); $idx++) { 
            if($idx == 0){
                $sql = $sql.$arrcolname[$idx]." = ".$this->numorstring($arrcolval[$idx]);
            }else{
                $sql = $sql.",".$arrcolname[$idx]." = ".$this->numorstring($arrcolval[$idx]);
            }
        }
        $sql = $sql." WHERE ".$where.";";
        // $this->debugrint($sql);
        $conn = $this->dbconnect();
        if($conn == true){
            $ret = $this->db->exec($sql);
            if(!$ret) {
                return $this->db->lastErrorMsg();
            } else {
                return true;                
            }
        }else{
            return $conn;
        }
        $this->dbclose();
    }

    function dbdelete($tablename,$where){
        $sql = "DELETE FROM ".$tablename." WHERE ".$where;
        // $this->debugrint($sql);
        $conn = $this->dbconnect();
        if($conn == true){
            $ret = $this->db->exec($sql);
            if(!$ret) {
                return $this->db->lastErrorMsg();
            } else {
                return true;                
            }
        }else{
            return $conn;
        }
        $this->dbclose();
    }

    function dbclose(){
        $this->db->close();
    }

    function debugrint($var){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    function numorstring($param){
        if(is_numeric($param) == 1){
            return $param;
        }else{
            return "'".$param."'";
        }
    }
}
?>