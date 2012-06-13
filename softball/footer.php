<div id="footer">
	<hr/>
	&#124;&nbsp; <a href=index.php?pg=home class="footerLink">Home</a> &#124;
	&nbsp; <a href="index.php?pg=register" class="footerLink">Register</a> &#124;
	&nbsp; <a href="index.php?pg=roster" class="footerLink">Roster</a> &#124;
	&nbsp; <a href=index.php?pg=calendar class="footerLink">Calendar</a> &#124;
	&nbsp; Login &nbsp;&#124;
	&nbsp; Links &nbsp;&#124;
	<?php /* if logged in and a manager put a 'manage' link here */
		echo " <a href=index.php?pg=manage class=\"footerLink\">Mgmt Page</a> ";
		echo " &#124;";
	
	?>
	
</div>