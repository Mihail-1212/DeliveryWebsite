<?php
if (isset($_SESSION["userToken"])){
    header('Location: ' . URL);
    exit;
}

?>