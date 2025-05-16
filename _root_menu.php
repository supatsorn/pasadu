<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li <?php if($_GET["menu"]==1) echo 'class="active"'; ?> ><a href="root.php?menu=1">ผู้ใช้งาน <?php if($_GET["menu"]==1) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>		
		<li <?php if($_GET["menu"]==2) echo 'class="active"'; ?> ><a href="root_add_user.php?menu=2">เพิ่มผู้ใช้งาน <?php if($_GET["menu"]==2) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>		
	</ul>
	<!--<ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>-->
</div>