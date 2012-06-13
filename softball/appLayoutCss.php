<?php

$containerWidth = 765;
$appPadding = 10;
$menuWidth = (($containerWidth * 0.18) + ($appPadding*2));
$contentWidth = $containerWidth - $menuWidth -($appPadding*4);

?>
<STYLE type="text/css">
img {
	border: 0;
	margin: 0;
	padding 0;S
}

#container {
	width: <?php echo $containerWidth ?>px; 
	margin: 0 auto; 
	padding: 0;
}

#header {
	 margin: 0; 
	 height: 120px;
	 position: relative;
}

#menu {
	float: left; 
	margin: 0; 
	padding: 10px; 
	width: <?php echo $menuWidth ?>px;
}

#content {
	 float: left; 
	 margin: 0; 
	 padding: 10px; 
	 width: <?php echo $contentWidth ?>px
}

#footer {
	clear: both; 
	margin: 0; 
	padding: 10px 10px 10px <?php echo ($menuWidth + (2*$appPadding)) ?>px;
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

</style>