<?php
include "connection.php";


    function getGUIDnoHash(){
            mt_srand((double)microtime()*10000);
            $charid = md5(uniqid(rand(), true));
            $c = unpack("C*",$charid);
            $c = implode("",$c);
            return substr($c,0,20);
    }

    $uid = getGUIDnoHash();
    $present_idno = $_POST['idpresented'];
    $idtype = $_POST['idtype'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lastname'];
    $initial = $_POST['middlename'];
    $birthday = $_POST['bday'];
    $gender = $_POST['sex'];
    $barangay = $_POST['barangay'];
    $contact = $_POST['contact'];
    $age = $_POST['age'];
    date_default_timezone_set('Asia/Manila');
    $appdate = date("M d, Y");

    // UPLOAD pdf 
    $pdfidpresented = $_FILES['idpresentedfile']['name'];
    $pdfregistrationform = $_FILES['registrationfile']['name'];

    $sql = "INSERT INTO tbl_register(uid, fx_idnumber, fx_idpresented, fx_firstname, fx_lastname, fx_initial, fx_gender, fd_birthdate, fx_barangay, fx_contact, fn_age, fl_idpresented, fl_form, fd_application)
    VALUES('$uid','$present_idno','$idtype',UPPER('$firstname'),UPPER('$lastname'),UPPER('$initial'),'$gender','$birthday','$barangay','$contact','$age','$pdfidpresented','$pdfregistrationform', '$appdate')";
    $result = mysqli_query($conn, $sql);

    if($result){
        $file_tmp = $_FILES['idpresentedfile']['tmp_name'];
        move_uploaded_file($file_tmp,"../registration/".$pdfidpresented);

        $file_tmp = $_FILES['registrationfile']['tmp_name'];
        move_uploaded_file($file_tmp,"../registration/".$pdfregistrationform);
        header("Location: ../register");
    }else{
        header("Location: ../register");
    }

?>