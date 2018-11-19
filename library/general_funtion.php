<?php
$date_default=date("Y-m-d");
///สร้างรหัส
function random_password($max_length = 20){
    $text = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $text_length = mb_strlen($text, 'UTF-8');
    $pass = '';
    for($i=0;$i<$max_length;$i++){
    $pass .= @$text[rand(0, $text_length)];
    }
    return $pass;
    } 

function DateThai($strDate)
    {
        if($strDate=="0000-00-00"){
            return "-";
        }else{
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
            $strHour= date("H",strtotime($strDate));
            $strMinute= date("i",strtotime($strDate));
            $strSeconds= date("s",strtotime($strDate));
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }
    
    }
function DateThai_2($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }
   
    function DateThai_full($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "วันที่ $strDay $strMonthThai พ.ศ. $strYear";
    }
    function DateThai_full2($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "วันที่ $strDay $strMonthThai พ.ศ. $strYear เวลา  $strHour:$strMinute";
    }

    function DateDiff($strDate1,$strDate2)
    {
               return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
    }
    function TimeDiff($strTime1,$strTime2)
    {
               return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
    }
    function DateTimeDiff($strDateTime1,$strDateTime2)
    {
               return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
    }

   //  echo "Date Diff = ".DateDiff("2008-08-01","2008-08-31")."<br>";
   //  echo "Time Diff = ".TimeDiff("00:00","19:00")."<br>";
   //  echo "Date Time Diff = ".DateTimeDiff("2008-08-01 00:00","2008-08-01 19:00")."<br>";
   function DateTimetotime($sendDate1){ 
    ///2018-03-19 00:00:00
 $arrstartx2=explode(" ",$sendDate1);
 $sdate=$arrstartx2[0]; //วัน
 $stime=$arrstartx2[1]; ///เวลา
// กรองว H:i:s;
$arrst=explode(":",$stime);
$h=$arrst[0];
$i=$arrst[1];
$s=$arrst[2];
$sxtime="$h:$i";
return $sxtime;
    }


   function DatetoYMD($sendDate1){ 
    ///2018-03-19
    $arrstartx2=explode("/",$sendDate1);
 $stday2=$arrstartx2[0];
 $stmonth2=$arrstartx2[1];
 $styear2=$arrstartx2[2];
$udhd_affter="$styear2-$stmonth2-$stday2";
return $udhd_affter;
    }


function DatetoDMY($sendDate2){ 
    // 10/05/2018
$arrstartx=explode("-",$sendDate2);
$stday=$arrstartx[0];
$stmonth=$arrstartx[1];
$styear=$arrstartx[2];
$udhd_before="$styear/$stmonth/$stday";
return $udhd_before;
}


function duration($begin,$end){
    $remain=intval(strtotime($end)-strtotime($begin));
    $wan=floor($remain/86400);
    $l_wan=$remain%86400;
    $hour=floor($l_wan/3600);
    $l_hour=$l_wan%3600;
    $minute=floor($l_hour/60);
    $second=$l_hour%60;
    // return "ผ่านมาแล้ว ".$wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ".$second." วินาที";

return "$minute"." นาที";
}

function duration2($begin,$end){
    $remain=intval(strtotime($end)-strtotime($begin));
    $wan=floor($remain/86400);
    $l_wan=$remain%86400;
    $hour=floor($l_wan/3600);
    $l_hour=$l_wan%3600;
    $minute=floor($l_hour/60);
    $second=$l_hour%60;
    // return "ผ่านมาแล้ว ".$wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ".$second." วินาที";

// if($minute < 3600){
   
//     return "$hour"." ชั่วโมง";
// }elseif($minute >=61){
//     return "$minute"." นาที";
// }    

return "$hour"." ชั่วโมง";
}

function duration3($begin,$end){
    $remain=intval(strtotime($end)-strtotime($begin));
    $wan=floor($remain/86400);
    $l_wan=$remain%86400;
    $hour=floor($l_wan/3600);
    $l_hour=$l_wan%3600;
    $minute=floor($l_hour/60);
    $second=$l_hour%60;
    // return "ผ่านมาแล้ว ".$wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ".$second." วินาที";

// if($minute < 3600){
   
//     return "$hour"." ชั่วโมง";
// }elseif($minute >=61){
//     return "$minute"." นาที";
// }    

return "$wan"." วัน";
}

