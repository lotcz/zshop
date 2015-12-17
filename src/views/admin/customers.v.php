<div class='inner cover'>	
	<form method='post' action='/admin/customer' class='code-form'>		
		<input type='submit' class='btn btn-success' value='Create new customer'>
	</form>	
	<table>
		<tr><th>login</th><th>e-mail</th><th>failed logins</th><th></th></tr>
		<?php
			global $db;
			$result = $db->query('SELECT * FROM customers ORDER BY customer_id');
			while ($row = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . $row['customer_login'] . '</td>';
				echo '<td>' . $row['customer_email'] . '</td>';				
				echo '<td><a href="/admin/customer/edit/' . $row['customer_id'] . '">edit</a></td>';
				echo '</tr>';
			}
		?>
	</table>
	<a href="/admin">Zpět</a>
</div>