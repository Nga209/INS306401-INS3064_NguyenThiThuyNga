<?php
require 'backend/config/config.php';
require 'backend/app/Core/Database.php';
$db = (new Database())->connect();
$stmt = $db->query("SELECT status, COUNT(*) FROM bookings GROUP BY status");
print_r($stmt->fetchAll());
$stmt = $db->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 5");
print_r($stmt->fetchAll());
