<?php
date_default_timezone_set('Asia/Bangkok');
$name_system="ระบบบริหารโรงเรียน"; ///สำหรับเปลี่ยนได้
$link="http://em.iddrives.co.th"; ///สำหรับเปลี่ยนได้
$version="Version 2.1.2017";



///
class Database
{
    private $host = "localhost";
    private $db_name = "iddrives_em";
    private $username = "iddrives_em";
    private $password = "1q2w3e4r";
    public $conn;

    public function dbConnection()
	{

	    $this->conn = null;
        try
		{
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn->exec("set names utf8");
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}


?>
