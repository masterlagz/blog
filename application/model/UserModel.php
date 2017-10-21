<?php
class UserModel extends Model{
    /**
     * getUserById
     * Method that retrieves user data by ID
     *
     * @param $id
     * @return null|object
     */
    public function getUserById( $id ){
        $this->validateGetUser( $id );

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".id = {$id}";
        $result = $this->db->getRow( $sql );

        return $result;
    }

    /**
     * getUserByEmail
     * Method that retrieves user data by Email
     *
     * @param $email
     * @return null|object $result
     */
    public function getUserByEmail( $email ){
        $this->validateEmail( $email );

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".email = '{$email}'";
        $result = $this->db->getRow( $sql );

        return $result;
    }

    /**
     * insertUser
     * Method that inserts new user
     *
     * @param $params
     * @throws Exception
     * @return int insert_id
     */
    public function insertUser($params){
        $this->validateInsert( $params );

        $sql = "INSERT INTO " . $this->table . " (email,status,date) VALUES('" . $params["email"] . "', 1, NOW())";
        $result = $this->db->query( $sql );

        if (!$result) {
            throw new Exception("Unable to insert new user!");
        }

        return $this->db->insertID();
    }

    private function validateInsert( $params ) {
        if (isset($params["status"]) !== false && !is_int($params["status"])) {
            throw new Exception("Invalid user!");
        }

        if (isset($params["email"]) !== false && !is_string($params["email"])) {
            throw new Exception("Invalid user email!");
        }

        if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid user email!");
        }
    }

    private function validateGetUser( $id ){
        if (isset($id) !== false && !is_int($id)) {
            throw new Exception("Invalid user!");
        }
    }

    private function validateEmail( $email ){
        if (isset($email) !== false && !is_string($email)) {
            throw new Exception("Invalid user email!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid user email!");
        }
    }
}
?>