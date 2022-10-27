<?php
    class HandlerFile {
        function downloadFile($file, $customName="") {
            if (file_exists($file)) {
                if (ob_get_level())
                    ob_end_clean();
                if($customName=="")
                    $customName = basename($file);
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.$customName);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                if ($fd = fopen($file, 'rb')) {
                    while (!feof($fd)) {
                        print fread($fd, 1024);
                    }
                    fclose($fd);
                }
                exit;
            }
        }

        function uploadFile($files, $link){
            $totalFiles = count($_FILES['uploadFile']['name']);
            for($key = 0; $key < $totalFiles; $key++)
                move_uploaded_file($files['uploadFile']['tmp_name'][$key], "./dir".$link."/".basename($files['uploadFile']['name'][$key]));
            
            header("Location: ?link=".urlencode($link));
        }
        
        function addFileRecursion($zip, $dir, $start = ''){
            if (empty($start)) {
                $start = $dir;
            }
            if ($objs = glob($dir . '/*')) {
                foreach($objs as $obj) { 
                    if (is_dir($obj)) {
                        $this->addFileRecursion($zip, $obj, $start);
                    } else {
                        $zip->addFile($obj, str_replace(dirname($start) . '/', '', $obj));
                    }
                }
            }
        }
    
        function createFile($link, $fileName){
            $fileName = preg_replace('/[^\x20-\x7E]/','', $fileName);
            file_put_contents("./dir".$link."/".$fileName, "");
            header("Location: ?link=".urlencode($link));
        }
    
        function deleteFile($link, $fileName){
            unlink("./dir".$link."/".$fileName);
            header("Location: ?link=".urlencode($link));
        }
    
    
        function saveFile($link, $fileName, $text){
            file_put_contents("dir/".$link."/".$fileName, $text);
            header("Location: ?link=".urlencode($link));
        }
    
        function directoryToZip($link, $dirName){
            $zip = new ZipArchive();
            $aLink="dir/_temp/".$dirName.".zip";
            $zip->open($aLink, ZipArchive::CREATE|ZipArchive::OVERWRITE);
            $this->addFileRecursion($zip, "./dir".$link."/".$dirName);
            $zip->close();
            
            $this->downloadFile($aLink, $dirName."_".date("Y_m_d_H_i_s").".zip");
            header("Location: ?link=".urlencode($link));
        }
    }
?>