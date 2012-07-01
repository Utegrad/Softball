<?php

class teamsForms {

	var $newTeamForm = 
		"<div name='newTeamFormDiv' id='newTeamFormDiv'>
		 	<form action='' method='post'>
				<table >
					<tr>
						<td>Team Name:</td><td><input type='text' name='teamName' value='Your team name' onfocus=\"if(this.value == 'Your team name') { this.value = ''; }\" size=38 maxlength=45></td>
					</tr>
					<tr>
						<td>Team Description:</td><td><textarea name='teamDesc' cols='30' rows='4' onfocus=\"if(this.value == 'Description of your team') { this.value = ''; }\">Description of your team</textarea></td>
					</tr>
					<tr>
						<td>What type of team:</td>
						<td>
							<select name='teamType'>
								<option value='softball'>Softball</option>
								<option value='other'>Other</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td><td><input type='reset' name='reset' value='Reset'> <input type='submit' value='Submit'></td>
					</tr>
				</table>
			</form>
		</div>";
	var $updateTeamForm =
			"<div id='updateTeamFormDiv'>
			 	<form action='' method='post'>
					<table >
						<tr>
							<td>Team Name:</td><td><input type='text' name='teamNameUpdate' value='Your team name' onfocus=\"if(this.value == 'Your team name') { this.value = ''; }\" size=38 maxlength=45></td>
						</tr>
						<tr>
							<td>Team Description:</td><td><textarea name='teamDescUpdate' cols='30' rows='4' onfocus=\"if(this.value == 'Description of your team') { this.value = ''; }\">Description of your team</textarea></td>
						</tr>
						<tr>
							<td>What type of team:</td>
							<td>
								<select name='teamType'>
									<option value='softball'>Softball</option>
									<option value='other'>Other</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Team Owner:</td>
								<td>
									Some sort of input to select a different owner.
								</td>
						</tr>
						<tr>
							<td>&nbsp;</td><td><input type='reset' name='reset' value='Reset'> <input type='submit' value='Submit'></td>
						</tr>
					</table>
				</form>
			</div>";
	var $newTeamFromIntro = 
		"<p id='mgtDesc'>Step 1 is to create a team.  Please use this form to describe your team.</p>";
		
	function get_newTeamForm (){
		return $this->newTeamForm;
	}
	
	function get_updateTeamForm (){
		return $this->updateTeamForm;
	}
	
	function get_newTeamFormIntro(){
		return $this->newTeamFromIntro;
	}

}
?>