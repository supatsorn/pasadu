<?php
require_once("_text.php");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title><?php echo $_HTML_TEXT_TITLE; ?></title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="fonts/thsarabunnew.css" rel="stylesheet">
<link href="css/my-login.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
  <div class="text-center"> <img src="images/logo.png" width="100" height="100" alt=""/> <br />
    <br/><a href="#" class="h2 text-info">ระบบเบิก-จ่ายวัสดุ</a><br/> </div>
  <form class="form-signin" action="_check_login.php" method="post">
    <h3 class="form-signin-heading">Login เข้าสู่ระบบ</h3>
    <label for="inputEmail" class="sr-only">Username</label>
    <input type="text" name="user" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" autocomplete="off">
    <p class="alert-danger h5" id="t_fail">Username หรือ Password ไม่ถูกต้อง!!!<br/ ><br/ >กรุณาลองอีกครั้ง<br/ ><br/ >หรือติดต่อผู้ดูแลระบบเพื่อตรวจสอบ</p>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
  </form>
</div>
<!-- /container -->
<script src="js/jquery.js"></script>
<script src="js/my.js"></script>
<script type="text/javascript">
var text = getUrlParameter('t');
if(text=="fail"){
	$("#t_fail").show();
}else{
	$("#t_fail").hide();
}
</script>
</body>
</html>
