<?php
     $auth_user = new USER();
     $user_id = $_SESSION['userSession'];
     if($_SESSION['user_status']=='1'){
        
         $user_profile = $auth_user->runQuery("SELECT
         tbl_user.user_name,
         tbl_user.user_password_shows,
         tbl_user.user_prefix,
         tbl_user.user_firstname,
         tbl_user.user_lastname,
         tbl_user.user_img
         FROM
         tbl_user");
         $user_profile->execute(array(":user_id_param"=>$user_id));
         $profileRow=$user_profile->fetch(PDO::FETCH_ASSOC);
          //User Image
          if(!empty($profileRow["user_img"])){
            $pathuserimg="../images/images_user/$profileRow[user_img]";
          }else{
            $pathuserimg="../images/images_system/default-user.png";
          }
         }elseif($_SESSION['user_status']=='2'){
            $user_profile = $auth_user->runQuery("SELECT
            tbl_user.user_name,
            tbl_user.user_password_shows,
            tbl_user.user_prefix,
            tbl_user.user_firstname,
            tbl_user.user_lastname,
            tbl_user.user_email,
            tbl_user.user_img,
            tbl_user.school_id,
            tbl_user.branch_id,
            tbl_user.user_group_id, 
            tbl_user.sound_chk,
            tbl_school.school_logo,
            tbl_school.school_name,
            tbl_school.province_id
            FROM
            tbl_user , 
            tbl_school
            WHERE
            tbl_user.school_id = tbl_school.school_id AND
            tbl_user.user_id=:user_id_param");
            $user_profile->execute(array(":user_id_param"=>$user_id));
            $profileRow=$user_profile->fetch(PDO::FETCH_ASSOC);

            $school_id=$profileRow['school_id'];
            $school_province_id=$profileRow['province_id'];
            $branch_id = isset($profileRow['branch_id']) ? $profileRow['branch_id'] : NULL; 

            //User Image
            if(!empty($profileRow["user_img"])){
                $pathuserimg="../images/images_user/".$profileRow["user_img"];
              }else{
                $pathuserimg="../images/images_system/default-user.png";
              }
               //LogoSchool Image
            if(!empty($profileRow["school_logo"])){
                $pathschoolimg="../images/images_school/$profileRow[school_logo]";
              }else{
                $pathschoolimg="../images/images_system/nologo.png";
              }
    }elseif($_SESSION['user_status']=='3'){
        $user_profile = $auth_user->runQuery("SELECT
        tbl_user.user_name,
        tbl_user.user_password_shows,
        tbl_user.user_prefix,
        tbl_user.user_firstname,
        tbl_user.user_lastname,
        tbl_user.user_email,
        tbl_user.user_img,
        tbl_user.school_id,
        tbl_user.branch_id,
        tbl_user.user_group_id,       
        tbl_user.sound_chk,
        tbl_school.school_logo,
        tbl_school.school_name,
        tbl_school.province_id,
        tbl_branch.branch_name
        FROM
        tbl_user ,
        tbl_school ,
        tbl_branch
        WHERE
        tbl_user.school_id = tbl_school.school_id AND
        tbl_user.branch_id = tbl_branch.branch_id AND
        tbl_user.user_id=:user_id_param");
        $user_profile->execute(array(":user_id_param"=>$user_id));
        $profileRow=$user_profile->fetch(PDO::FETCH_ASSOC);

        $school_id=$profileRow['school_id'];
        $branch_id=$profileRow['branch_id'];
        $school_province_id=$profileRow['province_id'];

           //User Image
           if(!empty($profileRow["user_img"])){
            $pathuserimg="../images/images_user/".$profileRow["user_img"];
          }else{
            $pathuserimg="../images/images_system/default-user.png";
          }
           //LogoSchool Image
        if(!empty($profileRow["school_logo"])){
            $pathschoolimg="../images/images_school/".$profileRow["school_logo"];
          }else{
            $pathschoolimg="../images/images_system/nologo.png";
          }
    }
?>