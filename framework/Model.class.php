<?php
class Model{
    protected $db;
    protected $table;
    protected $fields = array();

    /**
     * Model constructor
     * @param $table
     */
    public function __construct($table){
        $this->db = new Mysql();
        $this->table = $table;
        $this->getFields();
    }

    public function insert() {
    }

    private function getFields(){
    }

    private function validateLists($params){
    }
}
?>