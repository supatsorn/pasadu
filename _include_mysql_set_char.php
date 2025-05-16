<?php
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');  
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');   
mysqli_query($conn,'SET character_set_results=utf8');   
mysqli_query($conn,'SET collation_connection=utf8_general_ci');
mysqli_set_charset($conn, "utf8");
?>