<?php

class ProductModel extends Model {
    protected $table = 'products';

    public function validate($data) {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required';
        }
        if (!isset($data['price']) || $data['price'] < 0) {
            $errors['price'] = 'Price must be a positive number';
        }
        return $errors;
    }

    // Additional product-specific methods (create, update, delete, find)
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, price) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['price']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = ?, price = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['price'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}