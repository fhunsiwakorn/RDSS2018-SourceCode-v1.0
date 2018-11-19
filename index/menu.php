<li>
      <a href="?option=main">
      <img src="../images/images_system/home-512.gif" style="width:30px; height:30px" />  <span style="font-size:16px;">หน้าหลัก</span>
      </a>
<?php
if($_SESSION['user_status'] == "2"){
    $num_group='0';
    $qg = $sql_process->runQuery(
    "SELECT
    tbl_program_group.grp_id,
    tbl_program_group.grp_icon,
    tbl_program_group.gp_name
    FROM
    tbl_program_group 
    WHERE
    tbl_program_group.grp_status ='1' AND
    tbl_program_group.is_delete ='1'
    ORDER BY
    tbl_program_group.grp_id ASC
    ");
    $qg->execute();
    while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
        $num_group++;
?>
 <li class="treeview">
 <a href="#">
 <img src="../images/image_program/<?=$rowGen->grp_icon?>" style="width:30px; height:30px" />  <span style="font-size:16px;"><?=$rowGen->gp_name?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        <?php

    $qp = $sql_process->runQuery(
    "SELECT
tbl_program_sub.prog_name,
tbl_program_sub.prog_gen
FROM
tbl_program_sub
WHERE
tbl_program_sub.prog_status ='1' AND
tbl_program_sub.is_delete ='1' AND
tbl_program_sub.grp_id =:grp_id_param
ORDER BY
tbl_program_sub.prog_id ASC
    ");
    // $qp->execute();
    $qp->execute(array(":grp_id_param"=>$rowGen->grp_id));
    while($rowPro= $qp->fetch(PDO::FETCH_OBJ)) {
?>

          <li><a href="?option=<?=$rowPro->prog_gen?>"><i class="fa fa-circle-o"></i> <?=$rowPro->prog_name?></a></li>
    <?php } ?>
        </ul>
      </li>  

<?php    }  //close while ?>
<!-- ///เมนูพิเศษที่ไม่ได้ดึงจากฐานข้อมูล -->
<li class="treeview">
          <a href="#">
          <img src="../images/images_system/RY84TFOOTI.png" style="width:30px; height:30px" />  <span style="font-size:16px;">กำหนดสิทธิ์ผู้ใช้งาน</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?option=1r1UVnf8olM"><i class="fa fa-circle-o"></i> ข้อมูลกลุ่มผู้ใช้งาน</a></li>
            <li><a href="?option=4UKiyHwBDd9"><i class="fa fa-circle-o"></i> เจ้าหน้าที่ผู้ใช้งาน</a></li>
            <li><a href="?option=l4cSvlmYewP"><i class="fa fa-circle-o"></i> กำหนดสิทธิ์การใช้โปรแกรม</a></li>
     </ul>
 </li>

<?php 
 
}elseif($_SESSION['user_status'] == "3"){
    $num_group='0';
    $qg = $sql_process->runQuery(
    "SELECT DISTINCT
tbl_program_permission.grp_id
FROM
tbl_program_permission ,
tbl_user_group ,
tbl_program_group
WHERE
tbl_program_permission.user_group_id = :user_group_id_param AND
tbl_program_permission.school_id = :school_id_param 
ORDER BY
tbl_program_permission.page_number_grp_id ASC");
$qg->execute(array(":user_group_id_param"=>$profileRow['user_group_id'],":school_id_param"=>$profileRow['school_id']));
    while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
 $num_group++;
 $grp = $auth_user->runQuery("SELECT grp_id,grp_icon,gp_name FROM tbl_program_group WHERE grp_id=:grp_id_param");
 $grp->execute(array(":grp_id_param"=>$rowGen->grp_id));
 $grpRow=$grp->fetch(PDO::FETCH_ASSOC);
?>

<li class="treeview">
 <a href="#">
 <img src="../images/image_program/<?=$grpRow["grp_icon"]?>" style="width:30px; height:30px" />  <span style="font-size:16px;"><?=$grpRow["gp_name"]?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        <?php

    $qp = $sql_process->runQuery(
    "SELECT
tbl_program_sub.prog_name,
tbl_program_sub.prog_gen
FROM
tbl_program_permission ,
tbl_program_sub
WHERE
tbl_program_permission.prog_id = tbl_program_sub.prog_id AND
tbl_program_permission.grp_id = :grp_id_param2 AND
tbl_program_permission.user_group_id = :user_group_id_param2 AND
tbl_program_permission.school_id = :school_id_param2 

ORDER BY
tbl_program_permission.page_number_prog_id ASC
    ");
$qp->execute(array(":grp_id_param2"=>$grpRow["grp_id"],":user_group_id_param2"=>$profileRow['user_group_id'],":school_id_param2"=>$profileRow['school_id']));

    while($rowPro= $qp->fetch(PDO::FETCH_OBJ)) {
?>
 <li><a href="?option=<?=$rowPro->prog_gen?>"><i class="fa fa-circle-o"></i><?=$rowPro->prog_name?></a></li>
    <?php } ?>
        </ul>
 </li>  

<?php 
    }  //close while
}
?>
