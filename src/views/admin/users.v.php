<div class='inner cover'>	
	<form method='post' action='/user' class='code-form'>		
		<input type='submit' class='btn btn-success' value='Create new user' style='margin-top:25px;'>
	</form>	
	<table>
		<tr><th>login</th><th>e-mail</th><th>failed logins</th><th></th></tr>
		<?php
			global $db;
			$result = $db->query('SELECT * FROM users ORDER BY user_id');
			while ($row = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . $row['user_login'] . '</td>';
				echo '<td>' . $row['user_email'] . '</td>';
				echo '<td>' . $row['user_failed_attempts'] . '</td>';
				echo '<td><a href="/admin/user/edit/' . $row['user_id'] . '">edit</a></td>';
				echo '</tr>';
			}
		?>
	</table>
	<a href="/admin">Zpět</a>
</div>