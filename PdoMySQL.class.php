<?php
	/**
	 * pdo数据库操作类
	 */
	class PdoMySQL{
		private $_config=array();
		private $_pdo;
		private $_pdoStatement;
		private $_lastId;
		function __construct($username,$passwd,$db,$options=array(),$dbType='mysql',$host='localhost',$charType='utf8') {
			if(!class_exists('PDO')){
				$this->showError('PDO没有开启，请开启后使用');
			}
			if(!empty($db) && !empty($username) && !empty($passwd)){
				$this->_config=array(
				'dbType'=>$dbType,
				'host'=>$host,
				'charset'=>$charType,
				'username'=>$username,
				'passwd'=>$passwd,
				'dsn'=>$dbType.':host='.$host.';dbname='.$db,
				'options'=>$options
				);
			}
			try{
				$this->_pdo=new PDO($this->_config['dsn'],$this->_config['username'],$this->_config['passwd'],$this->_config['options']);
			}catch(PDOException $e){
				$this->_showError($e->getMessage());
			}
			if(!$this->_pdo){
				$this->_showError('PDO链接错误');
			}
			$this->_pdo->exec('set names '.$this->_config['charset']);
		}
		
		public function getAll($sql=''){
			if(strlen($sql)>0){
				if(!empty($this->_pdoStatement)){
					$this->_free();
				}
				$this->_pdoStatement=$this->_pdo->query($sql);
				if($this->_pdoStatement->rowCount()){
					$result=$this->_pdoStatement->fetchAll(PDO::FETCH_ASSOC);
				}else{
					$this->_showError('没有数据集返回');
				}
				return $result;
			}else{
				$this->_showError('SQL语句有误，请检查');
			}
		}
		public function get_one_row($sql=''){
			if(strlen($sql)>0){
				if(!empty($this->_pdoStatement)){
					$this->_free();
				}
				$this->_pdoStatement=$this->_pdo->query($sql);
				if($this->_pdoStatement->rowCount()){
					$result=$this->_pdoStatement->fetch(PDO::FETCH_ASSOC);
				}else{
					$this->_showError('没有数据集返回');
				}
				return $result;
			}else{
				$this->_showError('SQL语句有误，请检查');
			}
		}
		
		public function op_insert($data=array(),$dbName){
			$keys=array_keys($data);
			$values=array_values($data);
			$values="'".implode("','", $values)."'";				
			if(count(array_diff_assoc($keys, range(0, sizeof($data))))!=0){//如果是关联数组
				$keys=implode(',', $keys);				
				$sql="insert into {$dbName}({$keys}) values({$values})";
			}else{				
				$sql="insert into {$dbName} values({$values})";
			}	
			echo $sql;		
			if($this->_pdo->exec($sql)){
				return true;
			}else{
				return false;
			}
		}
		
		public function find($fields='*',$table,$where=null,$group=null,$having=null,$order=null,$limit=null){
			$sql='select '.$fields.' from '.$table
			.$this->_parseWhere($where)
			.$this->_parseGroup($group)
			.$this->_parseHaving($having)
			.$this->_parseOrder($order)
			.$this->_parseLimit($limit);
			
			return $this->getAll($sql);
		}
		
		private function _parseWhere($where){
			$whereStr='';
			if(is_string($where) && !empty($where)){
				$whereStr.=$where;
			}
			return empty($whereStr)?'':' where '.$whereStr;
		}
		
		private function _parseGroup($group){
			$groupStr='';
			if(is_string($group) && !empty($group)){
				$groupStr.=$group;
			}elseif (is_array($group)) {
				$groupStr.=implode(',', $group);
			}
			return empty($groupStr)?'':'group by '.$groupStr;
		}
		
		private function _parseHaving($having){
			$havingStr='';
			if(is_string($having) && !empty($having)){
				$havingStr.=$having;
			}
			return empty($havingStr)?'':'having '.$havingStr;
		}
		
		private function _parseOrder($order){
			$orderStr='';
			if(is_string($order)){
				$orderStr.=$order;
			}elseif (is_array($order)) {
				$orderStr.=implode(',', $order);
			}
			return empty($orderStr)?'':' order by '.$orderStr;
		}
		
		private function _parseLimit($limit){
			$limitStr='';
			if(is_string($limit) && !empty($limit)){
				$limitStr.=$limit;
			}elseif (is_array($limit)) {
				$limitStr.=implode(',', $limit);
			}
			
		}
		private function _free(){
			$this->_pdoStatement=null;
		}
		private function _showError($errorMsg=''){
			$error='<script>alert({$errorMsg});</script>';
		}
	}
	$link=new PdoMySQL('root','123456','test');
	$aaa=$link->op_insert(array(6,'a',1,'cc',300.00),'t1');
	var_dump($aaa);
?>
