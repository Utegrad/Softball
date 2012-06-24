<!-- opening footer DIV  -->
<div id="footer">
	<hr/>
	&#124;&nbsp; <a href=index.php?pg=home class="footerLink">Home</a> &nbsp;&#124;
	<!--  &nbsp; <a href="index.php?pg=register" class="footerLink">Register</a> &#124;  -->
	&nbsp; <a href="index.php?pg=roster" class="footerLink">Roster</a> &nbsp;&#124;
	&nbsp; <a href=index.php?pg=calendar class="footerLink">Calendar</a> &nbsp;&#124;
	&nbsp; Login &nbsp;&#124;
	&nbsp; Links &nbsp;&#124;
	<?php /* if logged in and a manager put a 'manage' link here */
		if((isset($_SESSION['auth'])) && ($_SESSION['auth'] == TRUE)){
			echo " &nbsp;<a href=index.php?pg=manage class=\"footerLink\">Mgmt Page</a> ";
			echo " &nbsp;&#124;";
		}
	
	?>
<!-- closing footer DIV -->
</div>