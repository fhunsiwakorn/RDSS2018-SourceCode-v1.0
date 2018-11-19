<?php
class location_data
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

	public function add_province($province_code,$province_name,$crt_by,$crt_date,$province_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_location_province(province_code,province_name,crt_by,crt_date,province_status)
		    VALUES(:province_code_form,:province_name_form,:crt_by_form,:crt_date_form,:province_status_form)");
			$stmt->bindparam(":province_code_form", $province_code);
			$stmt->bindparam(":province_name_form", $province_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":province_status_form", $province_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_province($province_id,$province_code,$province_name,$upd_by,$province_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_location_province SET
	 province_code=:province_code_form,
	 province_name=:province_name_form,
	 upd_by=:upd_by_form,
	 province_status=:province_status_form
     WHERE province_id=:province_id_form");
	$stmt->execute(
		Array(
			':province_id_form' => $province_id,
			':province_code_form' => $province_code,
			':province_name_form' => $province_name,
			':upd_by_form' => $upd_by,
			':province_status_form' => $province_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_province($province_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_location_province SET is_delete=:is_delete_form  WHERE province_id=:province_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_location_province  WHERE province_id=:province_id_form");
	$stmt->execute(
		Array(
			':province_id_form' => $province_id,
			':is_delete_form' => 0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function add_amphur($amphur_code,$amphur_name,$province_id,$crt_by,$crt_date,$amphur_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_location_amphur(amphur_code,amphur_name,province_id,crt_by,crt_date,amphur_status)
		    VALUES(:amphur_code_form,:amphur_name_form,:province_id_form,:crt_by_form,:crt_date_form,:amphur_status_form)");
			$stmt->bindparam(":amphur_code_form", $amphur_code);
			$stmt->bindparam(":amphur_name_form", $amphur_name);
			$stmt->bindparam(":province_id_form", $province_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":amphur_status_form", $amphur_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_amphur($amphur_id,$amphur_code,$amphur_name,$province_id,$upd_by,$amphur_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_location_amphur SET
	 amphur_code=:amphur_code_form,
	 amphur_name=:amphur_name_form,
	 province_id=:province_id_form,
	 upd_by=:upd_by_form,
	 amphur_status=:amphur_status_form
     WHERE amphur_id=:amphur_id_form");
	$stmt->execute(
		Array(
			':amphur_id_form' => $amphur_id,
			':amphur_code_form' => $amphur_code,
			':amphur_name_form' => $amphur_name,
			':province_id_form' => $province_id,
			':upd_by_form' => $upd_by,
			':amphur_status_form' => $amphur_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_amphur($amphur_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_location_amphur SET is_delete=:is_delete_form  WHERE amphur_id=:amphur_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_location_amphur  WHERE amphur_id=:amphur_id_form");
	$stmt->execute(
		Array(
			':amphur_id_form' => $amphur_id,
			':is_delete_form' => 0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function add_district($district_code,$district_name,$amphur_id,$province_id,$crt_by,$crt_date,$district_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_location_district(district_code,district_name,amphur_id,province_id,crt_by,crt_date,district_status)
		    VALUES(:district_code_form,:district_name_form,:amphur_id_form,:province_id_form,:crt_by_form,:crt_date_form,:district_status_form)");
			$stmt->bindparam(":district_code_form", $district_code);
			$stmt->bindparam(":district_name_form", $district_name);
			$stmt->bindparam(":amphur_id_form", $amphur_id);
			$stmt->bindparam(":province_id_form", $province_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":district_status_form", $district_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_district($district_id,$district_code,$district_name,$amphur_id,$province_id,$upd_by,$district_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_location_district SET
	 district_code=:district_code_form,
	 district_name=:district_name_form,
	 amphur_id=:amphur_id_form,
	 province_id=:province_id_form,
	 upd_by=:upd_by_form,
	 district_status=:district_status_form
     WHERE district_id=:district_id_form");
	$stmt->execute(
		Array(
			':district_id_form' => $district_id,
			':district_code_form' => $district_code,
			':district_name_form' => $district_name,
			':amphur_id_form' => $amphur_id,
			':province_id_form' => $province_id,
			':upd_by_form' => $upd_by,
			':district_status_form' => $district_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_district($district_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_location_district SET is_delete=:is_delete_form  WHERE district_id=:district_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_location_district  WHERE district_id=:district_id_form");
	$stmt->execute(
		Array(
			':district_id_form' => $district_id,
			':is_delete_form' => 0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function add_zipcode($province_id,$amphur_id,$district_id,$zipcode,$crt_by,$crt_date,$zipcode_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_location_zipcode(province_id,amphur_id,district_id,zipcode,crt_by,crt_date,zipcode_status)
		    VALUES(:province_id_form,:amphur_id_form,:district_id_form,:zipcode_form,:crt_by_form,:crt_date_form,:zipcode_status_form)");
			$stmt->bindparam(":province_id_form", $province_id);
			$stmt->bindparam(":amphur_id_form", $amphur_id);
			$stmt->bindparam(":district_id_form", $district_id);
			$stmt->bindparam(":zipcode_form", $zipcode);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":zipcode_status_form", $zipcode_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_zipcode($zipcode_id,$province_id,$amphur_id,$district_id,$zipcode,$upd_by,$zipcode_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_location_zipcode SET
	 province_id=:province_id_form,
	 amphur_id=:amphur_id_form,
	 district_id=:district_id_form,
	 zipcode=:zipcode_form,
	 upd_by=:upd_by_form,
	 zipcode_status=:zipcode_status_form
     WHERE zipcode_id=:zipcode_id_form");
	$stmt->execute(
		Array(
			':zipcode_id_form' => $zipcode_id,
			':province_id_form' => $province_id,
			':amphur_id_form' => $amphur_id,
			':district_id_form' => $district_id,
			':zipcode_form' => $zipcode,
			':upd_by_form' => $upd_by,
			':zipcode_status_form' => $zipcode_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_zipcode($zipcode_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_location_zipcode SET is_delete=:is_delete_form  WHERE zipcode_id=:zipcode_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_location_zipcode  WHERE zipcode_id=:zipcode_id_form");
	$stmt->execute(
		Array(
			':zipcode_id_form' => $zipcode_id,
			':is_delete_form' => 0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>
