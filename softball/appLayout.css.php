<?php 
header("Content-type: text/css");

include_once ("siteStyleClass.php");

$style = new siteStyle();

$wholeContentWidth = $style->get_contentWidth() + ($style->get_appPadding()*2);

?>
@CHARSET "ISO-8859-1";
img {
	border: 0;
	margin: 0;
	padding 0;S
}

#container {
	width: <?php echo $style->get_containerWidth() ?>px; 
	margin: 0 auto; 
	padding: 0;
}

#header {
	 margin: 0; 
	 height: 180px;
	 position: relative;
}

#loginError {
	margin: 0;
	padding: 0;
}

#menu {
	float: left; 
	margin: 0; 
	padding: 10px; 
	width:<?php echo $style->get_menuWidth() ?>px;
}

#content {
	float: left; 
	margin: 0; 
	padding: 0px; 
	width: <?php echo $style->get_contentWidth() ?>px
}

#footer {
	clear: both; 
	margin: 0; 
	padding: 10px 10px 10px <?php echo ($style->get_menuWidth() + (2*($style->get_appPadding())))?>px;
	text-align: center;
}

a.menuButton {
    text-decoration: none;
    border: 0 none;   
}

a.footerLink {
    text-decoration: none;
    border: 0 none;   
}

a.footerLink:hover {
    text-decoration: underline;
    border: 0 none;       
}
td.label {
	text-align: right;
	padding-right: 10px;
	width: 125px; 
}
td.errorInfo {
	text-align: left;
	padding-left: 10px;
	font-size: 0.8em;
	width: 280px;
}
div.registerFormHeading{
	text-align: center;
	font-size: 1.4em;
	font-weight: bold;
}
div.registerFormSubHeading {
	text-align: center;
	font-style: italic;
	color: red;
}
