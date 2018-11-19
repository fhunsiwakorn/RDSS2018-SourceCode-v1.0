<a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <!-- The user image in the navbar-->
<img src="<?=$pathuserimg?>"  class="user-image" alt="User Image">
      <span class="username" style="font-size:18px;font-weight: bold"><?=$profileRow['user_firstname']?> <?=$profileRow['user_lastname']?>
  
      </span>
           </a>
           <ul class="dropdown-menu">
             <!-- The user image in the menu -->
             <li class="user-header">
<img src="<?=$pathuserimg?>"  class="img-circle" alt="User Image">
               <p>
              <?=$profileRow['user_firstname']?> <?=$profileRow['user_lastname']?>
               <small>
                 <?php if($_SESSION['user_status'] == "1"){
                   echo "Administrator";
                 }elseif ($_SESSION['user_status'] == "2") {
                   echo "เจ้าหน้าที่โรงเรียน ดูแลระบบทั้งหมด";
                   echo "<br>";
                   echo $profileRow["school_name"];
                 }elseif ($_SESSION['user_status'] == "3") {
                  echo "เจ้าหน้าที่ทั่วไป";
                  echo "<br>";
                  echo $profileRow["school_name"];
                  echo "<br>";
                  //echo "&nbsp;";
                  echo $profileRow["branch_name"];
                }
                 ?>

               </small>
               </p>
             </li>

             <li class="user-footer">
               <!-- <div class="pull-left">
                 <a href="#" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
               </div> -->

                 <a href="../login/logout.php?logout=true" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-log-out"></i> ออกจากระบบ</a>

             </li>
           </ul>
