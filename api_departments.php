<?php
/**
 * API สำหรับดึงข้อมูลสาขาวิชา
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

try {
    // ดึงข้อมูลสาขาวิชาทั้งหมด
    $sql = "SELECT * FROM departments ORDER BY 
            FIELD(category, 'พาณิชยกรรม', 'อุตสาหกรรม', 'ศิลปกรรม', 'คหกรรม'), 
            id ASC";
    $result = $conn->query($sql);
    
    $departments = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $category = $row['category'];
            if (!isset($departments[$category])) {
                $departments[$category] = [];
            }
            $departments[$category][] = $row;
        }
    }
    
    // สถิติสาขาวิชา
    $stats_sql = "SELECT category, COUNT(*) as count FROM departments GROUP BY category";
    $stats_result = $conn->query($stats_sql);
    $stats = [];
    while($row = $stats_result->fetch_assoc()) {
        $stats[$row['category']] = $row['count'];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $departments,
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
