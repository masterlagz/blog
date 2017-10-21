<?php
class PostsModel extends Model{
    /**
     * readLists
     * Method that reads all active blog posts
     *
     * @param int $status
     * @param int $offset
     * @param int $limit
     * @return object $result
     */
    public function readLists( $status, $offset = 1, $limit = 15 ){
        $offset = ($offset -1) * $limit;

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".status = {$status}";
        $_results = $this->db->query( $sql );

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".status = {$status} LIMIT {$offset}, {$limit}";
        $_data = $this->db->getLists( $sql );

        $result = new stdClass();
        $result->page   = $offset;
        $result->limit  = $limit;
        $result->total  = $_results->num_rows;
        $result->data   = $_data;

        return $result;
    }

    /**
     * readListByUserId
     * Method that reads all blog posts by user ID
     *
     * @param int $id
     * @param int $offset
     * @param int $limit
     * @return object $result
     */
    public function readListByUserId( $id, $offset = 0, $limit = 15 ){
        $this->validateReadLists( $id );

        $offset = ($offset -1) * $limit;

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".user_id = {$id}";
        $_results = $this->db->query( $sql );

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".user_id = {$id} ORDER BY status DESC LIMIT {$offset}, {$limit}";
        $_data = $this->db->getLists( $sql );

        $result = new stdClass();
        $result->page   = $offset;
        $result->limit  = $limit;
        $result->total  = $_results->num_rows;
        $result->data   = $_data;

        return $result;
    }

    /**
     * readListByPostId
     * Method that reads blog post by post ID
     *
     * @param $post_id
     * @throws Exception
     * @return object $result
     */
    public function readListByPostId( $post_id ) {
        $this->validateReadLists( $post_id );

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->table . ".id = {$post_id}";
        $result = $this->db->getLists( $sql );

        if (!$result) {
            throw new Exception("Invalid post ID!");
        }

        return $result;
    }

    /**
     * insertPosts
     * Method that creates new post
     *
     * @param $params
     * @throws Exception
     * @return int insert_id
     */
    public function insertPosts( $params ){
        $this->validateInsert( $params );

        $sql = "
          INSERT INTO 
            " . $this->table . " (user_id,title,content,status,date) 
          VALUES(
            " . $params["user_id"] . ", 
            '" . $params["title"] . "', 
            '" . $params["content"] . "', 
            " . $params["status"] . ", 
            NOW()
          )
        ";

        $result = $this->db->query( $sql );

        if (!$result) {
            throw new Exception("Unable to insert new post!");
        }

        return $this->db->insertID();
    }

    /**
     * updatePosts
     * Method that updates user post
     *
     * @param $params
     * @throws Exception
     * @return int insert_id
     */
    public function updatePosts( $params ){
        $this->validateInsert( $params );

        $sql = "
          UPDATE 
            " . $this->table . "
          SET 
            title = '" . $params["title"] . "',
            content = '" . $params["content"] . "',
            status = " . $params["status"] . "
          WHERE
            " . $this->table . ".id = " . $params["id"] . "
        ";
        print_r( $sql );
        $result = $this->db->query( $sql );

        if (!$result) {
            throw new Exception("Unable to update new post!");
        }

        return $result;
    }

    /**
     * validateInsert
     * Method that validates post parameters
     *
     * @param $params
     * @throws Exception
     */
    private function validateInsert( $params ) {
        if (isset($params["user_id"]) !== false && !is_int($params["user_id"])) {
            throw new Exception("Invalid user id!");
        }

        if (isset($params["status"]) !== false && !is_int($params["status"])) {
            throw new Exception("Invalid post status!");
        }

        if (isset($params["title"]) !== false && strlen($params["title"]) < 0) {
            throw new Exception("Invalid post title!");
        }

        if (isset($params["content"]) !== false && strlen($params["content"]) < 0) {
            throw new Exception("Invalid user email!");
        }
    }

    /**
     * validateReadLists
     * Method that validates parameter $id
     *
     * @param $id
     * @throws Exception when parameter id is empty or not an integer
     */
    private function validateReadLists( $id ){
        if (isset($id) !== false && !is_int($id)) {
            throw new Exception("Invalid user!");
        }
    }
}
?>