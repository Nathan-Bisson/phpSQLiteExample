<?php



$db_host = "localhost";
$db_name = "testDB";
$db_user = "root";
$db_password = "root";
	
$pdo_link = new PDO("mysql:host=$db_host;dbname=$db_name",$db_user,$db_password);
	
	
$mysql_result = $pdo_link->query(" SELECT * FROM players ");
	
$db_file = new PDO('sqlite:players.sqlite3');
	
$db_file->exec("CREATE TABLE players (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					name TEXT,
					locX INTEGER,
					locY INTEGER,
					color TEXT)");
	
if( $mysql_result ) {
	while( $row = $mysql_result->fetch(PDO::FETCH_ASSOC) ) {
		$db_file->exec("INSERT INTO `players` 
			(`id`, `name`, `locX`, `locY`, `color`) 
			VALUES('" . 
			$row['id'] . "', '" . 
			$row['name'] . "', '" . 
			$row['locX'] . "', " . 
			$row['locY'] . ", " . 
			$row['color'] . ");");
	}   
}

$random1 = rand(1,5);
$random2 = rand(6,10);
$db_file->query("DELETE FROM players WHERE user_id = " . $random1);
$db_file->query("DELETE FROM players WHERE user_id = " . $random2);

$db_file->query("VACUUM");

for ($x=0; $x<3; $x++) {
	$randomName = substr( str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10 );;
	$randomX = rand(1,100);
	$randomY = rand(1,100);
	$randomColor = rand(100000,999999);
	
	$db_file->query("INSERT INTO users (`name`, `locX`, `locY`, `color`)
					  VALUES ('" . $randomName . "', '" . $randomX . "', '" . $randomY . "', '" . $randomColor . "')");
} 

$sql_result = $db_file->query("SELECT * FROM players");

if($sql_result) {
	$mysql_result = $pdo_link->query("DROP TABLE players");
	if($mysql_result) {
		$mysql_result = $pdo_link->query("CREATE TABLE players (
											 id int(11) NOT NULL AUTO_INCREMENT,
											 name char(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Name',
											 locX int(11) NOT NULL DEFAULT '0',
											 locY int(11) NOT NULL DEFAULT '0',
											 color varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ffffff',
											 PRIMARY KEY (`id`)
											 )");
		
		foreach($sql_result as $row) {
			$mysql_result = $pdo_link->query("INSERT INTO `players` (`id`, `name`, `locX`, `locY`, `color`) VALUES(".
			$row['id'] . ", '" . 
			$row['name'] . "', " . 
			$row['locX'] . ", " . 
			$row['locY'] . ", '" . 
			$row['color'] . "');");
		}
	}
}
	
$pdo_link = null;
$db_file = null;

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php echo $output; ?>
</body>
</html>