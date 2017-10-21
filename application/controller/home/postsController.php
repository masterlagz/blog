<?php
use Michelf\Markdown;

class PostsController extends Controller {
    var $results;
    var $userModel;
    var $postModel;

    /**
     * PostsController constructor
     */
    public function __construct(){
        parent::__construct();

        // verify the session token
        if (!array_key_exists("token", $_SESSION)) {
            $this->redirect();
        }

        $this->userModel = new UserModel("users");
        $this->postModel =  new PostsModel("posts");

        // load helper
        $this->loader->helper("pagination");
        $this->loader->_markdown();
    }

    /**
     * indexAction
     * Method that displays all blog posts by users
     *
     * @param int $page
     * @return void
     */
    public function indexAction($page = 1){
        $page = (isset($_GET["p"]) ? $_GET["p"] : $page);
        $limit = 15;

        try{
            // get the current user
            $user = $this->userModel->getUserById((int)$_SESSION["user_id"]);

			// get all the result set by current user
			$this->results = $this->postModel->readListByUserId((int)$user->id, $page, $limit);
			$this->pagination = pagination("posts", $page, $this->results);

			if (isset($_GET["deleted"]) !== false) {
				$this->success_message = "Post Successfully Deleted!";
			}
        } catch (Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }

        $this->render("user/posts.php");
    }

    /**
     * addAction
     * Method that displays add post page
     *
     * @return void
     */
    public function addAction(){
        $post = ($_POST ? $_POST : "");

        try{
            if ($post) {
                $params = array(
                    "user_id" => (int)$_SESSION["user_id"],
                    "title" => $post["post_title"],
                    "content" => $post["post_content"],
                    "status" => (array_key_exists("post_publish", $post) ? (int)$post["post_publish"] : (int)$post["post_draft"]),
                );

                $insertID = $this->postModel->insertPosts($params);

                if ($insertID) {
                    $this->redirect(Config::BASE_URL . "/posts/edit?id=" . $insertID);
                }
            }
        } catch (Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }

        $this->render("user/posts-add.php");
    }

    /**
     * editAction
     * Method that displays edit post page
     *
     * @return void
     */
    public function editAction(){
        $posts = array();
        $post_id = (int)$_GET["id"];

        try {
            // get all the result set by current user
            $results = $this->postModel->readListByPostId($post_id);

            if ($results) {
                $posts["id"] = $results[0]->id;
                $posts["title"] = $results[0]->title;
                $posts["content"] = Markdown::defaultTransform($results[0]->content);
                $posts["status"] = $results[0]->status;
                $posts["date"] = date("Y-m-d h:i:s", strtotime($results[0]->date));
            }

            $this->results = $posts;
        } catch(Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }

        $this->render("user/posts-edit.php");
    }

    /**
     * updateAction
     * Method that update user post
     *
     * @return void
     */
    public function updateAction(){
        $post = ($_POST ? $_POST : "");

        try{
            $params = array(
                "id" => (int)$post["post_id"],
                "user_id" => (int)$_SESSION["user_id"],
                "title" => $post["post_title"],
                "content" => $post["post_content"],
                "status" => (array_key_exists("post_publish", $post) ? (int)$post["post_publish"] : (int)$post["post_draft"]),
            );

            $result = $this->postModel->updatePosts($params);

            if ($result) {
                $this->redirect(Config::BASE_URL . "/posts/edit?id=" . $post["post_id"]);
            }
        } catch(Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }
    }

	/**
     * deleteAction
     * Method that deletes user post
     *
     * @return void
     */
    public function deleteAction(){
        $post = ($_GET ? $_GET : "");
		
        try{
            $params = array("id" => (int)$post["id"]);
            $result = $this->postModel->deletePosts($params);
			
			if ($result) {
               $this->redirect(Config::BASE_URL . "/posts?deleted=true");
            }
        } catch(Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }
    }
}
?>