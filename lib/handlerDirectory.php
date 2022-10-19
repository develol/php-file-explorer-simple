<?php
    class HandlerDirectory {
        private function rmDirectory($dir) { 
            if (is_dir($dir)) { 
                $objects = scandir($dir);
                foreach ($objects as $object) { 
                    if ($object != "." && $object != "..") { 
                        if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                            $this->rmDirectory($dir. DIRECTORY_SEPARATOR .$object);
                        else
                            unlink($dir. DIRECTORY_SEPARATOR .$object); 
                    } 
                }
                rmdir($dir); 
            } 
        }

        function deleteDirectory($link, $dirName){
            $this->rmDirectory("./dir".$link."/".$dirName);
            header("Location: ?link=".urlencode($link));
        }

        function createDirectory($link, $dirName){
            $dirName = preg_replace('/[^\x20-\x7E]/','', $dirName);
            mkdir("./dir".$link."/".$dirName, 0755);
            header("Location: ?link=".urlencode($link));
        }
    }
?>