<?php
/**
 * API สำหรับดึงข้อมูลบุคลากร
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

try {
    $sql = "SELECT * FROM staff ORDER BY id ASC";
    $result = $conn->query($sql);
    
    $staff = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $staff[] = $row;
        }
    }
    
    // ดึงสถิติบุคลากร
    $stats_sql = "SELECT 
                    COUNT(*) as total_staff,
                    SUM(CASE WHEN position LIKE '%หัวหน้า%' THEN 1 ELSE 0 END) as heads,
                    SUM(CASE WHEN education LIKE '%ปริญญาโท%' THEN 1 ELSE 0 END) as master_degree,
                    SUM(CASE WHEN education LIKE '%ปริญญาเอก%' THEN 1 ELSE 0 END) as phd
                  FROM staff";
    $stats_result = $conn->query($stats_sql);
    $stats = $stats_result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'data' => $staff,
        'stats' => $stats
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>
