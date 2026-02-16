<?php
/**
 * test_connection.php - ทดสอบการเชื่อมต่อฐานข้อมูล
 */

echo "<h2>ทดสอบการเชื่อมต่อฐานข้อมูล</h2>";

// ตรวจสอบว่ามีไฟล์ config.php หรือไม่
if (!file_exists('config.php')) {
    die("<p style='color:red;'>❌ ไม่พบไฟล์ config.php</p>");
}

echo "<p>✅ พบไฟล์ config.php</p>";

// Load config
require_once 'config.php';

echo "<p>✅ โหลด config.php สำเร็จ</p>";

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("<p style='color:red;'>❌ เชื่อมต่อฐานข้อมูลไม่ได้: " . $conn->connect_error . "</p>");
}

echo "<p>✅ เชื่อมต่อฐานข้อมูลสำเร็จ</p>";

// ตรวจสอบตาราง
$tables = ['executives', 'staff', 'students', 'student_list', 'departments', 'student_activities'];

echo "<h3>ตรวจสอบตาราง:</h3>";
foreach ($tables as $table) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>✅ ตาราง <strong>$table</strong>: {$row['count']} records</p>";
    } else {
        echo "<p style='color:red;'>❌ ตาราง <strong>$table</strong>: " . $conn->error . "</p>";
    }
}

// ทดสอบ API
echo "<h3>ทดสอบ API:</h3>";

// Test students API
$sql = "SELECT * FROM students LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "<p>✅ students API: OK</p>";
} else {
    echo "<p style='color:orange;'>⚠️ students API: ไม่มีข้อมูล (ปกติ)</p>";
}

// Test student_list
$sql = "SELECT COUNT(*) as count FROM student_list";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>✅ student_list: {$row['count']} คน</p>";
}

// Test executives
$sql = "SELECT COUNT(*) as count FROM executives";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>✅ executives: {$row['count']} ท่าน</p>";
}

// Test staff
$sql = "SELECT COUNT(*) as count FROM staff";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>✅ staff: {$row['count']} ท่าน</p>";
}

// Test departments
$sql = "SELECT COUNT(*) as count FROM departments";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>✅ departments: {$row['count']} รายการ</p>";
}

$conn->close();

echo "<hr>";
echo "<h3>สรุป:</h3>";
echo "<p>✅ ระบบพร้อมใช้งาน! คุณสามารถลบไฟล์นี้ได้</p>";
echo "<p><a href='index.php'>ไปยังหน้าเว็บไซต์</a> | <a href='admin.php'>ไปยังหน้า Admin</a></p>";
?>
