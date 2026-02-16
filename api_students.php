<?php
/**
 * API สำหรับดึงข้อมูลนักเรียนและกิจกรรม
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

try {
    // ดึงสถิตินักเรียน
    $sql = "SELECT * FROM students ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    $student_stats = $result->fetch_assoc();
    
    // ดึงข้อมูลกิจกรรม
    $activities_sql = "SELECT * FROM student_activities ORDER BY id ASC";
    $activities_result = $conn->query($activities_sql);
    
    $activities = [];
    if ($activities_result->num_rows > 0) {
        while($row = $activities_result->fetch_assoc()) {
            $activities[] = $row;
        }
    }
    
    // ดึงรายชื่อนักเรียน
    $student_list_sql = "SELECT * FROM student_list ORDER BY level ASC, student_id ASC";
    $student_list_result = $conn->query($student_list_sql);
    
    $student_list = [];
    if ($student_list_result->num_rows > 0) {
        while($row = $student_list_result->fetch_assoc()) {
            $level = $row['level'];
            if (!isset($student_list[$level])) {
                $student_list[$level] = [];
            }
            $student_list[$level][] = $row;
        }
    }
    
    echo json_encode([
        'success' => true,
        'stats' => $student_stats,
        'activities' => $activities,
        'student_list' => $student_list
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>
