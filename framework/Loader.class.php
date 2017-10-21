<?php
class Loader{
    // Load library classes
    public function library($lib){
        include FRAMEWORK_PATH . "$lib.class.php";
    }

    // loader helper functions. Naming conversion is xxx_helper.php;
    public function helper($helper){
        include HELPER_PATH . "{$helper}_helper.php";
    }

    // loader helper functions. Naming conversion is xxx_helper.php;
    public function _markdown(){
        include FRAMEWORK_PATH ."/Michelf/Markdown.inc.php";
    }
}
?>