<?php
    class UserInterface {
        private function getDirs($root){
            $dirs=scandir("./dir".$root);
            $result=[];
            $i=0;
            foreach($dirs as $dir){
                if(($dir!=".")&&($dir!="..")&&(substr($dir, 0, 1)!=".")){
                    $result[$i]["name"]=$dir;
                    $result[$i]["link"]=$root."/".$dir;
                    $result[$i]["type"]="file";
                    if(is_dir("./dir".$root."/".$dir))
                        $result[$i]["type"]="dir";
                    $i++;
                }
            }
            return $result;
        }

        function login(){
            $result="
                <form action=\"/\" method=\"POST\">
                    <input class=\"loginInput\" name=\"userName\" placeholder=\"User name...\"/>
                    <br>
                    <input class=\"loginInput\" name=\"password\" type=\"password\" placeholder=\"Password...\"/>
                    <br>
                    <input style=\"cursor: pointer;\" class=\"loginInput\" type=\"submit\" value=\"Login\" />
                </form>
            ";
            return $result;
        }

        function uploadFile($root){
            $root=str_replace("..","?",$root);
            $result="
                <div id=\"uploadFile\" style=\"
                    position: absolute;
                    top:  50%;
                    left: 50%;
                    transform: translate(-50%,-50%);
                    background: rgba(128,128,128,0.67);
                    display: none;
                    padding: 2vh;
                    text-align: right;
                \">
                    <input style=\"margin: 0px; margin-bottom: 1%;\" class=\"editorInp\" type=\"button\" value=\"&nbsp;&nbsp;&nbsp;Close&nbsp;&nbsp;&nbsp;\" onclick=\"closeUploader();\"/>
                    <form style=\"margin: 0px;\" enctype=\"multipart/form-data\" action=\"?link=".urlencode($root)."&uploadFile=".urlencode($root)."\" method=\"POST\">
                        <input name=\"uploadFile[]\" type=\"file\" multiple />
                        <input type=\"submit\" value=\"Send file\" />
                    </form>
                </div>
            ";
            return $result;
        }

        function editor(){
            $result="
                <div id=\"divEditor\" style=\"
                    position: absolute;
                    top: 10%;
                    left: 10%;
                    width: 80%;
                    max-height: 80%;
                    background: rgba(128,128,128,0.80);
                    display: none;
                \">
                    <input class=\"editorInp\" type=\"button\" value=\"Save\" id=\"saveEditorBtn\" style=\"margin-left: 2%;\"/>
                    <input class=\"editorInp\" type=\"button\" value=\"Close\" onclick=\"closeEditor();\"/>
                    <input class=\"editorInp\" id=\"inpEditor\" value=\"\" disabled />
                    <textarea id=\"taEditor\" style=\"
                        width: 96%;
                        height: 67vh;
                        margin: 2%;
                        margin-top: 1%;
                        resize: none;
                    \"></textarea>
                </div>
            ";
            return $result;
        }
    
        function explorer($root){
            $root=str_replace("..","?",$root);
            $result="<script>";
                if($root!="")
                    $result.="document.getElementById('title').innerHTML='".$root."';";
                else
                    $result.="document.getElementById('title').innerHTML='/';";
            $result.="</script>";
            if(!is_dir("./dir".$root))
                return "<h1>error</h1>";
            $result.="<h1>";
                if(substr_count($root, "/")>0){
                    $elem0=explode("/", $root);
                    array_pop($elem0);
                    $result.="<a class=\"aBack\" href=\"?link=".urlencode(implode("/", $elem0))."\">🔙</a>&nbsp;";
                }else{
                    $result.="<a class=\"aBack\" style=\"opacity: 0.5;\">🔙</a>&nbsp;";
                }
                $result.="<input style=\"font-size: 1em; padding: 0.1em;\" value=\"".$root."\" disabled>";
            $result.="</h1>";
            $result.="<input class=\"menuBtn\" type=\"button\" value=\"Add directory\" onclick=\"createDirectory('".$root."');\"\>";
            $result.="<input class=\"menuBtn\" type=\"button\" value=\"Add file\" onclick=\"createFile('".$root."');\"\>";
            $result.="<input class=\"menuBtn\" type=\"button\" value=\"Upload file\" onclick=\"uploadFile('".$root."');\"\>";
            $result.="<table>";
            $result.="<tr>";
                $result.="<td colspan=4>";
                    $result.="<hr class=\"tdHr\">";
                $result.="</td>";
            $result.="</tr>";
            $dirs=$this->getDirs($root);
            if(count($dirs)==0){
                $result.="<tr>";
                    $result.="<td>";
                        $result.="<i>Missing files and folders...</i>";
                    $result.="</td>";
                $result.="</tr>";			
            }
            foreach ($dirs as $dir){
                $result.="<tr>";
                    if($dir["type"]=="file"){
                        $result.="<td class=\"tdName\" onclick=\"editFile('".$root."', '".$dir["name"]."');\">";
                            $result.="📄 ".$dir["name"];
                        $result.="</td>";
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"Download\" onclick=\"window.open('?dwld=/dir".urlencode($dir["link"])."');\"\>";
                        $result.="</td>";
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"View\" onclick=\"window.open('/dir".$dir["link"]."');\" \>";
                        $result.="</td>";	
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"Delete\" onclick=\"deleteFile('".$root."', '".$dir["name"]."');\"\>";
                        $result.="</td>";		
                    }
                    if($dir["type"]=="dir"){
                        $result.="<td class=\"tdName\" onclick=\"location.href='?link=".urlencode($dir["link"])."'\">";
                            $result.="<b>"."📁 ".$dir["name"]."</b>";
                        $result.="</td>";
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"Download\" onclick=\"dwldDirectory('".$root."', '".$dir["name"]."')\" \>";
                        $result.="</td>";
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"View\" onclick=\"window.open('/dir".$dir["link"]."');\"\>";
                        $result.="</td>";	
                        $result.="<td class=\"tdBtn\">";
                            $result.="<input type=\"button\" value=\"Delete\" onclick=\"deleteDirectory('".$root."', '".$dir["name"]."');\"\>";
                        $result.="</td>";		
                    }
                $result.="</tr>";
                $result.="<tr>";
                    $result.="<td colspan=4>";
                        $result.="<hr class=\"tdHr\">";
                    $result.="</td>";
                $result.="</tr>";
            }
            $result.="</table>";
            return $result;
        }
    }
?>