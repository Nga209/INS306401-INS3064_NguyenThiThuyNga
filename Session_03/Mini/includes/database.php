<?php
// Mô phỏng database dưới dạng file JSON
define('USERS_FILE', __DIR__ . '/../data/users.json');

class Database {
    private static $users = null;
    
    public static function getUsers() {
        if (self::$users === null) {
            if (file_exists(USERS_FILE)) {
                $content = file_get_contents(USERS_FILE);
                self::$users = json_decode($content, true) ?: [];
            } else {
                self::$users = [];
            }
        }
        return self::$users;
    }
    
    public static function saveUsers($users) {
        self::$users = $users;
        file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
    }
    
    public static function findUserByEmail($email) {
        $users = self::getUsers();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
    
    public static function createUser($userData) {
        $users = self::getUsers();
        $users[] = $userData;
        self::saveUsers($users);
        return $userData;
    }
    
    public static function updateUser($email, $userData) {
        $users = self::getUsers();
        foreach ($users as &$user) {
            if ($user['email'] === $email) {
                $user = array_merge($user, $userData);
                self::saveUsers($users);
                return $user;
            }
        }
        return null;
    }
}
?>