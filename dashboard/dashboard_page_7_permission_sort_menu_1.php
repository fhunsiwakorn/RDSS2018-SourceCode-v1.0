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

require_once("../config/dbl_config.php");
require_once('../class/class_query.php');
$sql_process = new function_query();

// select all items ordered by item_order
$qa = $sql_process->runQuery(
    "SELECT DISTINCT
tbl_program_permission.user_group_id,
tbl_program_permission.grp_id,
tbl_program_permission.school_id
FROM
tbl_program_permission
WHERE
tbl_program_permission.school_id =:school_id_param AND
tbl_program_permission.user_group_id =:user_group_id_param
ORDER BY
tbl_program_permission.page_number_grp_id ASC");
    $qa->execute(array(":school_id_param"=>$school_id,":user_group_id_param"=>$user_group_id));
    $list = $qa->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Drag and Drop using jQuery and Ajax</title>
<link rel="stylesheet" href="../fonts/thsarabunnew.css" />
  <link rel="stylesheet" href="../fonts/style_font.css" />
<link rel="stylesheet" href="../plugins/dynamic-drag-and-drop/css/style.css" />
<script type="text/javascript" src="../plugins/dynamic-drag-and-drop/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../plugins/dynamic-drag-and-drop/js/jquery-ui-1.10.4.custom.min.js"></script>
<!-- <script type="text/javascript" src="../plugins/dynamic-drag-and-drop/js/script.js"></script> -->
<script>
	$(function() {
    $('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
            $.ajax({
                url: 'dashboard_page_7_permission_sort_menu_1_process.php?user_group_id=<?=$user_group_id?>&school_id=<?=$school_id?>',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                    //finished
                }
            });
        }
    }); // fin sortable
});


</script>

</head>

<body>
   
<ul id="sortable">
<?php
foreach ($list as $rs) {
	$stmt = $sql_process->runQuery("SELECT grp_icon,gp_name FROM tbl_program_group WHERE grp_id=:grp_id_id_param");
	$stmt->execute(array(":grp_id_id_param"=>$rs['grp_id']));
	$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<li id="<?php echo $rs['grp_id']; ?>">
	<span></span>
	<img src="../images/image_program/<?php echo $dataRow['grp_icon']; ?>" width="50" height="40">
	<div><h2>
	<?php echo $dataRow['gp_name']; ?></h2><?php //echo $rs['description']; ?></div>
</li>
<?php
}
?>
</ul>
  
</body>
</html>
