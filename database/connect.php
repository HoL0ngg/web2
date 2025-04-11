<?php
class database
{
    private $host = "localhost";
    private $dbname = "webbanhang";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("ket noi that bai" . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}


?>
