<?php
class IndexController extends Controller {
    var $result;
    var $postModel;

    /**
     * PostsController constructor
     */
    public function __construct(){
        parent::__construct();

        // load model
        $this->postModel =  new PostsModel("posts");

        // load helper
        $this->loader->helper("pagination");
        $this->loader->_markdown();
    }

    /**
     * indexAction
     * @return void
     */
    public function indexAction($page = 1){
        $page = (isset($_GET["p"]) ? $_GET["p"] : $page);
        $limit = 15;

        try {
            $this->results = $this->postModel->readLists(2, $page, $limit);
            $this->pagination = pagination("index", $page, $this->results);
        } catch (Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }

        $this->render("home/index.php");
    }
}
?>