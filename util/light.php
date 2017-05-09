<?php
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['light'])&&$_SESSION['light']==0){
    $_SESSION['light'] = 1;
}else{
    $_SESSION['light'] = 0;
}
echo $_SESSION['light'];
?>