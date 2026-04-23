<?php

class ProductController {
    private $model;
    
    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->model = new ProductModel($db);
    }
    
    // READ - Hiển thị danh sách sản phẩm
    public function index() {
        $products = $this->model->all();
        require __DIR__ . '/../views/products/list.php';
    }
    
    // CREATE - Hiển thị form thêm mới
    public function create() {
        require __DIR__ . '/../views/products/create.php';
    }
    
    // CREATE - Xử lý thêm mới
    public function store() {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'stock' => $_POST['stock'] ?? 0,
            'description' => $_POST['description'] ?? ''
        ];
        
        $errors = $this->model->validate($data);
        
        if (empty($errors)) {
            if ($this->model->create($data)) {
                $_SESSION['success'] = "Product created successfully!";
                header('Location: /products');
                exit();
            } else {
                $errors['database'] = "Failed to create product";
            }
        }
        
        // Nếu có lỗi, hiển thị lại form với errors
        require __DIR__ . '/../views/products/create.php';
    }
    
    // EDIT - Hiển thị form sửa
    public function edit($params) {
        $id = $params['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit();
        }
        
        $product = $this->model->find($id);
        if (!$product) {
            header('Location: /products');
            exit();
        }
        
        require __DIR__ . '/../views/products/edit.php';
    }
    
    // EDIT - Xử lý cập nhật
    public function update($params) {
        $id = $params['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit();
        }
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'stock' => $_POST['stock'] ?? 0,
            'description' => $_POST['description'] ?? ''
        ];
        
        $errors = $this->model->validate($data);
        
        if (empty($errors)) {
            if ($this->model->update($id, $data)) {
                $_SESSION['success'] = "Product updated successfully!";
                header('Location: /products');
                exit();
            } else {
                $errors['database'] = "Failed to update product";
            }
        }
        
        // Nếu có lỗi, lấy lại product và hiển thị form với errors
        $product = $this->model->find($id);
        require __DIR__ . '/../views/products/edit.php';
    }
    
    // DELETE - Xóa sản phẩm
    public function delete($params) {
        $id = $params['id'] ?? null;
        if ($id) {
            if ($this->model->delete($id)) {
                $_SESSION['success'] = "Product deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete product";
            }
        }
        
        header('Location: /products');
        exit();
    }
}