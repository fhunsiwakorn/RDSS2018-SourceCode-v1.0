<?php
           if(!isset($_GET["option"])){
            include ("user_page_1_regis_main.php");
           }else{
           switch($_GET["option"]) {
           case "main" : include ("user_page_1_regis_main.php");
           break;
        //    case "regis-step-1" : include ("user_page_1_regis_1_update.php");
        //    break;
        //    case "regis-step-2" : include ("user_page_1_regis_2.php");
        //    break;
        //    case "regis-step-3" : include ("user_page_1_regis_3.php");
        //    break;
        //    case "regis-step-4" : include ("user_page_1_regis_4_student.php");
        //    break;
        //    case "regis-step-5" : include ("user_page_1_regis_5_add_doc.php");
        //    break; 
        //    case "regis-step-6" : include ("user_page_1_regis_6_slect_subject.php");
        //    break;
        //    case "regis-step-7" : include ("user_page_1_regis_7_Exam_schedule.php");
        //    break;
        //    case "regis-step-7u" : include ("user_page_1_regis_7_Exam_schedule_edit.php");
        //    break;    
        //    case "regis-step-8" : include ("user_page_1_regis_8_preview.php");
           break; 
           case "Payment" : include ("user_page_1_regis_Payment.php");
           break; 
           case "1r1UVnf8olM" : include ("user_page_2_group_user.php");
           break;
           case "4UKiyHwBDd9" : include ("user_page_2_user_data.php");
           break;
           case "user-edit" : include ("user_page_2_user_edit.php");
           break;
           case "l4cSvlmYewP" : include ("user_page_2_permission.php");
           break;
           case "0VUI326UGYB6A1Y" : include ("user_page_3_school_detail.php");
           break;
           case "edit-sc-form-1" : include ("user_page_3_school_edit_form_1.php");
           break;
           case "edit-sc-form-2" : include ("user_page_3_school_edit_form_2.php");
           break;
           case "B4EWPVIIVWB0FVY" : include ("user_page_3_branch_data.php");
           break;
           case "edit-branch" : include ("user_page_3_branch_edit.php");
           break;
           case "YUOPKVFIRN44" : include ("user_page_3_doc_regis.php");
           break;
           case "CPECWU2RK3A9P8T" : include ("user_page_3_vehicle_data.php");
           break;
           case "AddVehicleForm" : include ("user_page_3_vehicle_form.php");
           break;
           case "VehicleEdit" : include ("user_page_3_vehicle_edit.php");
           break;  
           case "VehicleDetail" : include ("user_page_3_vehicle_detail.php");
           break;
           case "Q02RKIH9IZ386YY" : include ("user_page_3_rules.php");
           break;
           case "00O5B5OT14FP76Z" : include ("user_page_3_holiday.php");
           break;
           case "UAJDPLCUTKIIHA" : include ("user_page_4_course_data.php");
           break;
           case "course-data-edit" : include ("user_page_4_course_edit.php");
           break;
           case "course-data-detail" : include ("user_page_4_course_detail.php");
           break;
           case "form-course-step1" : include ("user_page_4_subject_in_course_step_1.php");
           break;
           case "form-course-step2" : include ("user_page_4_subject_in_course_step_2.php");
           break;
           case "BOA3OEGXK80VDL4" : include ("user_page_4_subject_data.php");
           break;
           case "subject-data-edit" : include ("user_page_4_subject_edit.php");
           break;
           case "XYTKQMM3ZK1E4GL" : include ("user_page_5_subject_permission_theory.php");
           break;
           case "MS6KUDQC770FJQF" : include ("user_page_5_table_Date_Exam.php");
           break;
           case "permission-Date-edit" : include ("user_page_5_table_Date_Exam_edit.php");
           break;
           case "AV7KO8G42H2PXDB" : include ("user_page_6_Payment.php");
           break;
           case "FS1KQBSUYBBTE90" : include ("user_page_7_trainer_data.php");
           break;
           case "AddTrainerForm" : include ("user_page_7_trainer_form.php");
           break;
           case "trainer-detail" : include ("user_page_7_trainer_detail.php");
           break;
           case "trainer-data-edit" : include ("user_page_7_trainer_edit.php");
           break;
           case "MZI4NFZ0038F41I" : include ("user_page_8_student_data.php");
           break;
           case "student-data-edit" : include ("user_page_8_student_edit.php");
           break;
           case "student-detail" : include ("user_page_8_student_detail.php");
           break;
           case "KVRCRMM1BGAPZEP" : include ("user_page_9_report_register.php");
           break;
           default : include ("user_page_1_regis_main.php");
            }
           }
           ?> 
           

           