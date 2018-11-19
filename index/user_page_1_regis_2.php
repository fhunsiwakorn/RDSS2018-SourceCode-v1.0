<?php
// ถ้าเป็นครู
if($trainer_idmx !=0){
  include ("user_page_1_regis_2.1.php");
}
///ถ้าเป็นช่วงเวลา
elseif($trainer_idmx ==0 || $trainer_idmx <=0){
  include ("user_page_1_regis_2.2.php");
}
