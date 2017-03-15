<?php

	session_start();
	
    function loggedIn(){
		return (isset($_SESSION['userTable'])) ? true : false;
	}
	
	function logIn($username,$password){
		$table = getTable($username);
		$password = md5($password);
		$db = dbConnection("productdb");
		$stmt = $db->prepare("SELECT * FROM 'usertable' WHERE 'username'=? AND 'password'=?");
		$stmt->execute(array($username,$password));
		$result = $stmt->rowCount();
		
		return ($result == 1) ? $table : false;
	}	
	
		function getTable($username) {
		$db = dbConnection("productdb");
		$stmt = $db->prepare("SELECT * FROM 'usertable' WHERE 'username'=?");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);		
		
		return $row;
	}

	function dbConnection($database){
        $db = new PDO('mysql:host=66.210.175.116;dbname=' . $database . ';charset=utf8', 'root', 'root');
		return $db;
	}
	
	function getTransactions($Generator) {
		$db = dbConnection("water");
		$stmt = $db->prepare("SELECT * FROM 'influent'");
		$stmt->execute(array($Generator));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		
		return $rows;
	}

    function GetAllTrasactions() {
        $db = dbConnection("emissions");
        $stmt = $db->prepare("SELECT * from alliance UNION ALL SELECT * from stack");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }

    function trasactionCount() {
        $db = dbConnection("emissions");
        $stmt = $db->prepare("SELECT * from alliance UNION ALL SELECT * from stack");
        $stmt->execute();
        $result = $stmt->rowCount();
        
        return $result;
    }
		function getmoreData($Parameter) {
		$db = dbConnection("emissions");
		$stmt = $db->prepare("SELECT * FROM 'stack'");
		$stmt->execute(array($Parameter));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		
		return $rows;
	}
		function getsomeData($Parameter) {
		$db = dbConnection("emissions");
		$stmt = $db->prepare("SELECT * FROM 'alliance'");
		$stmt->execute(array($Parameter));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		
		return $rows;
	}
	
		function gettheData($Generator) {
		$Analyte = (string)$Analyte;	
		$db = dbConnection("solids");
		$stmt = $db->prepare("SELECT * FROM 'solids'");
		$stmt->execute(array($Analyte));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		
		if (empty($result)){
			return "Description not found.";
		} else {
		return $result['Analyte'];
		}
	}
?>