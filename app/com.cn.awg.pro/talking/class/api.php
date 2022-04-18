<?php
include_once "message.class.php";


$type=@$_GET["type"];
$c=new message();
switch ($type)
{
    case "make":
        $c->add();
        break;
    case "release":
        $c->release();
        break;
    case "del":
        $c->del();
        break;

    default:

}


?>