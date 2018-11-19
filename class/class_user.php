<?php

class USER
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

	public function register_user($user_name,$user_password,$user_prefix,$user_firstname,$user_lastname,$user_email,$school_id,$branch_id,$user_group_id,$user_crt,$user_flag,$user_status)
	{
		try
		{
			$new_password = password_hash($user_password, PASSWORD_DEFAULT);

			$stmt = $this->conn->prepare("INSERT INTO tbl_user(user_name,user_password,user_password_shows,user_prefix,
			user_firstname,user_lastname,user_email,school_id,branch_id,user_group_id,user_crt,user_flag,user_status)
			VALUES(:user_name_form,:user_password_form,:user_password_shows_form,:user_prefix_form,:user_firstname_form,
			:user_lastname_form,:user_email_form,:school_id_form,:branch_id_form,:user_group_id_form,:user_crt,:user_flag_form,:user_status_form)");

			$stmt->bindparam(":user_name_form", $user_name);
			$stmt->bindparam(":user_password_form", $new_password);
			$stmt->bindparam(":user_password_shows_form", $user_password);
			$stmt->bindparam(":user_prefix_form", $user_prefix);
			$stmt->bindparam(":user_firstname_form", $user_firstname);
			$stmt->bindparam(":user_lastname_form", $user_lastname);
			$stmt->bindparam(":user_email_form", $user_email);
			$stmt->bindparam(":school_id_form", $school_id);
			$stmt->bindparam(":branch_id_form", $branch_id);
			$stmt->bindparam(":user_group_id_form", $user_group_id);
			$stmt->bindparam(":user_crt", $user_crt);
			$stmt->bindparam(":user_flag_form", $user_flag);
			$stmt->bindparam(":user_status_form", $user_status);
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function edit_user($user_id,$user_name,$user_password,$user_prefix,$user_firstname,$user_lastname,$user_email,$user_img,$school_id,$branch_id,$user_group_id,$user_flag)
	{
		try
		{
	$new_password = password_hash($user_password, PASSWORD_DEFAULT);
	 $stmt = $this->conn->prepare("UPDATE tbl_user SET
	 user_name=:user_name_form,
	 user_password=:user_password_form,
	 user_password_shows=:user_password_shows_form,
	 user_prefix=:user_prefix_form,
	 user_firstname=:user_firstname_form,
	 user_lastname=:user_lastname_form,
	 user_email=:user_email_form,
	 user_img=:user_img_form,
	 school_id=:school_id_form,
	 branch_id=:branch_id_form,
	 user_group_id=:user_group_id_form,
	 user_flag=:user_flag_form
     WHERE user_id=:user_id_form");
	$stmt->execute(
		Array(
			':user_id_form' => $user_id,
			':user_name_form' => $user_name,
			':user_password_form' => $new_password,
			':user_password_shows_form' => $user_password,
			':user_prefix_form' => $user_prefix,
			':user_firstname_form' => $user_firstname,
			':user_lastname_form' => $user_lastname,
			':user_email_form' => $user_email,
			':user_img_form' => $user_img,
			':school_id_form' => $school_id,
			':branch_id_form' => $branch_id,
			':user_group_id_form' => $user_group_id,
			':user_flag_form' => $user_flag
	 )
	);
	return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function delete_user($user_id)
	{
		try
		{
$stmt = $this->conn->prepare("UPDATE tbl_user SET is_delete=:is_delete_form  WHERE user_id=:user_id_form");
// $stmt = $this->conn->prepare("DELETE FROM tbl_master_titlename  WHERE title_id=:title_id_form");
$stmt->execute(
		Array(
			':user_id_form' => $user_id,
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



	public function doLogin($username,$user_email,$password)
	{
		try
		{

$stmt = $this->conn->prepare("SELECT
tbl_user.user_id,
tbl_user.user_password,
tbl_user.user_status
FROM 
tbl_user
WHERE
tbl_user.user_flag=:user_flag_param AND
tbl_user.is_delete=:is_delete_param AND
(tbl_user.user_name=:user_name_login OR tbl_user.user_email=:user_email_login)
");
$stmt->execute(array(':user_name_login'=>$username,':user_email_login'=>$user_email,':user_flag_param'=>1,':is_delete_param'=>1));
			  $row=$stmt->fetch(PDO::FETCH_ASSOC);
			  if (password_verify($password, $row['user_password']) && $stmt->rowCount() == 1) {
			    $_SESSION['userSession'] = $row['user_id'];
				$_SESSION['user_status'] =$row['user_status'];
					return true;
			  } else{
			   	return false;
			  }

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
	}

	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['userSession']);
		return true;
	}
}
?>
