<?php
/**
 * delete_data.php - ลบข้อมูล
 */

header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

try {
    $type = $_POST['type'] ?? '';
    $id = $_POST['id'] ?? null;
    
    if (empty($type) || empty($id)) {
        throw new Exception('ข้อมูลไม่ครบถ้วน');
    }
    
    switch($type) {
        case 'executives':
            $sql = "DELETE FROM executives WHERE id = $id";
            $message = 'ลบข้อมูลผู้บริหารเรียบร้อยแล้ว';
            break;
            
        case 'staff':
            $sql = "DELETE FROM staff WHERE id = $id";
            $message = 'ลบข้อมูลบุคลากรเรียบร้อยแล้ว';
            break;
            
        case 'departments':
            $sql = "DELETE FROM departments WHERE id = $id";
            $message = 'ลบข้อมูลสาขาวิชาเรียบร้อยแล้ว';
            break;
            
        default:
            throw new Exception('ประเภทข้อมูลไม่ถูกต้อง');
    }
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'message' => $message
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
