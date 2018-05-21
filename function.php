//check whether it is ajax
function isAjax(){  
       if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){   
           return true;  
       }else{   
           return false;  
       };  
   }

//check the upload files' extension and http uploaded
function check_upload($file) {
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$contentType = $file['type'];
		if (is_uploaded_file($file['tmp_name']) && $ext == 'txt' && $contentType == 'text/plain' && $file['error'] == 0) {
			return true;
		} else {
			return false;
		}
	}
 
 //recursivly make directory
 function mk_dirs($dir) {
		return is_dir($dir) or (mk_dirs(dirname($dir)) and mkdir($dir, 0777));
	}
  
  function get_ip() {
		//strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
		if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$res = preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
		return $res;
	}
  
  
    function trim_data($data) {
		  $data = trim($data);
		  $data = htmlspecialchars($data);
		  $data = strip_tags($data);
		  if(!get_magic_quotes_gpc()){
			  $data = addslashes($data);
		   }
		  return $data;
	}
