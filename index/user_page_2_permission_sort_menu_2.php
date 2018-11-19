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
$grp_id = isset($_GET['grp_id']) ? $_GET['grp_id'] : NULL; 
require_once("../config/dbl_config.php");
require_once('../class/class_query.php');
$sql_process = new function_query();

$qa = $sql_process->runQuery(
    "SELECT
tbl_program_group.grp_icon,
tbl_program_group.gp_name,
tbl_program_sub.prog_name,
tbl_program_permission.grp_id,
tbl_program_permission.prog_id,
tbl_program_permission.page_number_prog_id,
tbl_program_permission.user_group_id
FROM
tbl_program_permission ,
tbl_program_group ,
tbl_program_sub
WHERE
tbl_program_permission.grp_id = tbl_program_group.grp_id AND
tbl_program_permission.prog_id = tbl_program_sub.prog_id AND
tbl_program_permission.grp_id = :grp_id_param AND
tbl_program_permission.user_group_id =:user_group_id_param AND
tbl_program_permission.school_id = :school_id_param
ORDER BY
tbl_program_permission.page_number_prog_id ASC

");
    $qa->execute(array(":school_id_param"=>$school_id,":user_group_id_param"=>$user_group_id,":grp_id_param"=>$grp_id));
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
                url: 'user_page_2_permission_sort_menu_2_process.php?user_group_id=<?=$user_group_id?>&school_id=<?=$school_id?>&grp_id=<?=$grp_id?>',
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

?>
<li id="<?php echo $rs['prog_id']; ?>">
	<span></span>
	<?php echo $rs['gp_name']; ?>
	<!-- <img src="../images/image_program/<?php echo $rs['grp_icon']; ?>" width="50" height="45"> -->
	<div><h2>
	<?php echo $rs['prog_name']; ?></h2><?php //echo $rs['description']; ?></div>
</li>
<?php
}
?>
</ul>
  
</body>
</html>
