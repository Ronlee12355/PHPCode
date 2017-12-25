<?php
function removeFile($path){
    $handle=opendir($path);
    while (($item=readdir($handle)) !== false){
        if ($item != '.' && $item !='..'){
            $filename=$path.$item;
            if (is_dir($filename)){
               if(count(scandir($filename)) == 2){
                   rmdir($filename);
               }else{
                   removeFile($filename.'/');
               }
            }elseif (is_file($filename)){
                if ((time() - filectime($filename)) >= 7*24*3600){
                    unlink($filename);
                }
            }
        }
    }
    closedir($handle);
}

$arr=array(
    '/home/www/html/PSO/Excel/Control',
    '/home/www/html/PSO/Excel/Input',
    '/home/www/html/PSO/Excel/Output',
);

foreach ($arr as $path){
    removeFile($path);
}
