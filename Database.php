<?php
require_once('config.php');
class Database{
	public static $dbc;
	
	public static function connect(){
		if(self::$dbc = new mysqli(Conf::DB_HOST, Conf::DB_USERNAME,Conf::DB_PASSWORD)){
          echo 'opening';
			if(!mysqli_select_db(self::$dbc,Conf::DB_NAME)){
				trigger_error("Could not connect to selected database.");
				return false;
			} else {
				//echo "Successful";
				return true;
			}
		} else {
			trigger_error("Could not connect to database.");
			return false;
			exit();
		}
	}
	public static function escape_data($data){
		if(!self::$dbc){
        	self::connect();
		}
		if(function_exists('mmysql_real_esacape_string')){
			$data = mysqli_real_escape_string(self::$dbc, trim($data));
			$data = strip_tags($data);
		} else {
			$data = mysqli_real_escape_string(self::$dbc,trim($data));
			$data = strip_tags($data);
		}
		return $data;
	}
	
	public static function query($query) {
        // Connect to the database
		if(!self::$dbc){
        	self::connect();
		}
        // Query the database
        if($result = self::$dbc -> query($query)){
          return $result;
        } else {
          echo self::$dbc->error;
          return null;
        }
    }
  
    public static function close(){
      echo 'closing';
      mysqli_close(self::$dbc);
    }
	
	public static function modify($type, $table, $fieldValues, $fieldValues2, $oCondition) {
      $statement = "";
      $i = 0;
      
      if($type == "INSERT"){
        $statement = "INSERT INTO ";
        
        $table = self::escape_data($table);
        $statement .= $table." (";
        foreach($fieldValues as $field => $value){
          if($i == 0){
            $statement .= $field;
          } else {
            $statement .= ",".$field;
          }
          $i++;
        }
        $statement .= ") VALUES (";
        $i=0;
        foreach($fieldValues as $field => $value){
          if($i == 0){
            $statement .= "'".$value."'";
          } else {
            $statement .= ",'".$value."'";
          }
          $i++;
        }
        $statement .= ")";
      } else if($type == "UPDATE"){
        $statement = "UPDATE ";
        
        $table = self::escape_data($table)." ";
        $statement .= $table. "SET ";
        foreach($fieldValues as $field => $value){
          if($i == 0){
            $statement .= self::escape_data($field)." = '".self::escape_data($value)."' ";
          } else {
            $statement .= ", ".self::escape_data($field)." = '".self::escape_data($value)."' ";
          }
          $i++;
        }
        $i=0;
        foreach($fieldValues2 as $field => $value){
          if($i == 0){
            $statement .= " WHERE ".self::escape_data($field)." = '".self::escape_data($value)."' ";
          } else {
            $statement .= "AND ".self::escape_data($field)." = '".self::escape_data($value)."'";
          }
          $i++;
        }
      }
      $oCondition = self::escape_data($oCondition);
      $statement .= $oCondition;
      //echo $statement;
        $rows = array();
        $result = self::query($statement);
        if($result === false) {
            return false;
        }
		//print_r($rows);
        return true;
    }
	
	public static function select($fields, $table, $wCondition, $oCondition) {
      //Build SQL
      $statement = "SELECT ";
      foreach($fields as $value){
        $value = self::escape_data($value);
        $statement .= $value." ";
      }
      $table = self::escape_data($table);
      $statement .= "FROM ".$table;
      $i = 0;
      foreach($wCondition as $field => $value){
        if($i == 0){
          $statement .= " WHERE ".self::escape_data($field)." = '".self::escape_data($value)."' ";
        } else {
          $statement .= "AND ".self::escape_data($field)." = '".self::escape_data($value)."'";
        }
        $i++;
      }
      
      $oCondition = self::escape_data($oCondition);
      $statement .= " ".$oCondition;
      
      //echo $statement;
      //Return Results array
      $rows = array();
      $result = self::query($statement);
      if($result === false) {
          return false;
      }
      while ($row = $result -> fetch_assoc()) {
          $rows[] = $row;
      }
      return $rows;
    }
}
?>