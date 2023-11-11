<?php

class MyApp{

static  $url = "admin_section";
static  $perpage = 9;

public static function protect() {
    if(!isset($_SESSION['adminid'])){
        MyApp::notifyurl("Login","login.php?page=".basename($_SERVER["PHP_SELF"]));
        exit();
    }
}

public static function getNewOldStatus($connect,$from,$to,$patientid){
    $patientdata = MyApp::getdata($connect,"patient","id",$patientid);
    if($patientdata['date']>=$from){
        return "<span style='color:green;'>New patient</span>";
    }
    else{
        return "<span style='color:red;'>Old patient</span>";
    }
}

public static function calculateAge($birthDate){
    $bday = new DateTime($birthDate); // Your date of birth
    $today = new Datetime(date("Y-m-d"));
    $diff = $today->diff($bday);
    if($diff->y>0){
    return $diff->y." Years";
    }else{
        return $diff->m." Months";
    }
}
public static function calculateAgeFromDate($birthDate,$today){
    $bday = new DateTime($birthDate); // Your date of birth
    $today = new Datetime($today);
    $diff = $today->diff($bday);
    if($diff->y>0){
        return $diff->y." Years";
        }else{
            return $diff->m." Months";
        }
}


public static function chargePatient($connect,$patientid,$amount,$description,$category){
    $sdate = date("Y-m-d");
    $description = MyApp::cleantext($connect,$description);
    mysqli_query($connect,"insert into bill values(null,'$patientid','$amount','$description','$category','$sdate','$_SESSION[adminid]')") or die(mysqli_error($connect));
}

public static function checkAdmitted($connect,$patientid){
    $chk = mysqli_num_rows(mysqli_query($connect,"select * from ward_patient where patientid='$patientid' and checkoutdate is null"));
    if($chk>0){
        return true;
    }
    else{
        return false;
    }

}

public static function checkDetain($connect,$patientid){
    $chk = mysqli_num_rows(mysqli_query($connect,"select * from detain where patientid='$patientid' and checkoutdate is null"));
    if($chk>0){
        return true;
    }
    else{
        return false;
    }

}

public static function loadPatientReal($connect,$connectlab,$patientid,$type,$consultid){
    if($type=="test"){
        $output = "";
        $count = 1;
        $exe  = mysqli_query($connect,"select * from consultation_test where patientid='$patientid' and consultid='$consultid'");
        while ($data = mysqli_fetch_assoc($exe)){
            $name = MyApp::getdata($connectlab,"labtest","id",$data['testid'])['testname'];
            
            $output.="
            <tr>
            <td>$count</td>
            <td>$name</td>
            <td><a style='cursor: pointer;padding:2px;' onclick='deletetest(\"$data[id]\",\"con\",\"$consultid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
            </tr>";
            $count++;
        }
       return $output;
    }
    else if($type=="treatment"){
        $output = "";
        $count = 1;
        $exe  = mysqli_query($connect,"select * from consultation_treatment where patientid='$patientid' and consultid='$consultid'");
        while ($data = mysqli_fetch_assoc($exe)){
            $name = $data['barcode'];
            
            $output.="
            <tr>
            <td>$count</td>
            <td>$name</td>
            <td><a style='cursor: pointer;padding:2px;' onclick='deletetreatment(\"$data[id]\",\"con\",\"$consultid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
            </tr>";
            $count++;
        }
       return $output;
    }
    else if($type == "finding"){
        $output = "";
        $count = 1;
        $exe  = mysqli_query($connect,"select * from consultation_finding where patientid='$patientid' and consultid='$consultid'");
        while ($data = mysqli_fetch_assoc($exe)){
          
            $output.="
            <tr>
            <td>$count</td>
            <td>$data[entry]</td>
            <td>$data[status]</td>
            <td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"finding\",\"$consultid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
            </tr>";
            $count++;
        }
       return $output;
    }
    else if($type == "odq"){
        $output = "";
        $count = 1;
        $exe  = mysqli_query($connect,"select * from consultation_odq where patientid='$patientid' and consultid='$consultid'");
        while ($data = mysqli_fetch_assoc($exe)){
          
            $output.="
            <tr>
            <td>$count</td>
            <td>$data[entry]</td>
            <td>$data[status]</td>
            <td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"odq\",\"$consultid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
            </tr>";
            $count++;
        }
       return $output;
    }
    }

