<?php
/**
 * update_students.php - อัพเดทข้อมูลนักเรียน
 */

header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

try {
    $total_students = intval($_POST['total_students'] ?? 0);
    $vocational_students = intval($_POST['vocational_students'] ?? 0);
    $diploma_students = intval($_POST['diploma_students'] ?? 0);
    $employment_rate = floatval($_POST['employment_rate'] ?? 0);
    
    // ตรวจสอบว่ามีข้อมูลอยู่แล้วหรือไม่
    $check_sql = "SELECT id FROM students LIMIT 1";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        // Update
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $sql = "UPDATE students SET 
                total_students = $total_students,
                vocational_students = $vocational_students,
                diploma_students = $diploma_students,
                employment_rate = $employment_rate
                WHERE id = $id";
    } else {
        // Insert
        $sql = "INSERT INTO students (total_students, vocational_students, diploma_students, employment_rate)
                VALUES ($total_students, $vocational_students, $diploma_students, $employment_rate)";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'message' => 'อัพเดทข้อมูลนักเรียนเรียบร้อยแล้ว'
        ], JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception('เกิดข้อผิดพลาด: ' . $conn->error);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>
