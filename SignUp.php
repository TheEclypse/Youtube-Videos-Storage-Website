<?php
include ('smarty-master/libs/Smarty.class.php');
$sm = new Smarty;

if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
    $sm->assign('error','');
    $sm->assign('username','');
    $sm->assign('fn','');
    $sm->assign('ln','');
    $sm->display('SignUp.html');
}

$user = "accounts.txt";
$file = fopen($user,"a+");
$e = file_get_contents($user);
$z = explode(",",$e);

// $user1 = "username.txt";
// $file1 = fopen($user1,"a+");
// $e1 = file_get_contents($user1);
// $z1 = explode(",",$e1);


if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $us = $_POST['username'];
    $fnn = $_POST['fn'];
    $lnn = $_POST['ln'];
    $pass = $_POST['password'];
    $comb  = "$us,$fnn,$lnn,$pass, \n";

    if (login($us,$fnn,$lnn,$pass) == false) 
    {
        // echo "<h1 style='text-align:center;'>You have signed up.</h1>";
        fwrite($file,$comb);
        // $filename = "users/$us.php";
        // $filecreate = fopen($filename,"w");
        // $fileget = file_get_contents("formatpt1.php");
        // $fileget2 = file_get_contents("formatpt2.php");
        // fwrite($filecreate,$fileget);
        // fwrite($filecreate,"<h1>Welcome, $us</h1>\n");
        // fwrite($filecreate,$fileget2);
        // fclose($filecreate);
        // header('Location: '.$filename);
        $nourl = "SignedUp.php";
        header('Location: '.$nourl);
        $am = fopen("vidnumber.txt","a+");
        fwrite($am,"$us,0,\n");
    } elseif (login($us,$fnn,$lnn,$pass) == true) {
        // echo "<h1 style='text-align:center;'>Username is taken</h1>";
        $nourl = "UsernameTaken.php";
        header('Location: '.$nourl);
    }
}

function login($username,$fn,$ln,$password) : bool
{
    $user = "accounts.txt";
    $file = fopen($user,"r");
    $uc = [];

    while(feof($file) == false)
    {
    $get = fgets($file);
    $exp = explode(",",$get);
    
    $u = [];

    $u[] = $exp[0];
    $uc[] = $u;
    }
 
    $newa = array_unique(call_user_func_array('array_merge', $uc));
    $tnewa = $newa;
    $tnewa[] = $username;
    $diff = array_diff($tnewa,$newa);
    if (empty($diff) == true) 
    {
        // echo "$username is taken";
        return true;
    } else 
    {
        // echo "Username is not taken!";
        return false;
    }
}

// Sign up page, Username, First Name, Last Name, and pass. 
// If signing in, check accounts.txt 
// Check Username and Pass 
// If same username is used for sign up, say "username already exists" 
// use smarty

?>