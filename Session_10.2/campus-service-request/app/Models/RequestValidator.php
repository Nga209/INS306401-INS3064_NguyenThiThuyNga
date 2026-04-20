<?php
// app/Models/RequestValidator.php
class RequestValidator {
    
    // Kiểm tra tiêu đề
    public function validateTitle($title): bool {
        if (empty($title)) {
            return false;
        }
        if (strlen($title) < 5) {
            return false;
        }
        if (strlen($title) > 200) {
            return false;
        }
        return true;
    }
    
    // Kiểm tra mô tả
    public function validateDescription($description): bool {
        if (empty($description)) {
            return false;
        }
        if (strlen($description) < 10) {
            return false;
        }
        if (strlen($description) > 1000) {
            return false;
        }
        return true;
    }
    
    // Kiểm tra trạng thái
    public function validateStatus($status): bool {
        return in_array($status, ['Pending', 'In Progress', 'Done']);
    }
    
    // Kiểm tra tất cả
    public function validateAll($title, $description): array {
        $errors = [];
        
        if (!$this->validateTitle($title)) {
            $errors[] = "Tiêu đề phải từ 5-200 ký tự và không được để trống";
        }
        
        if (!$this->validateDescription($description)) {
            $errors[] = "Mô tả phải từ 10-1000 ký tự và không được để trống";
        }
        
        return $errors;
    }
}