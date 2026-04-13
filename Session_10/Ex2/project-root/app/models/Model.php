<?php

abstract class Model {
    protected $table = null;
    protected $db = null;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    // Phương thức chung cho tất cả model
    public function all() {
        if (!$this->table) {
            throw new Exception("Table name not defined in " . get_class($this));
        }
        
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Phương thức trừu tượng - bắt buộc child class phải implement
    abstract public function validate($data);
}