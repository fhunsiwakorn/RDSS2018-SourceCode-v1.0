<?php
class masterdata_general
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

public function insert($table, array $data)
{

    /*
     * Check for input errors.
     */
    if(empty($data)) {
        throw new InvalidArgumentException('Cannot insert an empty array.');
    }
    if(!is_string($table)) {
        throw new InvalidArgumentException('Table name must be a string.');
    }

    $fields = '`' . implode('`, `', array_keys($data)) . '`';
    $placeholders = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO {$table} ($fields) VALUES ({$placeholders})";

    var_dump($sql);

    // Prepare new statement
    $stmt = $this->pdo->prepare($sql);

    /*
     * Bind parameters into the query.
     *
     * We need to pass the value by reference as the PDO::bindParam method uses
     * that same reference.
     */
    foreach($data as $placeholder => &$value) {

        // Prefix the placeholder with the identifier
        $placeholder = ':' . $placeholder;

        // Bind the parameter.
        $stmt->bindParam($placeholder, $value);

    }

    /*
     * Check if the query was executed. This does not check if any data was actually
     * inserted as MySQL can be set to discard errors silently.
     */
    if(!$stmt->execute()) {
        throw new ErrorException('Could not execute query');
    }

    /*
     * Check if any rows was actually inserted.
     */
    if($stmt->rowCount() == 0) {

        var_dump($this->pdo->errorCode());

        throw new ErrorException('Could not insert data into users table.');
    }

    return true;

}




	public function add_study_type($type_study_name,$crt_by,$crt_date,$type_study_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_type_study(type_study_name,crt_by,crt_date,type_study_status)
		    VALUES(:type_study_name_form,:crt_by_form,:crt_date_form,:type_study_status_form)");
			$stmt->bindparam(":type_study_name_form", $type_study_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":type_study_status_form", $type_study_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_study_type($type_study_id,$type_study_name,$upd_by,$type_study_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_type_study SET
	 type_study_name=:type_study_name_form,
	 upd_by=:upd_by_form,
	 type_study_status=:type_study_status_form
     WHERE type_study_id=:type_study_id_form");
	$stmt->execute(
		Array(
			':type_study_id_form' => $type_study_id,
			':type_study_name_form' => $type_study_name,
			':upd_by_form' => $upd_by,
			':type_study_status_form' => $type_study_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_study_type($type_study_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_type_study SET is_delete=:is_delete_form  WHERE type_study_id=:type_study_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':type_study_id_form' => $type_study_id,
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
	public function add_subject_type($type_subject_name,$crt_by,$crt_date,$type_subject_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_type_subject(type_subject_name,crt_by,crt_date,type_subject_status)
		    VALUES(:type_subject_name_form,:crt_by_form,:crt_date_form,:type_subject_status_form)");
			$stmt->bindparam(":type_subject_name_form", $type_subject_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":type_subject_status_form", $type_subject_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_subject_type($type_subject_id,$type_subject_name,$upd_by,$type_subject_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_type_subject SET
	 type_subject_name=:type_subject_name_form,
	 upd_by=:upd_by_form,
	 type_subject_status=:type_subject_status_form
     WHERE type_subject_id=:type_subject_id_form");
	$stmt->execute(
		Array(
			':type_subject_id_form' => $type_subject_id,
			':type_subject_name_form' => $type_subject_name,
			':upd_by_form' => $upd_by,
			':type_subject_status_form' => $type_subject_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_subject_type($type_subject_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_type_subject SET is_delete=:is_delete_form  WHERE type_subject_id=:type_subject_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':type_subject_id_form' => $type_subject_id,
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
	public function add_energy_type($type_energy_name,$crt_by,$crt_date,$type_energy_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_type_energy(type_energy_name,crt_by,crt_date,type_energy_status)
		    VALUES(:type_energy_name_form,:crt_by_form,:crt_date_form,:type_energy_status_form)");
			$stmt->bindparam(":type_energy_name_form", $type_energy_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":type_energy_status_form", $type_energy_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_energy_type($type_energy_id,$type_energy_name,$upd_by,$type_energy_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_type_energy SET
	 type_energy_name=:type_energy_name_form,
	 upd_by=:upd_by_form,
	 type_energy_status=:type_energy_status_form
     WHERE type_energy_id=:type_energy_id_form");
	$stmt->execute(
		Array(
			':type_energy_id_form' => $type_energy_id,
			':type_energy_name_form' => $type_energy_name,
			':upd_by_form' => $upd_by,
			':type_energy_status_form' => $type_energy_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_energy_type($type_energy_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_type_energy SET is_delete=:is_delete_form  WHERE type_energy_id=:type_energy_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':type_energy_id_form' => $type_energy_id,
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
	public function add_career($career_name,$crt_by,$crt_date,$career_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_career(career_name,crt_by,crt_date,career_status)
		    VALUES(:career_name_form,:crt_by_form,:crt_date_form,:career_status_form)");
			$stmt->bindparam(":career_name_form", $career_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":career_status_form", $career_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_career($career_id,$career_name,$upd_by,$career_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_career SET
	 career_name=:career_name_form,
	 upd_by=:upd_by_form,
	 career_status=:career_status_form
     WHERE career_id=:career_id_form");
	$stmt->execute(
		Array(
			':career_id_form' => $career_id,
			':career_name_form' => $career_name,
			':upd_by_form' => $upd_by,
			':career_status_form' => $career_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_career($career_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_career SET is_delete=:is_delete_form  WHERE career_id=:career_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':career_id_form' => $career_id,
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
	public function add_income($income_text,$crt_by,$crt_date,$income_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_income(income_text,crt_by,crt_date,income_status)
		    VALUES(:income_text_form,:crt_by_form,:crt_date_form,:income_status_form)");
			$stmt->bindparam(":income_text_form", $income_text);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":income_status_form", $income_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_income($income_id,$income_text,$upd_by,$income_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_income SET
	 income_text=:income_text_form,
	 upd_by=:upd_by_form,
	 income_status=:income_status_form
     WHERE income_id=:income_id_form");
	$stmt->execute(
		Array(
			':income_id_form' => $income_id,
			':income_text_form' => $income_text,
			':upd_by_form' => $upd_by,
			':income_status_form' => $income_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_income($income_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_income SET is_delete=:is_delete_form  WHERE income_id=:income_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':income_id_form' => $income_id,
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
	public function add_reason($reason_text,$crt_by,$crt_date,$reason_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_reason(reason_text,crt_by,crt_date,reason_status)
		    VALUES(:reason_text_form,:crt_by_form,:crt_date_form,:reason_status_form)");
			$stmt->bindparam(":reason_text_form", $reason_text);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":reason_status_form", $reason_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_reason($reason_id,$reason_text,$upd_by,$reason_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_reason SET
	 reason_text=:reason_text_form,
	 upd_by=:upd_by_form,
	 reason_status=:reason_status_form
     WHERE reason_id=:reason_id_form");
	$stmt->execute(
		Array(
			':reason_id_form' => $reason_id,
			':reason_text_form' => $reason_text,
			':upd_by_form' => $upd_by,
			':reason_status_form' => $reason_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_reason($reason_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_reason SET is_delete=:is_delete_form  WHERE reason_id=:reason_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':reason_id_form' =>$reason_id,
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
	public function add_teach_type($teach_type_name,$crt_by,$crt_date,$teach_type_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_type_teach(teach_type_name,crt_by,crt_date,teach_type_status)
		    VALUES(:teach_type_name_form,:crt_by_form,:crt_date_form,:teach_type_status_form)");
			$stmt->bindparam(":teach_type_name_form", $teach_type_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":teach_type_status_form", $teach_type_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_teach_type($teach_type_id,$teach_type_name,$upd_by,$teach_type_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_type_teach SET
	 teach_type_name=:teach_type_name_form,
	 upd_by=:upd_by_form,
	 teach_type_status=:teach_type_status_form
     WHERE teach_type_id=:teach_type_id_form");
	$stmt->execute(
		Array(
			':teach_type_id_form' => $teach_type_id,
			':teach_type_name_form' => $teach_type_name,
			':upd_by_form' => $upd_by,
			':teach_type_status_form' => $teach_type_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_teach_type($teach_type_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_type_teach SET is_delete=:is_delete_form  WHERE teach_type_id=:teach_type_id_form");
	$stmt->execute(
		Array(
			':teach_type_id_form' =>$teach_type_id,
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
	public function add_trainer_type($trainer_type_name,$crt_by,$crt_date,$trainer_type_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_type_trainer(trainer_type_name,crt_by,crt_date,trainer_type_status)
		    VALUES(:trainer_type_name_form,:crt_by_form,:crt_date_form,:trainer_type_status_form)");
			$stmt->bindparam(":trainer_type_name_form", $trainer_type_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":trainer_type_status_form", $trainer_type_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_trainer_type($trainer_type_id,$trainer_type_name,$upd_by,$trainer_type_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_type_trainer SET
	 trainer_type_name=:trainer_type_name_form,
	 upd_by=:upd_by_form,
	 trainer_type_status=:trainer_type_status_form
     WHERE trainer_type_id=:trainer_type_id_form");
	$stmt->execute(
		Array(
			':trainer_type_id_form' => $trainer_type_id,
			':trainer_type_name_form' => $trainer_type_name,
			':upd_by_form' => $upd_by,
			':trainer_type_status_form' => $trainer_type_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_trainer_type($trainer_type_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_type_trainer SET is_delete=:is_delete_form  WHERE trainer_type_id=:trainer_type_id_form");
	$stmt->execute(
		Array(
			':trainer_type_id_form' =>$trainer_type_id,
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


	public function add_country($country_name,$crt_by,$crt_date,$country_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_country(country_name,crt_by,crt_date,country_status)
		    VALUES(:country_name_form,:crt_by_form,:crt_date_form,:country_status_form)");
			$stmt->bindparam(":country_name_form", $country_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":country_status_form", $country_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_country($country_id,$country_name,$upd_by,$country_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_country SET
	 country_name=:country_name_form,
	 upd_by=:upd_by_form,
	 country_status=:country_status_form
     WHERE country_id=:country_id_form");
	$stmt->execute(
		Array(
			':country_id_form' => $country_id,
			':country_name_form' => $country_name,
			':upd_by_form' => $upd_by,
			':country_status_form' => $country_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_country($country_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_country SET is_delete=:is_delete_form  WHERE country_id=:country_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_country  WHERE country_id=:country_id_form");
	$stmt->execute(
		Array(
			':country_id_form' => $country_id,
			':is_delete_form' =>0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function add_nationality($nationality_name,$crt_by,$crt_date,$nationality_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_nationality(nationality_name,crt_by,crt_date,nationality_status)
		    VALUES(:nationality_name_form,:crt_by_form,:crt_date_form,:nationality_status_form)");
			$stmt->bindparam(":nationality_name_form", $nationality_name);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":nationality_status_form", $nationality_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_nationality($nationality_id,$nationality_name,$upd_by,$nationality_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_nationality SET
	 nationality_name=:nationality_name_form,
	 upd_by=:upd_by_form,
	 nationality_status=:nationality_status_form
     WHERE nationality_id=:nationality_id_form");
	$stmt->execute(
		Array(
			':nationality_id_form' => $nationality_id,
			':nationality_name_form' => $nationality_name,
			':upd_by_form' => $upd_by,
			':nationality_status_form' => $nationality_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_nationality($nationality_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_nationality SET is_delete=:is_delete_form  WHERE nationality_id=:nationality_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_nationality  WHERE nationality_id=:nationality_id_form");
	$stmt->execute(
		Array(
			':nationality_id_form' => $nationality_id,
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

	public function add_titlename($title_name,$language_status,$crt_by,$crt_date,$title_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_titlename(title_name,language_status,crt_by,crt_date,title_status)
		    VALUES(:titlename_form,:language_status_form,:crt_by_form,:crt_date_form,:title_status_form)");
			$stmt->bindparam(":titlename_form", $title_name);
			$stmt->bindparam(":language_status_form", $language_status);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":title_status_form", $title_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_titlename($title_id,$title_name,$language_status,$upd_by,$title_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_titlename SET
	 title_name=:title_name_form,
	 language_status=:language_status_form,
	 upd_by=:upd_by_form,
	 title_status=:title_status_form
     WHERE title_id=:title_id_form");
	$stmt->execute(
		Array(
			':title_id_form' => $title_id,
			':title_name_form' => $title_name,
			':language_status_form' => $language_status,
			':upd_by_form' => $upd_by,
			':title_status_form' => $title_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_titlename($title_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_master_titlename SET is_delete=:is_delete_form  WHERE title_id=:title_id_form");
// $stmt = $this->conn->prepare("DELETE FROM tbl_master_titlename  WHERE title_id=:title_id_form");
$stmt->execute(
		Array(
			':title_id_form' => $title_id,
			':is_delete_form' =>0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function add_vehicle_type($vehicle_type,$vehicle_type_allow,$crt_by,$crt_date,$vehicle_type_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_master_vehicle_type(vehicle_type_name,vehicle_type_allow,crt_by,crt_date,vehicle_type_status)
		    VALUES(:vehicle_type_name_form,:vehicle_type_allow_form,:crt_by_form,:crt_date_form,:vehicle_type_status_form)");
			$stmt->bindparam(":vehicle_type_name_form", $vehicle_type);
			$stmt->bindparam(":vehicle_type_allow_form", $vehicle_type_allow);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":vehicle_type_status_form", $vehicle_type_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_vehicle_type($vehicle_type_id,$vehicle_type_name,$vehicle_type_allow,$theory_hour,$practice_hour,$upd_by,$vehicle_type_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_master_vehicle_type SET
	 vehicle_type_name=:vehicle_type_name_form,
	 vehicle_type_allow=:vehicle_type_allow_form,
	 theory_hour=:theory_hour_form,
	 practice_hour=:practice_hour_form,
	 upd_by=:upd_by_form,
	 vehicle_type_status=:vehicle_type_status_form
     WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':vehicle_type_id_form' => $vehicle_type_id,
			':vehicle_type_name_form' => $vehicle_type_name,
			':vehicle_type_allow_form' => $vehicle_type_allow,
			':theory_hour_form' => $theory_hour,
			':practice_hour_form' => $practice_hour,
			':upd_by_form' => $upd_by,
			':vehicle_type_status_form' => $vehicle_type_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_vehicle_type($vehicle_type_id)
	{
		try
		{
	$stmt = $this->conn->prepare("UPDATE tbl_master_vehicle_type SET is_delete=:is_delete_form  WHERE vehicle_type_id=:vehicle_type_id_form");
	// $stmt = $this->conn->prepare("DELETE FROM tbl_master_vehicle_type  WHERE vehicle_type_id=:vehicle_type_id_form");
	$stmt->execute(
		Array(
			':vehicle_type_id_form' => $vehicle_type_id,
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
