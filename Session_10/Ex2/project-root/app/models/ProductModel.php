<?php

class ProductModel extends Model {
    protected $table = 'products';
    
    public function validate($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required';
        } elseif (strlen($data['name']) < 3) {
            $errors['name'] = 'Product name must be at least 3 characters';
        }
        
        if (!isset($data['price'])) {
            $errors['price'] = 'Price is required';
        } elseif (!is_numeric($data['price'])) {
            $errors['price'] = 'Price must be a number';
        } elseif ($data['price'] < 0) {
            $errors['price'] = 'Price must be greater than or equal to 0';
        }
        
        if (!empty($data['stock']) && (!is_numeric($data['stock']) || $data['stock'] < 0)) {
            $errors['stock'] = 'Stock must be a positive number';
        }
        
        return $errors;
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name, price, stock, description, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([
            $data['name'], 
            $data['price'], 
            $data['stock'] ?? 0, 
            $data['description'] ?? ''
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET name = ?, price = ?, stock = ?, description = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'], 
            $data['price'], 
            $data['stock'] ?? 0, 
            $data['description'] ?? '',
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}