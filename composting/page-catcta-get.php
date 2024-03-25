<?php

session_start();
if (isset($_POST['catcta']) && isset($_SESSION['catcta']) && $_POST['catcta'] == $_SESSION['catcta']) {
    echo 1;
    exit;
}
echo 0;

?>