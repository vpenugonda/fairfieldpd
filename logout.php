<?php
ob_start();
session_start();
session_destroy();
echo "Logged out successfully...";
header('Refresh:1,url=./');
