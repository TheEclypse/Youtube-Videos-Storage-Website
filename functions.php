<?php
include('smarty-master/libs/Smarty.class.php');

function smartyDisplay($fileName,$params) 
{
    $sm = new Smarty;
    foreach($params as $key => $value) 
    {
        $sm->assign($key, $value);
    }

    $sm->display($fileName);
}

