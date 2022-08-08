<?php
session_start();
include('functions.php');

if (isset($_SESSION['username']) == false) {
    $nourl = "LogIn.php";
    header('Location: ' . $nourl);
} else {
    $userName = $_SESSION['username'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $video = $_POST['video'];

        getUserVideos($video, $userName);
        incrementUserVideos($userName);
        writeNewVideo($video);
        vidFileChanger();
    }
    if (userVideosExists($userName) == true) {
        $userLinks = getLinks();
        smartyDisplay("homepage.html", ['msg' => "Videos Found", 'cuser' => $userName,'links' => $userLinks]);
    } else {
        $emptyarray = ['Drop a link in the box below to add your Videos!'];
            smartyDisplay("homepage.html", ['msg' => "Videos not Found", 'cuser' => $userName,'links' => $emptyarray]);
    }
}

function userVideosExists($userName): bool
{
    $form_name = "yt-videos.txt";
    $form_open = fopen($form_name, "r");
    $form_a = [];
    $ra = [];
    while (feof($form_open) == false) {
        $form_get = fgets($form_open);
        $form_exp = explode(",", $form_get);
        $form_get1 = fgets($form_open);
        $form_exp1 = explode(",", $form_get);
        unset($form_exp[1]);
        unset($form_exp[2]);
        $form_a[] = $form_exp;
        $ra[] = $form_exp1;
    }
    $form_a2 = call_user_func_array("array_merge", $form_a);

    if (in_array($userName, $form_a2)) {
        return true;
    }

    return false;
}

function getUserVideos($user)
{
    $numberfound = 0;

    $file = fopen("vidnumber.txt", "r");
    while (feof($file) == false) {
        $get = fgets($file);
        $exp = explode(",", $get);
        unset($exp[2]);
        if (in_array($user, $exp)) {
            $numberfound = $exp[1];
        }
    }
    fclose($file);
}

function incrementUserVideos($user)
{

    $vidnumberopen = fopen("vidnumber.txt", "r+");
    $tmpopen = fopen("testmp.tmp", "w+");

    while (feof($vidnumberopen) == false) {

        $sourceLine = fgetcsv($vidnumberopen);
        if ($sourceLine != false) {
            list($userFromFile) = $sourceLine;

            if (strcasecmp($user, $userFromFile) == 0) {
                $sourceLine[1]++;
            }

            fputcsv($tmpopen, $sourceLine);
        }
    }
    fclose($vidnumberopen);
    fclose($tmpopen);
}

function vidFileChanger()
{
    rename("testmp.tmp", "vidnumber.txt");
}

function writeNewVideo($link)
{
    $open = fopen("yt-videos.txt", "a");
    $fopen = fopen("vidnumber.txt", "r");
    while (feof($fopen) == false) {

        $fget = fgetcsv($fopen);
        if ($fget == true) {
            if (in_array($_SESSION['username'], $fget)) {
                $number = $fget[1];
                $number++;
                $format = $_SESSION['username'] . ",$number,$link,\n";
                fwrite($open, $format);
                fclose($open);
            }
        }
    }
}

function getLinks() : array
{
    $yt_videos = fopen("yt-videos.txt","r");
    $storedLinks = [];
    while (feof($yt_videos) == false) {
        $fget = fgetcsv($yt_videos);
        if ($fget == true) 
        {
            if(in_array($_SESSION['username'],$fget)) 
            {
                $link1 = $fget[2];
                $link2 = "<a href=" . "$link1" . ">$link1</a>";
                $storedLinks[] = $link2;

            }
        }
    }
    return $storedLinks;
}

?>