<?php
session_start();
$_SESSION['test'] = "Hello, this is a test session!";
echo "✅ Session ถูกเซ็ตค่าแล้ว!";
?>
