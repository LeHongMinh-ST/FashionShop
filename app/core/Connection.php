<?php

class Connection
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    function __construct()
    {
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->dbname = 'test';
    }

    function connect()
    {

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        mysqli_set_charset($conn, "UTF8");
        if ($conn->connect_errno) {
            echo "fail" . $conn->connect_error;
            exit();
        }

        return $conn;
    }
}