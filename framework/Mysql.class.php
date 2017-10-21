<?php
class Mysql {
    /**
     * @var bool DB connection resources
     */
    protected $conn = false;

    /**
     * @var $sql sql statement
     */
    protected $sql;

    /**
     * Mysql constructor.
     *
     * @throws Exception  when invalid connection
     */
    public function __construct(){
        $this->conn = mysqli_connect(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME) or die('Database connection error');

        if (!$this->conn) {
            throw new Exception("Invalid DB Connection!");
        }
    }

    /**
     * setChar
     *
     * @access private
     * @param $charset string charset
     */

    private function setChar($charest) {
        $sql = "SET NAMES " . $charest;
        $this->query($sql);
    }

    /**
     * query
     *
     * @param $sql
     * @throws Exception when invalid query
     * @return bool|mysqli_result
     */
    public function query($sql){
        // set the query
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            throw new Exception("Invalid query!");
        }

        return $result;
    }

    /**
     * getRow
     *
     * @param $sql
     * @throws Exception
     * @return null|object
     */
    public function getRow( $sql ){
        // set the mysql query
        $query = $this->query($sql);

        // get the result set
        $row = mysqli_fetch_object($query);

        return $row;
    }

    public function getLists( $sql ){
        // set the mysql query
        $query = $this->query($sql);
        $lists = array();

        // get the result set
        while ($result = mysqli_fetch_object($query)){
            $lists[] = $result;
        }

        return $lists;
    }

    public function insertID() {
        return $this->conn->insert_id;
    }
}
?>