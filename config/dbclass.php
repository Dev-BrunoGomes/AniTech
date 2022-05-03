<?php
class Dbc
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "anitech";

    public function connect()
    {
        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
        return $con;
    }
}
