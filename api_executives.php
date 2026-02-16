<?php
/**
 * API สำหรับดึงข้อมูลผู้บริหาร
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

try {
    $sql = "SELECT * FROM executives ORDER BY id ASC";
    $result = $conn->query($sql);
    
    $executives = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $executives[] = $row;
        }
    }
    
    echo json_encode([
        'success' => true,
        'data' => $executives
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>