///เพิ่มรูปภาพแบบ Resize
function add_images($tmp_name,$name,$pathimg){
    // $imageupload = $_FILES['imageupload']['tmp_name'];
    // $imageupload_name = $_FILES['imageupload']['name'];
    $imageupload =$tmp_name;
    $imageupload_name = $name;
    $arraypic = explode(".",$imageupload_name);
    $filename = $arraypic[0];//ชื่อไฟล์
    $filetype = $arraypic[1];//นามสกุลไฟล์
    if($filetype=="gif" || $filetype=="jpg"||$filetype=="jpeg"|| $filetype=="png"||  $filetype=="JPG" ||  $filetype=="PNG" ){  ////ตรวจสอบระเภทรูปภาพ
    $newimage = random_password(6).".".$filetype;  ////Randomชื่อรูปภาพ
    copy($imageupload,"$pathimg".$newimage); //อัพโหลดไปยัง folder
    ///Resize รูปภาพ
    $width=600; //*** Fix Width & Heigh (Autu caculate) ***//
    $size=GetimageSize($imageupload);
    $height=round($width*$size[1]/$size[0]);
    // $images_orig = ImageCreateFromJPEG($imageupload); 
    //$images_orig = imagecreatefrompng($imageupload);
    if($filetype=="jpg"||$filetype=="jpeg" || $filetype=="JPG"){ $images_orig = ImageCreateFromJPEG($imageupload);  
    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
    ImageJPEG($images_fin,"$pathimg".$newimage);
    ImageDestroy($images_orig);
    ImageDestroy($images_fin);
}
    return  $newimage;
        }

}

///คำนวนอายุ
function cal_age($birthday,$today){
    list($byear, $bmonth, $bday)= explode("-",$birthday);       //จุดต้องเปลี่ยน
    list($tyear, $tmonth, $tday)= explode("-",$today);                //จุดต้องเปลี่ยน   
    $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
    $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
    $mage = ($mnow - $mbirthday);
    $u_y=date("Y", $mage)-1970;
    $u_m=date("m",$mage)-1;
    $u_d=date("d",$mage)-1;
    return  $u_y; 

}

///ลบไฟล์
function delfile($namefile,$pathfile){
    $del_img_file="$pathfile"."/"."$namefile";
    @unlink($del_img_file);
    return  $del_img_file;
}

// แปลงตัวเลข เป็นข้อความตัวอักษร ภาษาไทย
function num2wordsThai($num){   
    $num=str_replace(",","",$num);
    $num_decimal=explode(".",$num);
    $num=$num_decimal[0];
    $returnNumWord;   
    $lenNumber=strlen($num);   
    $lenNumber2=$lenNumber-1;   
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
    $kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="ยี่";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="สอง";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";   
                }   
            }   
        }   
        if($kaNumWord[$i]==0){   
            if($i!=6){
                $kaGroup[$i]="";   
            }
        }   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
    }      
    if(isset($num_decimal[1])){
        $returnNumWord.="จุด";
        for($i=0;$i<strlen($num_decimal[1]);$i++){
                $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];  
        }
    }       
    return $returnNumWord;   
} 
// echo num2wordsThai("25010");
// echo "<br>";
// สองหมื่นห้าพันสิบ
 
// การใช้งาน รองรับตัวเลขมี comma 
// echo num2wordsThai("1,450");
// echo "<br>";
// หนึ่งพันสี่ร้อยห้าสิบ
 
// รองรับ จุดทศนิยม  
// echo num2wordsThai("250.10");
// echo "<br>";
// สองร้อยห้าสิบจุดหนึ่งศูนย์
 
//รองรับค่าตัวเลข มากกว่าแสนล้าน
// echo num2wordsThai("500,001,001,000.10");
// echo "<br>";
// ห้าแสนหนึ่งล้านหนึ่งพันจุดหนึ่งศูนย์