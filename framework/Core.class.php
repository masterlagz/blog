<?php
class Framework {
    /**
     * run
     * @return void
     */
    public static function run() {
        self::init();
        self::autoload();
        self::dispatch();
    }

    /**
     * init
     */
    private static function init() {
        define("DS", DIRECTORY_SEPARATOR);
        define("ROOT", getcwd() . DS);
        define("APP_PATH", ROOT . "application" . DS);
        define("FRAMEWORK_PATH", ROOT . "framework" . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . "helper" . DS);
        //define("PUBLIC_PATH", ROOT . "public" . DS);
        define("CONFIG_PATH", APP_PATH . "config" . DS);
        define("CONTROLLER_PATH", APP_PATH . "controller" . DS);
        define("MODEL_PATH", APP_PATH . "model" . DS);
        define("VIEW_PATH", APP_PATH . "views" . DS);

        // Define platform, controller, action
        // define("CONTROLLER", isset($_REQUEST["c"]) ? $_REQUEST["c"] : "Index");
        define("PLATFORM", "home"); #isset($_REQUEST["p"]) ? $_REQUEST["p"] : "home");
        define("ACTION", isset($_REQUEST["a"]) ? $_REQUEST["a"] : "index");
        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        // Load core classes
        require FRAMEWORK_PATH . "Controller.class.php";
        require FRAMEWORK_PATH . "Loader.class.php";
        require FRAMEWORK_PATH . "Mysql.class.php";
        require FRAMEWORK_PATH . "Model.class.php";

        // Load configuration file
        include CONFIG_PATH . "config.php";

        // Start session
        session_start();
    }

    /**
     * autoload
     * Method for autoloading
     *
     * @return void
     */
    private static function autoload() {
        spl_autoload_register(array(__CLASS__, "load"));
    }

    /**
     * load
     * Method that auto loads app's controller and model
     *
     * @param $classname
     * @return void
     */
    private static function load($classname){
        if (substr($classname, -10) == "Controller") {
            require_once CURR_CONTROLLER_PATH . "$classname.php";
        } elseif (substr($classname, -5) == "Model") {
            require_once  MODEL_PATH . "$classname.php";
        }
    }

    /**
     * dispatch
     * Method that instantiate the controller class and call its action method
     *
     * @return void
     */
    private static function dispatch() {
        $routes = self::route();
        $controller_name = "indexController";
        $action_name = ACTION . "Action";

        if (isset($routes[0]) !== false && $routes[0]) {
            $controller_name = $routes[0] . "Controller";
        }

        if (isset($routes[1]) !== false && $routes[1]) {
            $action_name = $routes[1] . "Action";
        }

        $controller = new $controller_name;
        $controller->$action_name();
    }

    /**
     * @return array $routes
     */
    private static function route() {
        $basepath = implode("/", array_slice(explode("/", $_SERVER["SCRIPT_NAME"]), 0, -1)) . "/";
        $uri = substr($_SERVER["REQUEST_URI"], strlen($basepath));

        if (strstr($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }

        $routes = explode("/", $uri);
        return $routes;
    }
}
?>