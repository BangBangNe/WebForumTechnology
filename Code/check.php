<?php

if($_SESSION['User_ID'] == null) {
    header("Location:Code/signinUP.php ");
    exit();
}
else{
    header("Location:index.php?page=user_infor");
    exit();
}

?>