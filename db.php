<?php
    class DB{
         protected $mysqli;
         protected $result;
		 protected $row=array();
		 public function __construct($host,$user,$passwd,$database){
             $this->mysqli=new mysqli($host,$user,$passwd,$database);
             if($this->mysqli->errno){
                die('Connection Error:'.$this->mysqli->error); 
             }else{
                 $this->mysqli->set_charset('UTF8');
             }
         }
         public function get_rows_array($sql){//fetch all the associated sets
         	if(!empty($this->row)){
         		$this->close();
         	}
            $this->result=$this->mysqli->query($sql);
            if($this->result && $this->result->num_rows>0){
                $row=array();
                while($rows=$this->result->fetch_assoc()){
                    $this->row[]=$rows;
                }
            }
            return $this->row;
         }
		 public function fetch_one_array($sql){//fetch one single set
		 	if(!empty($this->row)){
         		$this->close();
         	}
			$this->result=$this->mysqli->query($sql);
            if($this->result && $this->result->num_rows>0){
                
                
                $this->row=$this->result->fetch_array(MYSQL_ASSOC);
               
            }
            return $this->row; 
		 }
		 public function get_total_num($sql){//get the total number of one of your table
		 	if(!empty($this->row)){
         		$this->close();
         	}
			$this->result=$this->mysqli->query($sql);
            if($this->result && $this->result->num_rows>0){
                
                
                $this->row=$this->result->fetch_array();
               
            }
            return $this->row[0]; 
		 }
		 
         public function getAffectedRows(){
             return $this->mysqli->affected_rows;
         }
		 protected function close(){
		 	$this->row=array();
		 }
         public function __destruct(){
             $this->result->free();
             $this->mysqli->close();
         }
    }
	require_once 'config.php';//this is your config file which contains your mysql username,password,port and database name
    $DB=new DB($host,$user,$passwd,$database);
?>
