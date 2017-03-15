<?php
	
	session_start();

	function loggedIn(){
		return (isset($_SESSION['usertable'])) ? true : false;
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
		$db = dbConnection("retailsys");
		$stmt = $db->prepare("SELECT * FROM `usertable` WHERE `username`=?");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row;
	}
	
	/* function dbConnection($database){
		$db = new PDO('mysql:host=localhost;dbname=' . $database . ';charset=utf8', 'root', 'root');
		return $db;
	}
	
    function getTransactions($Generator) {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'gl_1_16_2017'UNION ALL SELECT * from gl_1_17_2017");
        $stmt->execute(array($Generator));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
    
    function GetAllTrasactions() {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * from gl_1_18_2017 UNION ALL SELECT * from gl_1_19_2017");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
    
    function trasactionCount() {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * from scope UNION ALL SELECT * from pilotstores");
        $stmt->execute();
        $result = $stmt->rowCount();
        
        return $result;
    }
    function getmoreData($Parameter) {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'pilotstores'");
        $stmt->execute(array($Parameter));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
    function getsomeData($Parameter) {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'scope'");
        $stmt->execute(array($Parameter));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
	    function getyousomeData($Parameter) {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'deploymentv2'");
        $stmt->execute(array($Parameter));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
	    function getchasomeData($Parameter) {
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'deploymentv3'");
        $stmt->execute(array($Parameter));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rows;
    }
    
    function gettheData($Generator) {
        $Analyte = (string)$Analyte;
        $db = dbConnection("retailsys");
        $stmt = $db->prepare("SELECT * FROM 'deploymentv1'");
        $stmt->execute(array($Analyte));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($result)){
            return "Description not found.";
        } else {
            return $result['Analyte'];
        }
    }
     */
    ?>