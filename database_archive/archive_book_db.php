<?php
class ArchiveDB{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "archive";

    protected function connect(){
        $sql = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname;
        $pdo = new PDO($sql, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;

    }
}









?>