    public static function loadTreatmentsheetDetention($connect,$patientid,$treatmentid){
        if(empty($treatmentid)){
        $output="";
        $exe = mysqli_query($connect,"select * from treatmentsheet_detention_med_draft where patientid='$patientid'");
        while($data = mysqli_fetch_assoc($exe)){
            $output.="
            <tr>
            <td>$data[drug]</td>
            <td>$data[nextperiod]</td>
            <td>$data[remark]</td>
            <td><td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"treatmentsheetdetention\",\"\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td></td>
            </tr>
            
            ";
        }
        }
        else{
            $output="";
            $exe = mysqli_query($connect,"select * from treatmentsheet_detention_med where treatmentid='$treatmentid' and status='0'");
            while($data = mysqli_fetch_assoc($exe)){
                $output.="
                <tr>
                <td>$data[drug]</td>
                <td>$data[nextperiod]</td>
                <td>$data[remark]</td>
                <td><td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"treatmentsheetdetention\",\"$treatmentid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td></td>
                </tr>
                
                ";
            }
            
        }
    return $output;
    }

public static function loadTreatmentsheet($connect,$patientid,$treatmentid){
    if(empty($treatmentid)){
    $output="";
    $exe = mysqli_query($connect,"select * from treatmentsheet_med_draft where patientid='$patientid'");
    while($data = mysqli_fetch_assoc($exe)){
        $output.="
        <tr>
        <td>$data[drug]</td>
        <td>$data[nextperiod]</td>
        <td>$data[remark]</td>
        <td><td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"treatmentsheet\",\"\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td></td>
        </tr>
        
        ";
    }
    }
    else{
        $output="";
        $exe = mysqli_query($connect,"select * from treatmentsheet_med where treatmentid='$treatmentid' and status='0'");
        while($data = mysqli_fetch_assoc($exe)){
            $output.="
            <tr>
            <td>$data[drug]</td>
            <td>$data[nextperiod]</td>
            <td>$data[remark]</td>
            <td><td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"treatmentsheet\",\"$treatmentid\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td></td>
            </tr>
            
            ";
        }
        
    }
return $output;
}
public static function loadPatientDraft($connect,$connectlab,$patientid,$type){
if($type=="test"){
    $output = "";
    $count = 1;
    $exe  = mysqli_query($connect,"select * from consultation_test_draft where patientid='$patientid'");
    while ($data = mysqli_fetch_assoc($exe)){
        $name = MyApp::getdata($connectlab,"labtest","id",$data['testid'])['testname'];
        
        $output.="
        <tr>
        <td>$count</td>
        <td>$name</td>
        <td><a style='cursor: pointer;padding:2px;' onclick='deletetest(\"$data[id]\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
        </tr>";
        $count++;
    }
   return $output;
}
else if($type=="treatment"){
    $output = "";
    $count = 1;
    $exe  = mysqli_query($connect,"select * from consultation_treatment_draft where patientid='$patientid'");
    while ($data = mysqli_fetch_assoc($exe)){
        $name = $data['barcode'];
        
        $output.="
        <tr>
        <td>$count</td>
        <td>$name</td>
        <td><a style='cursor: pointer;padding:2px;' onclick='deletetreatment(\"$data[id]\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
        </tr>";
        $count++;
    }
   return $output;
}
else if($type=="finding"){
    $output = "";
    $count = 1;
    $exe  = mysqli_query($connect,"select * from consultation_finding_draft where patientid='$patientid'");
    while ($data = mysqli_fetch_assoc($exe)){
      
        $output.="
        <tr>
        <td>$count</td>
        <td>$data[entry]</td>
        <td>$data[status]</td>
        <td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"finding\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
        </tr>";
        $count++;
    }
   return $output;
}
else if($type=="odq"){
    $output = "";
    $count = 1;
    $exe  = mysqli_query($connect,"select * from consultation_odq_draft where patientid='$patientid'");
    while ($data = mysqli_fetch_assoc($exe)){
      
        $output.="
        <tr>
        <td>$count</td>
        <td>$data[entry]</td>
        <td>$data[status]</td>
        <td><a style='cursor: pointer;padding:2px;' onclick='deleteitem(\"$data[id]\",\"odq\");' class='btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></a></td>
        </tr>";
        $count++;
    }
   return $output;
}

}


public static function tolog($value){
    $value = implode(",",$value);
    return $value;
}






public static function logg($connect,$text){
    mysqli_query($connect,"insert into log value('$_SESSION[adminid]  $text',now())");
}

public static function getCharges($connect){
    return mysqli_fetch_assoc(mysqli_query($connect,"select * from setting"));
}

public static function calculatedaydiff($dateOfBirth){
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $x = $diff->format('%d');
    if($x+0==0)
    {
        $x = 1;
    }
    return $x;
   
}

public static function showtext($text){
    return ucwords(strtolower($text));
}



public static function showmoney($connect,$amount){
    return  MyApp::getsetting($connect)['currency']." ".number_format($amount,2);
}



public static function lastreg($connect){
    $data  = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM registration order by fulltime desc"));
    echo $data["fulltime"];
}
public static function checkCleared($connect,$section,$year){
$chk = mysqli_num_rows(mysqli_query($connect,"select * from paymentvoucher where section='$section' and year='$year' and id  in (select id from pvdraft where year='$year')"));
if($chk > 0){
return false;
}else{
 return   true;
}
}
public static function  sendemail($useremail,$message,$email,$subject){
    $email->ClearAllRecipients();
    $email->IsSMTP();
    $email->SMTPAuth = true;
    $email->Host = 'smtp.gmail.com';
    $email->Port = 587;
    $email->CharSet = 'UTF-8';
    //$email->SMTPDebug = 3;
    $email->Username='arispattechnologies4@gmail.com';
    $email->Password ="Arispatbulk21";
    $email->SMTPSecure = 'tls';
    $email->SetFrom      = "admin@healthysharwamma.com";
    $email->FromName  = 'Healthy Shawarma';
    $email->Subject   = "$subject";
    $email->Body      = '<html><head><body>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <style type="text/css">
            a[x-apple-data-detectors] {color: inherit !important;}
        </style>
    
    </head>
    <body style="margin: 0; padding: 0;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 20px 0 30px 0;">
    
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid white;">
        <tr>
            <td align="center" bgcolor="#065772" style="padding: 40px 0 30px 0;">
                <img src="https://healthysharwamma.com/logo.png" alt="Logo." width="150" height="100" style="display: block;" />
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td style="color: #153643; font-family: Arial, sans-serif;">
                            '.$message.'
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                        
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#065772" style="padding: 30px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                            <p style="margin: 0;">&reg;  <a style="color: #ffffff" href="https://healthysharwamma.com/">Healthy Sharwama</a></p>
                        </td>
                        <td align="right">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
                </td>
            </tr>
        </table>
    </body>
    </html>
    </body></html>';
    $email->isHTML(true);
     $email->AddAddress($useremail);
    $email->Send();
    }
    public static function roundToNextHour($dateString) {
        $date = new DateTime($dateString);
        $minutes = $date->format('i');
        if ($minutes > 0) {
            $date->modify("+1 hour");
            $date->modify('-'.$minutes.' minutes');
        }
        return $date->format("Y-m-d H:i:s");
    }
public static function uploadimage($file,$folder,array $allowed){
    $name = $file['name'];
    $type = explode(".",$name);
    $type  = strtolower(end($type));
    $location = $file['tmp_name'];
    $path = $folder."/".substr(md5(time()),0,10).".".$type;
    if(in_array($type,$allowed)){
      if(move_uploaded_file($location,$path)){
        return $path;
      }
      else{
        MyApp::notify("Error uploading image");
        return "";
      }

    }
    else{
        MyApp::notify('Invalid file type');
        return "";
    }
}

public static function genNumbering($total,$perpage,$currentpage){
    $toret = "";
   
    $totalpage = round($total / $perpage);
    if($currentpage>1){
        $params = array_merge( $_GET, array( 'currentpage' => ($currentpage-1) ) );
        $new_query_string = http_build_query( $params );
        $toret.="<a href='?$new_query_string' class=''>&laquo</a>";
        }
    $params = array_merge( $_GET, array( 'test' => 'testvalue' ) );
    $new_query_string = http_build_query( $params );
    for($i = 1;$i<=$totalpage;$i++){
        if($i == $currentpage){
           $active  ="active"; 
        }
        else{
            $active="";
        }
        
    $params = array_merge( $_GET, array( 'currentpage' => ($i) ) );
    $new_query_string = http_build_query( $params );
    $toret.="<a href='?$new_query_string' class='$active'>$i</a>";        
    }
    if($currentpage<$totalpage){
        $params = array_merge( $_GET, array( 'currentpage' => ($currentpage+1) ) );
        $new_query_string = http_build_query( $params );
        $toret.="<a href='?$new_query_string' class=''>&raquo;</a>";     
    }

    echo $toret;
    
}


public static function insertvalue($connect, $table,array $values,$is_first_AI){
    if($is_first_AI){
        $values = "NULL,'".implode("','",$values)."'";
    }else{
    $values = "'".implode("','",$values)."'";
    }
    $q = mysqli_query($connect,"insert into $table values($values)") or die(mysqli_error($connect));
    MyApp::getq($q);

}
public static function insertvaluenoq($connect, $table,array $values,$is_first_AI){
    if($is_first_AI){
        $values = "NULL,'".implode("','",$values)."'";
    }else{
    $values = "'".implode("','",$values)."'";
    }
    $q = mysqli_query($connect,"insert into $table values($values)") or die(mysqli_error($connect));
   

}
public static function updatevalue($connect, $table,array $values,array $key){
    $parse = array();
    $keys = array_keys($values);
    $value = array_values($values);
    for($i=0;$i<sizeof($values);$i++){
        $parse[] =$keys[$i]."='".$value[$i]."'";
    }
    $parse = implode(",",$parse);
    $q = mysqli_query($connect,"update $table set $parse where ".array_keys($key)[0]."='".array_values($key)[0]."'") or die(mysqli_error($connect));
    MyApp::getq($q);

}
public static function insertvalueurl($connect, $table,array $values,$is_first_AI,$url){
    if($is_first_AI){
        $values = "NULL,'".implode("','",$values)."'";
    }else{
    $values = "'".implode("','",$values)."'";
    }
    $values = str_replace("'NULL'","NULL",$values);
    $q = mysqli_query($connect,"insert into $table values($values)") or die(mysqli_error($connect));
    MyApp::getqurl($q,$url);

}

public static function generatePatientId($connect){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from memory"));
    $lastid = $data['lastid'];
    $newid = $lastid + 1;
    //mysqli_query($connect,"update memory set lastid='$newid'");
    $newid = str_pad($newid,4,"0",STR_PAD_LEFT);
    return $newid;
}

public static function cleantext($connect,$text){
    $text = trim($text);
    $text = mysqli_real_escape_string($connect,$text);
    $text = strip_tags($text);
    $text = urldecode($text);
    return $text;
}



public static function cleantextii($connect,$text){
    $text = trim($text);
    $text = mysqli_real_escape_string($connect,$text);
    
    return $text;
}

public static function cleanurl($connect,$text){
    $text = trim($text);
    $text = strip_tags($text);
    $text = urlencode($text);
    return $text;
}

public static function checkrole($connect,$userid,$role){
   $chk = mysqli_num_rows(mysqli_query($connect,"select * from role_user where username='$userid' and role='$role'"));
   if($chk>0){
       return true;
   }
   else{
       return false;
   }
   
}

public static function getsetting($connect){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from setting"));
    return $data;
}

public static function checkrate($main,$key){
    if(strtolower($key) ==strtolower($main)){
        return "checked";
    }
    else{
        return "";
    }
}

public static function fetchcount($connect,$table,$column,$value){
    if($column == null || $column =="" || empty($column)){
       return mysqli_num_rows(mysqli_query($connect,"select * from $table"));
    }
    else{
        return MyApp::checkcount($connect,$table,$column,$value);
    }
}

public static function deleteitem($connect,$table,$column,$value){
    $value = MyApp::cleantext($connect,$value);
    $q = mysqli_query($connect,"delete from $table where $column='$value'");
    if(mysqli_affected_rows($connect)>0){
        MyApp::notify("Operation successfull");
    }
}
public static function deleteitemnoq($connect,$table,$column,$value){
    $value = MyApp::cleantext($connect,$value);
    $q = mysqli_query($connect,"delete from $table where $column='$value'");
    return $q;
}
public static function deleteitemurl($connect,$table,$column,$value,$url){
    $value = MyApp::cleantext($connect,$value);
    $q = mysqli_query($connect,"delete from $table where $column='$value'");
    MyApp::getqurl($q,$url);
}

public static function getuserdetail($connect,$userid){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from registration where email='$userid'"));
    return $data;
}

public static function getDeliveryStatus($status){
    $status = strtolower($status);
    $toret = "";
    if($status == "0"){
    $toret = "Not delivered";
    }
    else if($status == "1"){
        $toret = "Delivered";
    }
    return $toret;
}
public static function getProductDetail($connect,$productid){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from product where id='$productid'"));
    return $data;
}
public static function getdata($connect,$table,$column,$value){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from $table where $column='$value'"));
    return $data;
}
public static function getorderdata($connect,$orderid){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from order_list where orderid='$orderid'"));
    return $data;
}
public static function checkcount($connect,$table,$column,$value){
$chk = mysqli_num_rows(mysqli_query($connect,"select * from $table where $column='$value'"));
return $chk;
}
public static function notify($text){
    echo "<script>alert('$text');</script>";
}
public static function notifyurl($text,$url){
    echo "<script>alert('$text');window.location.href='$url';</script>";
}

public static function redirect($location){
    echo "<script>window.location.href='$location';</script>";
}

public static function getq($q){
    if($q){
        MyApp::notify("Operation successfull");
    }
    else{
        MyApp::notify("Error, try again");
    }
}
public static function getqurl($q,$url){
    if($q){
        MyApp::notifyurl("Operation successfull",$url);
    }
    else{
        MyApp::notify("Error, try again");
    }
}

public static function countorder($connect,$date){
    $chk = mysqli_num_rows(mysqli_query($connect, "SELECT  * from order_list where date='$date'"));
    return $chk;
}

public static function fetchallrecord($connect,$table,array $arr,$isoption){

    $data = "";
    $item = $arr[0];
    $exe = mysqli_query($connect,"select * from $table ");
    if(!$isoption){
    while ($row = mysqli_fetch_assoc($exe)){
        $data .=  "<tr>";
        for($i = 0; $i <sizeof($arr); $i++){
            $data .= "<td>".$row[$arr[$i]]."</td>";
        }
        $data.=  "</tr>";
    }
    }
    else{
        if(sizeof($arr)>1){
            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option value='".$row[$arr[0]]."'>".$row[$arr[1]]."</option>";
            }
        }
        else{
            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option>".$row[$arr[0]]."</option>";
            }
        }
        
    }
    return $data;
}
public static function fetchassignsection($connect,$user){

    $data = "";
    $exe = mysqli_query($connect,"select * from usersection where user='$user'");

            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option>".$row['section']."</option>";
            }
        
        
    
    return $data;
}
public static function verifysectionaccess($connect,$user,$section){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from usersection where user='$user'  and section='$section'"));
    if(!empty($data)){
        return true;
    }
    else{
        return false;
    }

}

