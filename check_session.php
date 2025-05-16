<?php
session_start();
if (isset($_SESSION['test'])) {
    echo "✅ Session ยังคงอยู่: " . $_SESSION['test'];
} else {
    echo "❌ Session หายไป!";
}
?>
