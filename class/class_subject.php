<?php
class subject_data
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
////funtion กลุ่มหลักสูตร
	public function add_course_group($course_group_name,$course_group_subject_auto,$crt_by,$crt_date,$course_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_course_group(course_group_name,course_group_subject_auto,crt_by,crt_date,course_status)
		    VALUES(:course_group_name_form,:course_group_subject_auto_form,:crt_by_form,:crt_date_form,:course_status_form)");
			$stmt->bindparam(":course_group_name_form", $course_group_name);
			$stmt->bindparam(":course_group_subject_auto_form", $course_group_subject_auto);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":course_status_form", $course_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_course_group($course_group_id,$course_group_name,$course_group_subject_auto,$upd_by,$course_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_course_group SET
	 course_group_name=:course_group_name_form,
	 course_group_subject_auto=:course_group_subject_auto_form,
	 upd_by=:upd_by_form,
	 course_status=:course_status_form
     WHERE course_group_id=:course_group_id_form");
	$stmt->execute(
		Array(
			':course_group_id_form' => $course_group_id,
			':course_group_name_form' => $course_group_name,
			':course_group_subject_auto_form' => $course_group_subject_auto,
			':upd_by_form' => $upd_by,
			':course_status_form' => $course_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_course_group($course_group_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_course_group SET is_delete=:is_delete_form  WHERE course_group_id=:course_group_id_form");
$stmt->execute(
		Array(
			':course_group_id_form' => $course_group_id,
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
////END funtion กลุ่มหลักสูตร

////funtion รายวิชา
	public function add_subject($subject_data_code,$subject_data_name,$type_study_id,$vehicle_type_id,$type_subject_id,$force_hour,
	$school_id,$crt_by,$crt_date,$subject_data_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_subject_data(subject_data_code,subject_data_name,type_study_id,vehicle_type_id,type_subject_id,force_hour,
			school_id,crt_by,crt_date,subject_data_status)
		    VALUES(:subject_data_code_form,:subject_data_name_form,:type_study_id_form,:vehicle_type_id_form,:type_subject_id_form,:force_hour_form,
			:school_id_form,:crt_by_form,:crt_date_form,:subject_data_status_form)");
			$stmt->bindparam(":subject_data_code_form", $subject_data_code);
			$stmt->bindparam(":subject_data_name_form", $subject_data_name);
			$stmt->bindparam(":type_study_id_form", $type_study_id);
			$stmt->bindparam(":vehicle_type_id_form", $vehicle_type_id);
			$stmt->bindparam(":type_subject_id_form", $type_subject_id);
			$stmt->bindparam(":force_hour_form", $force_hour);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":subject_data_status_form", $subject_data_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function edit_subject($subject_data_id,$subject_data_code,$subject_data_name,$type_study_id,$vehicle_type_id,$type_subject_id,$force_hour,
	$school_id,$upd_by,$subject_data_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_subject_data SET
	 subject_data_code=:subject_data_code_form,
	 subject_data_name=:subject_data_name_form,
	 type_study_id=:type_study_id_form,
	 vehicle_type_id=:vehicle_type_id_form,
	 type_subject_id=:type_subject_id_form,
	 force_hour=:force_hour_form,
	 school_id=:school_id_form,
	 upd_by=:upd_by_form,
	 subject_data_status=:subject_data_status_form
     WHERE subject_data_id=:subject_data_id_form");
	$stmt->execute(
		Array(
			':subject_data_id_form' => $subject_data_id,
			':subject_data_code_form' => $subject_data_code,
			':subject_data_name_form' => $subject_data_name,
			':type_study_id_form' => $type_study_id,
			':vehicle_type_id_form' => $vehicle_type_id,
			':type_subject_id_form' => $type_subject_id,
			':force_hour_form' => $force_hour,
			':school_id_form' => $school_id,
			':upd_by_form' => $upd_by,
			':subject_data_status_form' => $subject_data_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_subject($subject_data_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_subject_data SET is_delete=:is_delete_form  WHERE subject_data_id=:subject_data_id_form");
$stmt->execute(
		Array(
			':subject_data_id_form' => $subject_data_id,
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
////END funtion รายวิชา

////funtion กำหนดวันเรียนทฤษฏี
	public function add_subject_theory($subject_data_id,$vehicle_type_id,$st_hour,$st_start_time,$st_end_time,$date_success,$trainer_id,$school_id_post,$st_code,$crt_by,$crt_date)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_subject_theory(subject_data_id,vehicle_type_id,st_hour,st_start_time,st_end_time,st_date,trainer_id,school_id,
			st_code,crt_by,crt_date)
		    VALUES(:subject_data_id_form,:vehicle_type_id_form,:st_hour_form,:st_start_time_form,:st_end_time_form,:st_date_form,:trainer_id_form,:school_id_form,:st_code_form,:crt_by_form,:crt_date_form)");
			$stmt->bindparam(":subject_data_id_form", $subject_data_id);
			$stmt->bindparam(":vehicle_type_id_form", $vehicle_type_id);
			$stmt->bindparam(":st_hour_form", $st_hour);
			$stmt->bindparam(":st_start_time_form", $st_start_time);
			$stmt->bindparam(":st_end_time_form", $st_end_time);
			$stmt->bindparam(":st_date_form", $date_success);
			$stmt->bindparam(":trainer_id_form", $trainer_id);
			$stmt->bindparam(":school_id_form", $school_id_post);
			$stmt->bindparam(":st_code_form", $st_code);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function update_subject_theory($st_id,$st_hour,$st_start_time,$st_end_time,$st_date,$upd_by)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_subject_theory SET 
st_hour=:st_hour_param,
st_start_time=:st_start_time_param,
st_end_time=:st_end_time_param,
st_date=:date_success_param,
upd_by=:upd_by_param
WHERE 
st_id=:st_id_param");
$stmt->execute(
		Array(
			':st_id_param' =>$st_id,
			':st_hour_param' =>$st_hour,
			':st_start_time_param' =>$st_start_time,
			':st_end_time_param' =>$st_end_time,
			':date_success_param' =>$st_date,
			':upd_by_param' =>$upd_by
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function del_subject_theory($st_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_subject_theory SET is_delete=:is_delete_param  WHERE st_id=:st_id_param");
$stmt->execute(
		Array(
			':st_id_param' => $st_id,
			':is_delete_param' =>0
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function set_subject_theory($vehicle_type_id,$st_date)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_subject_theory SET success_permiss=:success_permiss_param  WHERE vehicle_type_id=:vehicle_type_id_param AND st_date=:st_date_param");
$stmt->execute(
		Array(
			':success_permiss_param' => 1,
			':vehicle_type_id_param' =>$vehicle_type_id,
			':st_date_param' =>$st_date
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function clear_code($st_code)
	{
		try
		{
	$stmt = $this->conn->prepare("DELETE FROM tbl_subject_theory  WHERE st_code=:st_code_form");
	$stmt->execute(
		Array(
			':st_code_form' => $st_code
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
////END funtion กำหนดวันเรียนทฤษฏี

	//////////ฟังก์ชันสำหรับกำหนดรายวิชาให้หลักสูตรและจัดการหลักสูตร
	public function process_a($subject_data_id,$course_data_id,$time_study,$school_id,$crt_by,$crt_date)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_subject_in_course(subject_data_id,course_data_id,time_study,school_id,crt_by,crt_date)
		    VALUES(:subject_data_id_form,:course_data_id_form,:time_study_form,:school_id_form,:crt_by_form,:crt_date_form)");
			$stmt->bindparam(":subject_data_id_form", $subject_data_id);
			$stmt->bindparam(":course_data_id_form", $course_data_id);
			$stmt->bindparam(":time_study_form", $time_study);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function process_sucess($course_data_id,$course_success)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_course_data SET
	 course_success=:course_success_form
     WHERE course_data_id=:course_data_id_form");
	$stmt->execute(
		Array(
			':course_data_id_form' => $course_data_id,
			':course_success_form' =>$course_success
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}


	public function add_course_data($course_data_code,$course_data_name,$course_group_id,$vehicle_type_id,$course_data_theory_hour,$course_data_practice_hour,
	$course_data_total_hour,$course_data_price,$school_id,$crt_by,$crt_date,$course_data_status)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO tbl_course_data(course_data_code,course_data_name,course_group_id,vehicle_type_id,course_data_theory_hour,
			course_data_practice_hour,course_data_total_hour,course_data_price,school_id,crt_by,crt_date,course_data_status)
		    VALUES(:course_data_code_form,:course_data_name_form,:course_group_id_form,:vehicle_type_id_form,:course_data_theory_hour_form,:course_data_practice_hour_form,
			:course_data_total_hour_form,:course_data_price_form,:school_id_form,:crt_by_form,:crt_date_form,:course_data_status_form)");
			$stmt->bindparam(":course_data_code_form", $course_data_code);
			$stmt->bindparam(":course_data_name_form", $course_data_name);
			$stmt->bindparam(":course_group_id_form", $course_group_id);
			$stmt->bindparam(":vehicle_type_id_form", $vehicle_type_id);
			$stmt->bindparam(":course_data_theory_hour_form", $course_data_theory_hour);
			$stmt->bindparam(":course_data_practice_hour_form", $course_data_practice_hour);
			$stmt->bindparam(":course_data_total_hour_form", $course_data_total_hour);
			$stmt->bindparam(":course_data_price_form", $course_data_price);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":crt_by_form", $crt_by);
			$stmt->bindparam(":crt_date_form", $crt_date);
			$stmt->bindparam(":course_data_status_form", $course_data_status);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function edit_course_data($course_data_id,$course_data_code,$course_data_name,$course_group_id,$vehicle_type_id,$course_data_theory_hour,$course_data_practice_hour,
	$course_data_total_hour,$course_data_price,$school_id,$upd_by,$course_data_status)
	{
		try
		{
	 $stmt = $this->conn->prepare("UPDATE tbl_course_data SET
	 course_data_code=:course_data_code_form,
	 course_data_name=:course_data_name_form,
	 course_group_id=:course_group_id_form,
	 vehicle_type_id=:vehicle_type_id_form,
	 course_data_theory_hour=:course_data_theory_hour_form,
	 course_data_practice_hour=:course_data_practice_hour_form,
	 course_data_total_hour=:course_data_total_hour_form,
	 course_data_price=:course_data_price_form,
	 school_id=:school_id_form,
	 upd_by=:upd_by_form,
	 course_data_status=:course_status_form
     WHERE course_data_id=:course_data_id_form");
	$stmt->execute(
		Array(
			':course_data_id_form' => $course_data_id,
			':course_data_code_form' => $course_data_code,
			':course_data_name_form' => $course_data_name,
			':course_group_id_form' => $course_group_id,
			':vehicle_type_id_form' => $vehicle_type_id,
			':course_data_theory_hour_form' => $course_data_theory_hour,
			':course_data_practice_hour_form' => $course_data_practice_hour,
			':course_data_total_hour_form' => $course_data_total_hour,
			':course_data_price_form' => $course_data_price,
			':school_id_form' => $school_id,
			':upd_by_form' => $upd_by,
			':course_status_form' => $course_data_status
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function delete_course_data($course_data_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_course_data SET is_delete=:is_delete_form  WHERE course_data_id=:course_data_id_form");
$stmt->execute(
		Array(
			':course_data_id_form' => $course_data_id,
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

	public function delete_course_permission($course_data_id)
	{
		try
		{

$stmt = $this->conn->prepare("DELETE FROM tbl_subject_in_course  WHERE course_data_id=:course_data_id_form");
$stmt->execute(
		Array(
			':course_data_id_form' => $course_data_id
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	//////////END ฟังก์ชันสำหรับกำหนดรายวิชาให้หลักสูตรและจัดการหลักสูตร

}
?>
