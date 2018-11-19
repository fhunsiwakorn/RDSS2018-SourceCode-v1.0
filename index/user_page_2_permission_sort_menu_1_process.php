<?php
/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Dynamic Drag and Drop with jQuery and PHP
*/

// ถ้ามีค่า get ส่งมาจากการค้นหา
$school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
$user_group_id = isset($_GET['user_group_id']) ? $_GET['user_group_id'] : NULL; 
// including the config file

  require_once("../config/dbl_config.php");
  require_once('../class/class_query.php');
  $sql_process = new function_query();

// get the list of items id separated by cama (,)
$list_order = $_POST['list_order'];
// convert the string list to an array
$list = explode(',' , $list_order);
$i = 1 ;
foreach($list as $id) {
	try {
        $query = $sql_process->runQuery("UPDATE tbl_program_permission SET page_number_grp_id = :item_order 
		 WHERE  grp_id =:id AND user_group_id=:user_group_id_param AND school_id=:school_id_param");
		$query->bindParam(':item_order', $i, PDO::PARAM_INT);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':user_group_id_param', $user_group_id, PDO::PARAM_INT);
		$query->bindParam(':school_id_param', $school_id, PDO::PARAM_INT);
		$query->execute();

	    // $sql  = 'UPDATE items SET item_order = :item_order WHERE id = :id' ;
		// $query = $pdo->prepare($sql);
		// $query->bindParam(':index_topic', $i, PDO::PARAM_INT);
		// $query->bindParam(':evl_id', $evl_id, PDO::PARAM_INT);
		// $query->execute();
		// $sql  = 'UPDATE tbl_evaluationform_data SET index_topic = :index_topic WHERE evl_id = :id' ;
		// $query = $pdo->prepare($sql);
		// $query->bindParam(':index_topic', $i, PDO::PARAM_INT);
		// $query->bindParam(':id', $id, PDO::PARAM_INT);
		// $query->execute();
	} catch (PDOException $e) {
		echo 'PDOException : '.  $e->getMessage();
	}
	$i++ ;
}

?>