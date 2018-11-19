<?php
class register_process
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



	public function register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$register_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_temp_class_schedule(subject_data_id,vehicle_type_id,type_study_id,trainer_id,rmcs_start_date,rmcs_date_end,
			rmcs_hour,school_id,crt_by,crt_date,num_code,rst_temp_code)
		    VALUES(:subject_data_id_form,:vehicle_type_id_form,:type_study_id_form,:trainer_id_form,:rmcs_start_date_form,:rmcs_date_end_form,:rmcs_hour_form,:school_id_form,
			:crt_by_form,:crt_date_form,:num_code_form,:rst_temp_code_form)");
			$stmt->bindparam(":subject_data_id_form", $subject_data_id);
			$stmt->bindparam(":vehicle_type_id_form", $vehicle_type_id);
			$stmt->bindparam(":type_study_id_form", $type_study_id);
			$stmt->bindparam(":trainer_id_form", $trainer_id);
			$stmt->bindparam(":rmcs_start_date_form", $rmcs_start_date);
			$stmt->bindparam(":rmcs_date_end_form", $rmcs_date_end);
			$stmt->bindparam(":rmcs_hour_form", $rmcs_hour);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":num_code_form", $num_code);
			$stmt->bindparam(":rst_temp_code_form", $register_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function update_register_temp_class_schedule($id,$start,$end,$calDate)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_register_temp_class_schedule SET 
rmcs_start_date=:rmcs_start_date_form,
rmcs_date_end=:rmcs_date_end_form,
rmcs_hour=:rmcs_hour_form
WHERE rmcs_id=:rmcs_id_form");

$stmt->execute(
		Array(
			':rmcs_id_form' => $id,
			':rmcs_start_date_form' => $start,
			':rmcs_date_end_form' => $end,
			':rmcs_hour_form' => $calDate
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function delete_regis_tmp_calendar($id)
	{
		try
		{
// $stmt = $this->conn->prepare("UPDATE tbl_master_titlename SET is_delete=:is_delete_form  WHERE title_id=:title_id_form");
 $stmt = $this->conn->prepare("DELETE FROM tbl_register_temp_class_schedule  WHERE rmcs_id=:rmcs_id_form");
$stmt->execute(
		Array(
			':rmcs_id_form' => $id,
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function add_regis_tmp_doc($doc_id,$doc_detail,$doc_sent,$school_id,$rst_temp_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_temp_doc(doc_id,doc_detail,doc_sent,school_id,rst_temp_code)
		    VALUES(:doc_id_form,:doc_detail_form,:doc_sent_form,:school_id_form,:rst_temp_code_form)");
			$stmt->bindparam(":doc_id_form", $doc_id);
			$stmt->bindparam(":doc_detail_form", $doc_detail);
			$stmt->bindparam(":doc_sent_form", $doc_sent);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":rst_temp_code_form", $rst_temp_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function update_regis_tmp_doc($doc_id,$doc_detail,$doc_sent,$school_id,$rst_temp_code)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_register_temp_doc SET 
doc_detail=:doc_detail_form,
doc_sent=:doc_sent_form
WHERE rst_temp_code=:rst_temp_code_form AND doc_id=:doc_id_form");

$stmt->execute(
		Array(
			':doc_id_form' => $doc_id,
			':rst_temp_code_form' => $rst_temp_code,
			':doc_detail_form' => $doc_detail,
			':doc_sent_form' => $doc_sent
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}



	public function register_main($rm_number,$student_id,$course_data_id,$rm_date,$rm_pay_status,$rm_source,$rm_status,$testing_result,$complete_date,$school_id,$branch_id,$vegicle_data_id,$transportation_id,$crt_by,$crt_date,$register_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_main(rm_number,student_id,course_data_id,rm_date,rm_pay_status,rm_source,
			rm_status,testing_result,complete_date,school_id,branch_id,vegicle_data_id,transportation_id,crt_by,crt_date,register_code)
		    VALUES(:rm_number_form,:student_id_form,:course_data_id_form,:rm_date_form,:rm_pay_status_form,:rm_source_form,:rm_status_form,:testing_result_form,
			:complete_date_form,:school_id_form,:branch_id_form,:vegicle_data_id_form,:transportation_id_form,:crt_by_form,:crt_date_form,:register_code_form)");
			$stmt->bindparam(":rm_number_form", $rm_number);
			$stmt->bindparam(":student_id_form", $student_id);
			$stmt->bindparam(":course_data_id_form", $course_data_id);
			$stmt->bindparam(":rm_date_form", $rm_date);
			$stmt->bindparam(":rm_pay_status_form", $rm_pay_status);
			$stmt->bindparam(":rm_source_form", $rm_source);
			$stmt->bindparam(":rm_status_form", $rm_status);
			$stmt->bindparam(":testing_result_form", $testing_result);
			$stmt->bindparam(":complete_date_form", $complete_date);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":branch_id_form", $branch_id);
			$stmt->bindparam(":vegicle_data_id_form", $vegicle_data_id);
			$stmt->bindparam(":transportation_id_form", $transportation_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":register_code_form", $register_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function register_main_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$register_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_main_class_schedule(subject_data_id,vehicle_type_id,type_study_id,trainer_id,rmcs_start_date,rmcs_date_end,
			rmcs_hour,school_id,crt_by,crt_date,num_code,register_code)
		    VALUES(:subject_data_id_form,:vehicle_type_id_form,:type_study_id_form,:trainer_id_form,:rmcs_start_date_form,:rmcs_date_end_form,:rmcs_hour_form,:school_id_form,
			:crt_by_form,:crt_date_form,:num_code_form,:rst_main_code_form)");
			$stmt->bindparam(":subject_data_id_form", $subject_data_id);
			$stmt->bindparam(":vehicle_type_id_form", $vehicle_type_id);
			$stmt->bindparam(":type_study_id_form", $type_study_id);
			$stmt->bindparam(":trainer_id_form", $trainer_id);
			$stmt->bindparam(":rmcs_start_date_form", $rmcs_start_date);
			$stmt->bindparam(":rmcs_date_end_form", $rmcs_date_end);
			$stmt->bindparam(":rmcs_hour_form", $rmcs_hour);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":num_code_form", $num_code);
			$stmt->bindparam(":rst_main_code_form", $register_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function register_main_exam_schedule($esd_id,$type_study_id,$school_id,$register_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_main_exam_schedule(esd_id,type_study_id,school_id,register_code)
		    VALUES(:esd_id_form,:type_study_id_form,:school_id_form,:rst_main_code_form)");
			$stmt->bindparam(":esd_id_form", $esd_id);
			$stmt->bindparam(":type_study_id_form", $type_study_id);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":rst_main_code_form", $register_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
	public function register_main_doc($doc_id,$doc_detail,$doc_sent,$school_id,$register_code)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_register_main_doc(doc_id,doc_detail,doc_sent,school_id,register_code)
		    VALUES(:doc_id_form,:doc_detail_form,:doc_sent_form,:school_id_form,:rst_main_code_form)");
			$stmt->bindparam(":doc_id_form", $doc_id);
			$stmt->bindparam(":doc_detail_form", $doc_detail);
			$stmt->bindparam(":doc_sent_form", $doc_sent);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":rst_main_code_form", $register_code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}



}
?>
