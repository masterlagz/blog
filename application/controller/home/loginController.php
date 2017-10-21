<?php
class LoginController extends Controller {
    var $userModel;

    /**
     * LoginController constructor
     */
    public function __construct(){
        parent::__construct();

        // load model
        $this->userModel = new UserModel("users");
    }

    /**
     * indexAction
     * @return void
     */
    public function indexAction(){
        $this->redirect();
    }

    public function signoutAction(){
        unset($_SESSION["token"]);
        unset($_SESSION["user_id"]);
        exit( json_encode(array("message" => "success")) );
    }

    public function validateAction(){
        $response = array("error" => "");

        try{
            if ($_POST["email"] && $_POST["token"]) {
                // get the current user by email
                $user = $this->userModel->getUserByEmail($_POST["email"]);

                if (!$user) {
                    $params = array(
                        "email" => $_POST["email"],
                        "status" => (int)1,
                    );

                    $_SESSION["user_id"] = $this->userModel->insertUser($params);
                } else {
                    $_SESSION["user_id"] = $user->id;
                }

                $_SESSION["token"] = $_POST["token"];
                $response = array("message" => "Logged In");
            }
        } catch (Exception $e) {
            print_r( $e->getMessage() );
            exit;
        }

        exit( json_encode( $response ) );
    }
}
?>