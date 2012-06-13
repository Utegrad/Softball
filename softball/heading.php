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
<?php 
$heading->closeHeadingDivTag();
?>