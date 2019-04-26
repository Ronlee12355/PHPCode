<?php
/**
 * Created by PhpStorm.
 * User: ronlee
 * Date: 2019/4/25
 * Time: 16:16
 */

class DB {
    private static $_db = false;
    private static $_dbSource = false;
    private static $_config=array('dsn'=>'mysql:host=localhost;dbname=drugfitness;charset=utf8','user'=>'root','passwd'=>'123456');
    private function __construct() {
    }

    private function __clone() {
        die('clone of this DB is not allowed');
    }

    public static function getInstance(){
        if(!(self::$_db instanceof self)){
            self::$_db = new self();
        }
        return self::$_db;
    }

    public function getConnect($origin=false){
        if (!self::$_dbSource){
            try{
                self::$_dbSource = new PDO(self::$_config['dsn'],self::$_config['user'],self::$_config['passwd']);
                self::$_dbSource->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                self::$_dbSource->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            }catch (PDOException $e){
                die("数据库连接出错： ".$e->getMessage());
            }
        }
        return $origin?self::$_dbSource:self::$_db;
    }

    public function insert($table, $data){
        $value = 'NULL,';
        $condition = 'id,';
        foreach ($data as $key=>$v){
            $condition.=$key.',';
            $value.='\''.$v.'\',';
        }
        $condition = trim($condition,',');
        $value = trim($value,',');
        $sql = 'INSERT INTO '.$table.' ('.$condition.') VALUES ('.$value.')';
        $res = self::$_dbSource->exec($sql);
        return $res;
    }

    public function update($table, $data, $where){
        $update = $this->parseUpdate($data);
        $w = $this->parseWhere($where);

        $sql = 'UPDATE '.$table.' SET '.$update.' WHERE '.$w;
        $res = self::$_dbSource->exec($sql);
        return $res;
    }

    public function select($table, $field ='*',$where, $limit=1){
        $w = $this->parseWhere($where);
        $Field = $this->parseField($field);
        $sql = 'SELECT '.$Field.' FROM '.$table.' WHERE '.$w.' LIMIT '.$limit;

        $res = self::$_dbSource->query($sql)->fetchAll();
        return $res;
    }

    public function getCount($table, $where=array()){
        if(count($where) != 0){
            $w = $this->parseWhere($where);
            $sql = 'SELECT COUNT(id) AS total FROM '.$table.' WHERE '.$w;
        }else{
            $sql = 'SELECT COUNT(id) AS total FROM '.$table;
        }
        $res = self::$_dbSource->query($sql)->fetchAll();
        return intval($res[0]['total']);
    }

    public function has($table, $where=array()){
        $w = $this->parseWhere($where);
        $sql = 'SELECT * FROM '.$table.' WHERE '.$w;

        $res = self::$_dbSource->query($sql)->fetchAll();
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function delete($table, $where=array()){
        $w = $this->parseWhere($where);
        $sql = 'DELETE FROM '.$table.' WHERE '.$w;
        $res = self::$_dbSource->exec($sql);
        return $res;
    }

    public function error(){
        return self::$_dbSource->errorInfo();
    }

    public function info(){
        $output = array(
            'server' => 'SERVER_INFO',
            'driver' => 'DRIVER_NAME',
            'client' => 'CLIENT_VERSION',
            'version' => 'SERVER_VERSION',
            'connection' => 'CONNECTION_STATUS'
        );
        foreach ($output as $key => $value) {
            $output[$key] = self::$_dbSource->getAttribute(constant('PDO::ATTR_' . $value));
        }
        $output['dsn'] = self::$_config['dsn'];
        return $output;
    }

    private function parseWhere($where=array()){
        $w='';
        foreach ($where as $k=>$value){
            $w.=$k.'=\''.$value.'\' AND ';
        }
        return trim($w,' AND ');
    }

    private function parseField($field){
        $res = NULL;
        if(is_string($field) && $field == '*'){
            $res = '*';
        }elseif (is_array($field)){
            $res = implode(',',$field);
        }
        return $res;
    }

    private function parseUpdate($data=array()){
        $update = '';
        foreach ($data as $key=>$v){
            if(is_array($v)){
                $update.=$key.'='.$key.implode('',$v).',';
            }else{
                $update.=$key.'=\''.$v.'\',';
            }
        }
        $update = trim($update,',');
        return $update;
    }
}
