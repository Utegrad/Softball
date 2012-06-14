<?php 
require_once ("headingClass.php");

$heading = new heading();

$heading->openHeadingDivTag();
$heading->writeHeadingImg();

?>
		 <h1 style="margin: 0; text-align: center;">
<?php echo "$heading->headingTitle"; ?>
		 </h1>
		 <p style="text-align: right; margin: 0 auto; padding: 0;">
		 	Organize your team&#39;s schedule and communications
		 </p>	
		 <div id="login" style="float: right; margin: 0; padding:10px; height: 40px; background-color: gray; ">
		 	<table><tr style="vertical-align: bottom;"><td>
		 		<form action="login.php">
		 		<a>Login:</a><input type="text" size=15 maxlength="40" value="Email Address" name="emailAddress"> <input type="submit">
		 		</form>
	 		</td></tr>
		 	</table>
		 </div> 
<?php 
$heading->closeHeadingDivTag();
?>