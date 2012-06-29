<?php
header("Content-type: text/css");
include_once ("siteStyleClass.php");

$style = new siteStyle();


?>

div.mgt {
	float: left;
	margin: <?php echo $zero ?>;
	padding: 0;
}

div.mgtContent {
	float: left;
	width: <?php echo $style->get_contentWidth() ?>px
/*	margin: 0;
	padding: 0; */
}

#peopleContent {
	background-color: #00BFFF;
	margin: 0;
	padding: 0;
}

#calContent {
	background-color: #FFDEAD;
	margin: 0;
	padding: 0;
}

#eventsContent {
	background-color: #5F9EA0;
	margin: 0;
	padding: 0;
}

#teamContent {
	background-color: #F5DEB3;
	margin: 0;
	padding: 0;
}
