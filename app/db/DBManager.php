<?php

require_once("app/config/config.php");

class DBManager {

    function __construct() {
        $this->type = CONFIG["database_type"];
        $this->user = CONFIG["database_username"];
        $this->pass = CONFIG["database_password"];
        $this->host = CONFIG["database_host"];
        $this->port = CONFIG["database_port"];
        $this->db_name = CONFIG["database_name"];
        $this->db_conn = null;
        $this->query_conn = null;
    }

    static function singleQuery($query, $parameters=array()) {
        $db = new DBManager();
        return $db->query($query, $parameters);
    }

    function query($query, $parameters=array()) {
        $this->startConnection();
        $result = $this->sendQuery($query, $parameters);
        $this->closeConnection();
        return $result;
    }

    private function startConnection() {
        try {
            $this->makeConnection();
        } catch (PDOException $err) {
            $this->manageConnectionErrors($err);
        }
    }

    function sendQuery($query, $parameters=array()) {
        $result = [];
        $this->query_conn = $this->db_conn->prepare($query);
        $this->query_conn->execute($parameters);
        $result = [
            "lastInsertId" => $this->db_conn->lastInsertId(),
            "results" => $this->query_conn->fetchAll()
        ];
        $this->query_conn->closeCursor();
        return $result;
    }

    function closeConnection() {
        $this->db_conn = null;
        $this->query_conn = null;
    }

    function makeConnection($isDBExists=true) {
        $db_info = "$this->type:host=$this->host;port=$this->port";
        if ($isDBExists) {
            $db_info .= ";dbname=$this->db_name";
        }
        $this->db_conn = new PDO($db_info, $this->user, $this->pass);
    }

    private function manageConnectionErrors($err) {
        $err_code = $err->getCode();
        switch ($err_code) {
            default:
                print "<pre>Error while connecting to DB:</br> " . $err->getMessage() . "</br></pre>";
                die;
        }
    }

    static function readSqlFile($file_name) {
        try {
            $sql = file_get_contents($file_name);
        } catch (Exception $err) {
            print($err);
            $sql = "";
        }
        return $sql;
    }

    static function replaceNewlinesWithBreaks($astring) {
        return str_replace("\n", "<br>", $astring);
    }
}

?>