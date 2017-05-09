<?php
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['player'])){
    $res = 1;
}else{
    $res = 0;
}
echo $res;
?>