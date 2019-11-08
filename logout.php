<?php
session_start();

unset($_SESSION['mirror']);

session_unset();
session_destroy();

header("location:index.php");
?>