<?php
class Q_gen
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function rowsQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$total_data=$stmt->rowCount();
		return $total_data;
	}
	


	
}
    ?>