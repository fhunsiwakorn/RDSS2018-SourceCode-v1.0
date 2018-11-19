<?php
$user_group_id = isset($_POST['user_group_id']) ? $_POST['user_group_id'] : NULL; 

?>
<form method="post" id="form_permission"  name="form_permission" >
<input type="hidden" name="user_group_id" id="user_group_id" value="<?=$user_group_id?>">

 
    <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>
<div class="checkbox">
<label style="font-size: 1em">
<INPUT type="checkbox" onchange="checkAll_d1(this.form.pNUM)" name="chk_all_user" />
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
</div>
        </th>
        <th>ไอคอนโปรแกรม</th>
        <th>เมนูหลัก</th>
        <th>เมนูย่อย</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_program_group.grp_id,
tbl_program_group.grp_icon,
tbl_program_group.gp_name,
tbl_program_sub.prog_id,
tbl_program_sub.prog_name
FROM
tbl_program_group ,
tbl_program_sub
WHERE
tbl_program_group.grp_id = tbl_program_sub.grp_id AND
tbl_program_group.grp_status = '1' AND
tbl_program_group.is_delete = '1' AND
tbl_program_sub.prog_status = '1' AND
tbl_program_sub.is_delete = '1'
ORDER BY
tbl_program_group.grp_id ASC,tbl_program_sub.prog_id ASC
");
$qg->execute();
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;

// ตรวจสอบว่ามีการเลือกโปรแกรมนี้หรือยัง
//$chkprogramRows = $qGeneral->rowsQuery("SELECT permission_id FROM tbl_program_permission WHERE user_group_id='$user_group_id' AND grp_id='$rowGen->grp_id' AND prog_id='$rowGen->prog_id' AND  school_id='$school_id'");
$stmt = $qGeneral->runQuery("SELECT user_group_id,grp_id,prog_id FROM tbl_program_permission WHERE user_group_id=:user_group_id_param AND grp_id=:grp_id_param AND prog_id=:prog_id_param AND school_id=:school_id_param");
$stmt->execute(array(":user_group_id_param"=>$user_group_id,":grp_id_param"=>$rowGen->grp_id,":prog_id_param"=>$rowGen->prog_id,":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
      <tr>
      <td align="center">

<div class="checkbox">
<label style="font-size: 1em">
<!-- รวม grp_id และ prog_id ไว้ด้วยกัน -->

<input <?php if($dataRow['grp_id']==$rowGen->grp_id && $dataRow['prog_id']==$rowGen->prog_id){echo "checked";} ?> type="checkbox"  name="ADDpermission_id[]" id="pNUM"  value="<?=$rowGen->grp_id?>.<?=$rowGen->prog_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>

</div>

</td>
<td align="center"> <img  src="../images/image_program/<?=$rowGen->grp_icon?>" alt="<?=$rowGen->grp_icon?>" width="30" height="30"/>
        </td>
        <td><?=$rowGen->gp_name?></td>
        <td><?=$rowGen->prog_name?></td>
    
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>ไอคอนโปรแกรม</th>
      <th>เมนูหลัก</th>
      <th>เมนูย่อย</th>
      </tr>
      </tfoot>
    </table>

    <div class="form-group"> 
<center><button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button> </center>
 
</div>  
    </form>