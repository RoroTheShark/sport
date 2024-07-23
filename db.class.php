<?php
	include('params.php');
	class DatabaseConnection {
		public $dbh = null;
		public $sth = null;

		function __construct() {
			if ($this->dbh) {
				return $this->dbh;
			}
			
			try {
				$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DB, DB_USER, DB_PWD);
				
				$this->dbh->query('SET NAMES utf8');
			} catch (PDOException $e) {
			    echo 'Connexion &eacute;chou&eacute;e pour la base : ' . $e->getMessage();
			    die();
			}
			
			return $this->dbh;
		}

		function __destruct() {
			$this->dbh = null;
			unset($this->dbh);
			$this->sth = null;
			unset($this->sth);
			
		}

		function select($req, $values = NULL) {
			
			if(!is_numeric($values) && $values == NULL) {
				$values = array();
			} elseif(!is_array($values)) {
				$values = array($values);
			}
			
			$this->sth = $this->dbh->prepare($req);
			$this->sth->execute($values);
			$h_data = $this->sth->fetchAll(PDO::FETCH_ASSOC);
			
			$this->sth = null;
			
			return $h_data;
		}

		function select_one($req, $values = NULL) {
			$resultat = $this->select($req,$values);
			return (empty($resultat)) ? null : $resultat[0];
		}

		function InsertDeleteUpdate($req, $values = NULL)
		{
			if(!is_numeric($values) && $values == NULL) {
				$values = array();
			} elseif(!is_array($values)) {
				$values = array($values);
			}
			try {
				$request = $this->dbh->prepare($req);
				$request->execute($values);
				$Msg = "Ok";
			}
			
			catch (PDOException $e) {
				//echo $req,"<br />";
				//var_dump($values);
				//var_dump($e);
				$Msg = $e->getMessage()." // ";
				echo "<span style='color: blue;'>", $Msg ,"</span><br />";
				die();
			}
			
			return $Msg;
		}
		
		function lastInsertId()
		{
			return $this->dbh->lastInsertId();
		}
	}
?>
