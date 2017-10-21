<?php
// BaseController
class Controller{
    // Base Controller has a property called $loader,
    // it is an instance of Loader class(introduced later)
    protected $loader;
    var $hide = false;

    /**
     * Class constructor
     */
    public function __construct(){
        $this->loader = new Loader();
    }

    /**
     * redirect
     *
     * @param $url
     * @return void
     */
    public function redirect($url = ""){
        $redirect = Config::BASE_URL;

        if ($url){
            $redirect = $url;
        }

        header("Location: " . $redirect);
        exit;
    }

    public function render($view, $args = []){
        $page = substr($view, strpos($view, "user"), 4);
        if ($page == "user") { $this->hide = true; }

        include VIEW_PATH . "common/header.php";

        $file = VIEW_PATH . "/$view";
        if (is_readable($file)) {
            require $file;
        }

        include VIEW_PATH . "common/footer.php";
    }
}
?>