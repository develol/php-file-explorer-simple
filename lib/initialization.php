<?php
    class Initialization {
        static function _main(){
            if(!is_dir("./dir"))
                mkdir("./dir", 0755, true);
                
            if(!is_dir("./dir/_temp"))
                mkdir("./dir/_temp", 0755, true);

            if (!file_exists("./configuration.php"))
                file_put_contents("./configuration.php", " 
                    <?php
                        \$configuration=[
                            \"login\" => \"admin\",
                            \"pwd\"   => \"admin\",
                            \"title\" => \"php-explorer-simple\"
                        ];
                    ?> 
                ");
        }
    }