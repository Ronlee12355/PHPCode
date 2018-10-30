<?php
    $files=array('./about.php','./guide.php');
    $zipFile='./aaa.zip';
    $zip=new ZipArchive();
    if($zip->open($zipFile,ZipArchive::CREATE) == TRUE){
        foreach ($files as $a){
            $zip->addFromString(basename($a),file_get_contents($a));
        }
        $zip->close();
    }
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.basename($zipFile));
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);
    unlink($zipFile);
