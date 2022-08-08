<?php
session_start();
include('smarty-master/libs/Smarty.class.php');
$sm = new Smarty;

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $logrl = "homepage.php";
    header('Location: '.$logrl);
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $sm->assign('error', '');
        $sm->assign('username', '');
        $sm->assign('password', '');
        $sm->display('LogIn.html');
    }

    $user = "accounts.txt";
    $file = fopen($user, "a+");
    $e = file_get_contents($user);
    $z = explode(",", $e);


    function login($username, $password): bool
    {
        $user = "accounts.txt";
        $file = fopen($user, "r");
        $threa = [];
        $fa = [];

        while (feof($file) == false) {
            $get = fgets($file);
            $exp = explode(",", $get);
            unset($exp[1]);
            unset($exp[2]);
            unset($exp[4]);
            $fa[] = $exp;
        }
        $fcount = count($fa) - 1;


        $finala = [];

        for ($i = 0; $i <= $fcount; $i++) {
            if (in_array($password, $fa[$i]) && in_array($username, $fa[$i])) {
                $finala[] = $fa[$i];
                break;
            } else {
                $threa[] = "1";
            }
        }

        $fixeda = call_user_func_array('array_merge', $finala);

        if (count($fixeda) == 2) {
            $User = $fixeda[0];
            $Pass = $fixeda[1];
            if ($User == $username && $Pass == $password) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $us = $_POST['username'];
        $pass = $_POST['password'];

        if (login($us, $pass) == false) {
            // $logurl = "http://localhost:8000/Profile/LoggingIn.php";
            // header('Location: '.$logurl);
            $sm->assign('error', "Username and/or Password are incorrect.");
            $sm->assign('username', $us);
            $sm->display('LogIn.html');
        } elseif (login($us, $pass) == true) {
            // $nourl = "SuccessfulLogIn.php";
            // header('Location: '.$nourl);
            // $sm->assign('username',$us);
            // $sm->display("format.php");
            $_SESSION['username'] = $us;
            $_SESSION['password'] = $pass;
            $logrl = "homepage.php";
            header('Location: '.$logrl);
            // // $form_name = "yt-videos.txt";
            // // $form_open = fopen($form_name, "r");
            // // $form_a = [];
            // // while (feof($form_open) == false) {
            // //     $form_get = fgets($form_open);
            // //     $form_exp = explode(",", $form_get);
            // //     unset($form_exp[1]);
            // //     unset($form_exp[2]);
            // //     $form_a[] = $form_exp;
            // // }
            // // $form_a2 = call_user_func_array("array_merge", $form_a);
            // // if (in_array($us, $form_a2)) {
            // //     $Foundit = "Videos found.";
            // //     $sm->assign("msg", $Foundit);
            // //     $sm->display("format.php");
            // // } else {
            // //     $Foundit = "No videos added.";
            // //     $sm->assign("msg", $Foundit);
            // //     $sm->display("format.php");
            // // }
        }
    }
}