public static function candownload($connect,$pvid){
    $chk = mysqli_num_rows(mysqli_query($connect,"select * from approval where pvid='$pvid'"));
    if($chk>0){
        return true;
    }
    else{
        return false;
    }
}

public static function verifybudgetmodification($connect,$year){
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select * from event where category='Begin budget' and accountyear='$year'"));
    $edata = mysqli_fetch_assoc(mysqli_query($connect,"select * from event where category='End budget' and accountyear='$year'"));
    if(!empty($data) && empty($edata)){
        return true;
    }
    else{
        return false;
    }

}

public static function saveaallocationamount($connect,$section,$year,$account,$amount){
    $date = date('Y-m-d H:i:s');
    $section = MyApp::cleantext($connect,$section);
    $account = MyApp::cleantext($connect,$account);
    $user  = $_SESSION['adminid'];
    $chk = mysqli_num_rows(mysqli_query($connect,"select * from budget where section='$section' and year='$year' and account='$account'"));
    if($chk==0){
        mysqli_query($connect,"insert into budget values('$section','$account','$amount','$year','$date','$user')") or die(mysqli_error($connect));
    }
    else{
        mysqli_query($connect,"update budget set amount ='$amount',user='$user' where section='$section' and account='$account' and year='$year'");
    }
}
public static function loadbudgetamount($section,$account,$year,$connect){
    $data = "";
    $data = mysqli_fetch_assoc(mysqli_query($connect,"select amount from budget where section='$section' and account='$account' and year='$year'"));
    return $data['amount'];
}
public static function fetchaccountyear($connect){

    $data = "";
    $exe = mysqli_query($connect,"select * from accountyear");

            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option>".$row['year']."</option>";
            }
        
        
    
    return $data;
}
public static function fetchallrecordwithkey($connect,$table,array $arr,$isoption,$column,$value){

    $data = "";
    $exe = mysqli_query($connect,"select * from $table  where $column='$value'");
    if(!$isoption){
    while ($row = mysqli_fetch_assoc($exe)){
        $data .=  "<tr>";
        for($i = 0; $i <sizeof($arr); $i++){
            $data .= "<td>".$row[$arr[$i]]."</td>";
        }
        $data.=  "</tr>";
    }
    }
    else{
        if(sizeof($arr)>1){
            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option value='".$row[$arr[0]]."'>".$row[$arr[1]]."</option>";
            }
        }
        else{
            while ($row = mysqli_fetch_assoc($exe)){
                $data .=  "<option>".$row[$arr[0]]."</option>";
            }
        }
        
    }
    return $data;
}

