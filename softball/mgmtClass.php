<?php
/**
 * defines a class used to write the management page content headings
 * 
 * @author Matthew Larsen
 * 
 *   
 * 
 */
require_once ('page.php');


/**
 * Intended to create a consistent set of headings for page team management
 * 
 * @author Matthew Larsen
 * @created Jun 28, 2012
 */
class mgmtContentPage extends page {
	
	var $headings;
	var $title;
	var $URL = "index.php?pg=manage";
	
	 function __construct(){
	 	$this->title  = 'Manage your team';
	 	$this->headings = array (
						array(
								'URI'=> 'teams.php',
								'mgtPg'=> 'teams',
								'id'=> 'teams',
								'display'=> 'Teams'),
						array (
								'URI'=> 'participants.php',
								'mgtPg'=> 'participants',
								'id'=> 'people',
								'display'=> 'Participants'),
						array (
								'URI'=> 'teamCals.php',
								'mgtPg'=> 'teamCals',
								'id'=> 'cal',
								'display'=> 'Calendars'),
						array (
								'URI'=> 'events.php',
								'mgtPg'=> 'events',
								'id'=> 'events',
								'display'=> 'Events')
	 			);
	 }
	
	
	function getTitle (){
		$title = "\n<h3> $this->title </h3>\n";
		echo $title;
		return;
	}
	
	/**
	 * Writes the management page headings
	 */
	function getHeadings (){
		//loop through the values in $this->headings and echo
		//<div class='mgt' id="$this-headings[ROW]['id']"><a href="INDEX.PHP?pg=manage&mgtPg=$this->headings[ROW]['mgtPg']">$this->[ROW]['display']</a></div>
		// should I set the href to _PHP_SELF_ or some other absolute URL?
		
		// get the number of associate arrays we have headings for
		$headingCount = count($this->headings);
				
		//echo "\n<p> headingCount : $headingCount </p>\n";
		
		// used to figure out if we've reached the last element in headings
		$i = 0;
		
		// loop through headings and echo the DIV with or without the last | 
		foreach ($this->headings as $heading){
			//var_dump($heading);
			if (++$i === $headingCount)
				$this->echoDiv(TRUE,$heading);
			else
				$this->echoDiv(FALSE, $heading);
		}
		
		return;
	}
	
	/**
	 * Used by getHeadings for logic to echo DIV heading with spacer at the end of the last element
	 * If it's the last element of $this->headings then don't echo the spacer
	 * 
	 * @param boolean $lastElement indicator for being on the last value of loop
	 * @param array $heading Associative array for content headings DIV blocks
	 * 
	 * @todo This feels sloppy.  Seems like there should be a better way to do this.  
	 * Mostly it's calling another function to do this vs doing it in the getHeadings method
	 */
	private function echoDiv ($lastElement, array $heading){
		if ($lastElement == FALSE)
			echo "\n<div class='mgt' id='".$heading['id']."'>&nbsp; <a href='$this->URL&mgtPg=".$heading['mgtPg']."'>".$heading['display']."</a> &#124;</div>";
		else
			echo "\n<div class='mgt' id='".$heading['id']."'>&nbsp; <a href='$this->URL&mgtPg=".$heading['mgtPg']."'>".$heading['display']."</a>&nbsp;</div>";
		return;
	}
	
}


 ?>