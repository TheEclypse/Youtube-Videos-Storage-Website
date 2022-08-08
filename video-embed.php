<?php
$array = ["hello azam","saba"];
$a2 = [];
// $c = count($array);

// if (in_array("azam",$array) == true) 
// {
//     echo "Hola";
// } else 
// {
//     echo "butt";
// }

$form_name = "yt-videos.txt";
$form_open = fopen($form_name,"r");
while(feof($form_open) == false) 
{
    $form_get = fgets($form_open);
    $exp = explode(",",$form_get);
    unset($exp[1]);
    unset($exp[2]);
    $a2[] = $exp;
}

$newa = call_user_func_array("array_merge",$a2);
print_r($newa);
?>