public static function fetchallrecordwithdelete($connect,$table,array $arr,$showfirst){
    $data = "";
    $exe = mysqli_query($connect,"select * from $table");
    while ($row = mysqli_fetch_assoc($exe)){
        $data .=  "<tr>";
        for($i = 0; $i <sizeof($arr); $i++){
            if(!$showfirst && $i==0){

            }else{ 
            $data .= "<td>".$row[$arr[$i]]."</td>";
            }
        }
        $data.="<td><a onclick='return confirm(\"confirm delete\");' class='btn btn-danger btn-sm' href='?delete=".$row[$arr[0]]."'>x</a></td>";
        $data.=  "</tr>";
    }
    return $data;
}

public static function fetchallrecordwitheditandspecial($connect,$table,array $arr,$showfirst,$page,$action){
    $data = "";
    $exe = mysqli_query($connect,"select * from $table");
    while ($row = mysqli_fetch_assoc($exe)){
        $data .=  "<tr>";
        for($i = 0; $i <sizeof($arr); $i++){
            if(!$showfirst && $i==0){

            }else{ 
            $data .= "<td>".MyApp::showtext($row[$arr[$i]])."</td>";
            }
        }
        $data.="<td><a onclick='return confirm(\"confirm delete\");' class='btn btn-danger btn-sm' href='?delete=".$row[$arr[0]]."'>x</a></td>";
        $data.="<td><a onclick='return confirm(\"confirm edit\");' class='btn btn-warning btn-sm' href='$page?edit=".$row[$arr[0]]."'>edit</a></td>";
        $data.="<td><a onclick='return confirm(\"confirm $action\");' class='btn btn-warning btn-sm' href='?special=".$row[$arr[0]]."'>$action</a></td>";
        $data.=  "</tr>";
    }
    return $data;
}

public static function fetchallrecordwithedit($connect,$table,array $arr,$showfirst,$page){
    $data = "";
    $exe = mysqli_query($connect,"select * from $table");
    while ($row = mysqli_fetch_assoc($exe)){
        $data .=  "<tr>";
        for($i = 0; $i <sizeof($arr); $i++){
            if(!$showfirst && $i==0){

            }else{ 
            $data .= "<td>".MyApp::showtext($row[$arr[$i]])."</td>";
            }
        }
        $data.="<td><a onclick='return confirm(\"confirm delete\");' class='btn btn-danger btn-sm' href='?delete=".$row[$arr[0]]."'>x</a></td>";
        $data.="<td><a onclick='return confirm(\"confirm edit\");' class='btn btn-warning btn-sm' href='$page?edit=".$row[$arr[0]]."'>edit</a></td>";
        $data.=  "</tr>";
    }
    return $data;
}


public static function getimage($file){
    return MyApp::$url."/".$file;
}
}
