<?php
	//缓存类
	class Mem{
		protected $type='Memcached';
		protected $m;
		protected $error;
		public function __construct(){
			if(!class_exists($this->type)){
				echo 'NO'.$this->type;
				return false;
			}else{
				$this->m=new $this->type();
			}
		}
		private function addServer($arr){//添加服务器
			$this->m->addServers($arr);
		}
		
		public function S($key,$value='',$time=0){//主方法
			$number=func_num_args();
			if($number==1){
				return $this->get($key);
			}elseif($number>=2){
				if($value===NULL){
					 $this->delete($key,$time);
				}else{
					 $this->set($key,$value,$time);
				}
			}
		}
		private function getError(){
			if($this->error){
				return $this->error;
			}else{
				return $this->m->getMessageCode();
			}
		}
		private function get($key){
			$data=$this->m->get($key);
			if($this->m->getMessageCode()!=0){
				return false;
			}else{
				return $data;
			}
		}
		
		private function set($key,$value,$time){
			$this->m->set($key,$value,$time);
		}
		
		private function delete($key,$time){
			$this->m->delete($key,$time);
		}
		$mem=new Mem();
		//return的问题：层层返回才可以取到值，如果方法返回的是true或是false，就可以不用
	}
?>
