<?php
// app/Models/User.php
class User {
    public $id;
    public $email;
    public $full_name;
    public $role; // 'student', 'staff', 'admin'
    public $created_at;
    
    public function __construct($email = '', $full_name = '', $role = 'student') {
        $this->email = $email;
        $this->full_name = $full_name;
        $this->role = $role;
    }
    
    public static function fromArray($data) {
        $user = new User();
        $user->id = $data['id'] ?? null;
        $user->email = $data['email'] ?? '';
        $user->full_name = $data['full_name'] ?? '';
        $user->role = $data['role'] ?? 'student';
        $user->created_at = $data['created_at'] ?? '';
        return $user;
    }
    
    public function isStaff() {
        return in_array($this->role, ['staff', 'admin']);
    }
    
    public function isAdmin() {
        return $this->role === 'admin';
    }
}