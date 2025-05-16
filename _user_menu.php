<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li <?php if($_GET["menu"]==1) echo 'class="active"'; ?> ><a href="user.php?menu=1">รายการวัสดุคงเหลือ <?php if($_GET["menu"]==1) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET["menu"]==2) echo 'class="active"'; ?> ><a href="user_request.php?menu=2">ขอเบิกวัสดุ <?php if($_GET["menu"]==2) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>		
		<hr>
		<li <?php if($_GET["menu"]==3) echo 'class="active"'; ?> ><a href="user_head_check_approve.php?menu=3">ตรวจสอบการขอเบิกวัสดุ (<b>สำหรับหัวหน้ากลุ่ม</b>) <?php if($_GET["menu"]==3) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<hr>
		<li <?php if($_GET["menu"]==4) echo 'class="active"'; ?> ><a href="user_want.php?menu=4">แจ้งความต้องการ <?php if($_GET["menu"]==4) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
	</ul>
</div>