<?php
/**
 * debug_api.php - Debug API และหาสาเหตุ Error 500
 */

// เปิด error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>🔍 Debug API - ตรวจสอบปัญหา Error 500</h2>";
echo "<hr>";

// 1. ตรวจสอบไฟล์ config.php
echo "<h3>1. ตรวจสอบ config.php</h3>";
if (!file_exists('config.php')) {
    die("<p style='color:red;'>❌ ไม่พบไฟล์ config.php</p>");
}
echo "<p>✅ พบไฟล์ config.php</p>";

// 2. โหลด config
echo "<h3>2. โหลด config.php</h3>";
try {
    // ปิด error suppression ชั่วคราว
    ini_set('display_errors', 1);
    require_once 'config.php';
    echo "<p>✅ โหลด config.php สำเร็จ</p>";
} catch (Exception $e) {
    die("<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>");
}

// 3. ตรวจสอบการเชื่อมต่อ
echo "<h3>3. ตรวจสอบการเชื่อมต่อฐานข้อมูล</h3>";
if ($conn->connect_error) {
    die("<p style='color:red;'>❌ เชื่อมต่อไม่ได้: " . $conn->connect_error . "</p>");
}
echo "<p>✅ เชื่อมต่อสำเร็จ</p>";
echo "<p>Database: <strong>" . DB_NAME . "</strong></p>";

// 4. ตรวจสอบตารางทั้งหมด
echo "<h3>4. ตรวจสอบตาราง</h3>";
$tables = ['executives', 'staff', 'students', 'student_list', 'departments', 'student_activities'];
$missing_tables = [];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        $count = $conn->query("SELECT COUNT(*) as cnt FROM $table")->fetch_assoc()['cnt'];
        echo "<p>✅ ตาราง <strong>$table</strong>: $count records</p>";
    } else {
        echo "<p style='color:red;'>❌ ไม่พบตาราง <strong>$table</strong></p>";
        $missing_tables[] = $table;
    }
}

if (!empty($missing_tables)) {
    echo "<div style='background:#fed7d7; padding:1rem; border-radius:8px; margin:1rem 0;'>";
    echo "<strong>⚠️ ตารางที่หายไป:</strong> " . implode(', ', $missing_tables);
    echo "<p>กรุณา Import ไฟล์ database.sql ใน phpMyAdmin</p>";
    echo "</div>";
}

// 5. ทดสอบ Query แต่ละ API
echo "<h3>5. ทดสอบ Query API</h3>";

// Test executives
echo "<h4>📌 API Executives</h4>";
try {
    $sql = "SELECT * FROM executives ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result) {
        echo "<p>✅ Query สำเร็จ: " . $result->num_rows . " records</p>";
        if ($result->num_rows > 0) {
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li>{$row['name']} - {$row['position']}</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red;'>❌ Query ล้มเหลว: " . $conn->error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

// Test staff
echo "<h4>📌 API Staff</h4>";
try {
    $sql = "SELECT * FROM staff ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result) {
        echo "<p>✅ Query สำเร็จ: " . $result->num_rows . " records</p>";
    } else {
        echo "<p style='color:red;'>❌ Query ล้มเหลว: " . $conn->error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

// Test students
echo "<h4>📌 API Students</h4>";
try {
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);
    if ($result) {
        echo "<p>✅ students: " . $result->num_rows . " records</p>";
    }
    
    $sql2 = "SELECT COUNT(*) as cnt FROM student_list";
    $result2 = $conn->query($sql2);
    if ($result2) {
        $cnt = $result2->fetch_assoc()['cnt'];
        echo "<p>✅ student_list: $cnt records</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

// Test departments
echo "<h4>📌 API Departments</h4>";
try {
    $sql = "SELECT * FROM departments ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result) {
        echo "<p>✅ Query สำเร็จ: " . $result->num_rows . " records</p>";
    } else {
        echo "<p style='color:red;'>❌ Query ล้มเหลว: " . $conn->error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

// 6. ทดสอบ JSON output
echo "<h3>6. ทดสอบ JSON Encode</h3>";
try {
    $test_data = [
        'success' => true,
        'message' => 'ทดสอบ JSON',
        'data' => ['name' => 'นายวุฒิชัย รักชาติ']
    ];
    $json = json_encode($test_data, JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        echo "<p style='color:red;'>❌ JSON encode ล้มเหลว: " . json_last_error_msg() . "</p>";
    } else {
        echo "<p>✅ JSON encode สำเร็จ</p>";
        echo "<pre>" . htmlspecialchars($json) . "</pre>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}

$conn->close();

echo "<hr>";
echo "<h3>✅ สรุป</h3>";
if (empty($missing_tables)) {
    echo "<p style='color:green;'>✅ ระบบพร้อมใช้งาน!</p>";
    echo "<p><a href='index.php'>ไปยังหน้าเว็บไซต์</a></p>";
} else {
    echo "<p style='color:red;'>⚠️ กรุณา Import database.sql ใน phpMyAdmin</p>";
}
?>
