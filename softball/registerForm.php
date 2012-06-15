<h3>Please fill out this form to register for with your team</h3>

			<form action="index.php?register=y&pg=register" method="post">
			<table >
				<tr>
					<td>First Name:</td><td><input type="text" name="firstName" size=24 maxlength=24></td>
				</tr>
				<tr>
					<td>Last Name:</td><td><input type="text" name="lastName" size=24 maxlength=24></td>
				</tr>

				<tr>
					<td>Email Address:</td><td><input type="text" name="email" size=24 maxlength=35></td>
				</tr>
				<tr>
					<td>Password:</td><td><input type="password" name="password1" size=24 maxlength="24"></td>
				</tr>				
				<tr>
					<td>Confirm Password:</td><td><input type="password" name="password2" size=24 maxlength="24"></td>
				</tr>
				<tr>
					<td>Cell Phone:</td><td><input type="text" name="mobilePhone" size=24 maxlength=15></td>
				</tr>
				<tr>
					<td>Team ID:</td><td><input type="text" name="teamID" size=24 maxlength=24 value="ID from team manager"></td>
				</tr>
				<tr>
					<td>I am a:</td>
					<td>
						<select name="gender">
							<option value="male">Boy</option>
							<option value="female">Girl</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td><input type="reset" name="reset" value="Reset"> <input type="submit" value="Submit"></td>
				</tr> 
			</table>
			</form>