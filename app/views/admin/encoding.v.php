<?php

	$cube_db = new mysqli('localhost', 'root', '', 'parfumerie');
	$cube_db->set_charset('ISO-8859-2');	
	
	$stmt = $cube_db->prepare('select description from cubecart_inventory where productId = 14');
	$stmt->execute();
	$result = $stmt->get_result();
	if ($row = $result->fetch_assoc()) {
		$description = $row['description'];
	}
	$stmt->close();
	
	echo $description;
	echo '<br/>';	
	
	function convertEncoding($str, $encfrom, $encto) {
		//return $str;
		//$str2 = mb_convert_encoding($str, $encto, $encfrom);
		$str2 = iconv($encfrom, $encto, $str);
		
		echo sprintf('<b>from: %s, to: %s</b><br/>', $encfrom, $encto);
		echo $str2;
		echo '<br/>';		
	}
	
	$enclist = array(
		'UTF-8', 'ASCII',
		'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
		'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
		'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
		'Windows-1251', 'Windows-1252', 'Windows-1254', 'Windows-1250', 'latin1',
	);
        
	for ($i = 0, $maxi = count($enclist)-1; $i < $maxi; $i++) {
		convertEncoding($description, $enclist[$i], 'UTF-8');
		//for ($y = 0, $maxy = count($enclist)-1; $y < $maxy; $y++) {
		//	convertEncoding($description, $enclist[$i], $enclist[$y]);
		//}
	}
