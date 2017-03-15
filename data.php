<?php
	
	session_start();

	function loggedIn(){
		return (isset($_SESSION['userTable'])) ? true : false;
	}
	
	function logIn($username,$password){
		$table = getTable($username);
		$password = md5($password);
		$db = dbConnection("retailsys");
		$stmt = $db->prepare("SELECT * FROM `usertable` WHERE `username`=? AND `password`=?");
		$stmt->execute(array($username,$password));
		$result = $stmt->rowCount();
		
		return ($result == 1) ? $table : false;
	}
	
	function getTable($username){
		$db = dbConnection("usertable");
		$stmt = $db->prepare("SELECT * FROM `usertable` WHERE `username`=?");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row;
	}
	
	function dbConnection($database){
		$db = new PDO('mysql:host=localhost;dbname=' . $database . ';charset=utf8', 'root', 'root');
		return $db;
	}
	/*IDK if I need 
	function getData($start,$limit){
		$db = dbConnection("retailsys");
		$stmt = $db->prepare("SELECT `data` FROM `report` WHERE `data` LIKE :like ORDER BY `id` DESC LIMIT :start,:limit");
		$stmt->bindParam(":like",PDO::PARAM_STR);
		$stmt->bindParam(":start", $start, PDO::PARAM_INT);
		$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}*/
	
	function grabData(){
		$db = dbConnection("retailsys");
		$stmt = $db->prepare("SELECT * FROM OMC UNION ALL SELECT * FROM INFOR UNION ALL SELECT * FROM MICROS");
		$stmt->bindValue(":productTypeId", 6, PDO::PARAM_STR);
		$stmt->bindValue("brand", "Slurm");
		$stmt->execute();
		$result = $stmt->rowCount();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	
	
	function Datagrab (){
		$db = dbConnection("retailsys");
		$stmt = $db->prepare("SELECT * deployments");
		$stmt->execute(array($row));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if (empty($result)){
			return "Description not found.";
		} else {
			return $result['$row'];
		}
		
	}
	
	function SendData (){
		$db = dbConnection("deployments");
		$stmt = $db->prepare("Insert * into deployments");
		$stmt->execute(array($row));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if (empty($result)){
			return "Description not found.";
		} else {
			return $result['$row'];
		}
		
	}
	
?>
