<?php
// TODO: redirect to index.php
session_start();
session_destroy();
header("location: admin/home.php");