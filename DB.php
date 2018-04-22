<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/4/22
 * Time: 13:18
 */
/*
 * 单例模式编写数据库借口
 */
class DB{
    static private $_instance;
    static private $_dbSource;
    private $_config=array('host'=>'localhost','user'=>'root','passwd'=>'123456','dbname'=>'tdb');
    private function __construct(){

    }

    /**
     * @return mixed
     */
    public static function getInstance() {
        if (!self::$_instance instanceof self){
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    /*
     * get database connection
     */
    public function connectMysql($config=array()){
        if(count($config) != 0){
            $this->_config=$config;
        }
        if(!self::$_dbSource){
            self::$_dbSource=new mysqli($this->_config['host'],$this->_config['user'],$this->_config['passwd'],$this->_config['dbname']);
            if (self::$_dbSource->errno){
                die('Database Connect Error '.self::$_dbSource->connect_error);
            }
            self::$_dbSource->set_charset('UTF8');
        }
        return self::$_dbSource;
    }
}
