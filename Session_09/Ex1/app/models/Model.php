<?php

abstract class Model {
    protected $table = null;
    protected $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    // Common all() method – works for any child class
    public function all() {
        if (!$this->table) {
            throw new Exception("Table name not defined in " . get_class($this));
        }
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Child classes MUST implement their own validation
    abstract public function validate($data);
}