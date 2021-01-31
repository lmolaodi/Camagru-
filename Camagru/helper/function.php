<?php
 include('connection/database.php');

function confirm_email(){
     GLOBAL $db;
     $user_email = null;
     if (isset($_POST['confirm'])){
         $code = trim($_POST['confirm_code']);
         $user_email = $_SESSION['user_email'];
         if (empty($code)){
             echo "<div>Please enter code!..</div>";
         }else {
             $query = $db->prepare("SELECT code FROM registration WHERE email =? && code =?");
             $query->execute([$user_email, $code]);
             if ($query->rowCount()==1)
             {
                 $update_code = 1;
                 $query_update = $db->prepare("UPDATE registration SET status = ? WHERE email =? && code =?");
                 $query_update->execute([$update_code, $user_email, $code]);
                 if ($query_update)
                 {
                     $_SESSION['confirmation_success'] = "Confirmation success!";
                     header("Location: index.php");
                 }else{
                     echo "could not verify";
                 }
             }else {
                 echo "invalid code!..";
             }
         }
     }
 }
 


function user_login(){
    GLOBAL $db;
    $email = null;
    if (isset($_POST['login_submit'])){
     $email = trim($_POST['email']);
     $password = trim($_POST['password']);
     if (empty($email) || empty($password)){
         echo "Please input fileds";
     }else{
         $query = $db->prepare("SELECT * registration WHERE email =?");
         $query->execute([$email]);
         if ($query->rowCount() == 1){
             $row = $query->fetch(PDO::FETCH_OBJ);
             $id = $row->id;
             $db_password = $row->password;
             $status = $row->status;
             if ($status == 0){
             $_SESSION['user_email'] = $email;
             $_SESSION['Please_confirm'] = "Please confirm your email";
             header("Location:index.php");
            }else{
             if (password_verify($password, $db_password)){
                 $_SESSION['user_id'] = $id;
                 header("Location:profile.php");
             }else{
                 echo "enter correct password";
             }
         }
     }else {
         echo "enter correct email";
     }
    }
}
}

?>