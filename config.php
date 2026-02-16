<?php
/**
 * ไฟล์ config.php
 * การตั้งค่าเชื่อมต่อฐานข้อมูล MySQL
 */

// สำหรับ debug - ถ้าต้องการเห็น error ให้เปลี่ยนเป็น 1
$debug_mode = 0; // เปลี่ยนเป็น 1 เพื่อเปิด debug

if ($debug_mode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // ปิด error display เพื่อไม่ให้รบกวน JSON output
    error_reporting(0);
    ini_set('display_errors', 0);
}

// การตั้งค่าฐานข้อมูล
define('DB_HOST', 'localhost');      // ชื่อ Host
define('DB_USER', 'root');           // ชื่อผู้ใช้ MySQL
define('DB_PASS', '');               // รหัสผ่าน MySQL (ปล่อยว่างถ้าใช้ XAMPP)
define('DB_NAME', 'college'); // ชื่อฐานข้อมูล

// ตั้งค่า Timezone
date_default_timezone_set('Asia/Bangkok');

// เชื่อมต่อฐานข้อมูล
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    // ถ้าเป็น API call ให้ส่ง JSON error
    if (strpos($_SERVER['PHP_SELF'], 'api_') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้',
            'hint' => 'กรุณาตรวจสอบ: 1) MySQL ทำงานอยู่ใน XAMPP 2) Import database.sql แล้ว',
            'error' => $debug_mode ? $conn->connect_error : 'Connection failed'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
}

// ตั้งค่า charset เป็น utf8mb4
if (!$conn->set_charset("utf8mb4")) {
    if (strpos($_SERVER['PHP_SELF'], 'api_') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'ไม่สามารถตั้งค่า charset ได้'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
}

/**
 * ฟังก์ชันป้องกัน SQL Injection
 */
function sanitize($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

/**
 * ฟังก์ชันแสดงข้อความแจ้งเตือน
 */
function setAlert($message, $type = 'success') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * ฟังก์ชันแสดงข้อความแจ้งเตือน
 */
function showAlert() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        echo '<div class="alert alert-' . $alert['type'] . '" role="alert">';
        echo $alert['message'];
        echo '</div>';
        unset($_SESSION['alert']);
    }
}
?>
