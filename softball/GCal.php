<?php 
include_once ("siteStyleClass.php");
$style = new siteStyle();
?>

<iframe src="https://www.google.com/calendar/embed?src=gavid5is77kvuf5kpaamn4duec%40group.calendar.google.com&ctz=America/Los_Angeles" style="border: 0" 
width="	<?php 
			
			echo ($style->get_contentWidth() + ($style->get_appPadding()*2));
			 
		?>
			" height="650" frameborder="0" scrolling="no"></iframe>