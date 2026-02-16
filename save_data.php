<?php
/**
 * save_data.php - บันทึกข้อมูล (เพิ่ม/แก้ไข)
 */

header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

try {
    $type = $_POST['type'] ?? '';
    $id = $_POST['id'] ?? null;
    
    if (empty($type)) {
        throw new Exception('ไม่ระบุประเภทข้อมูล');
    }
    
    switch($type) {
        case 'executives':
            $name = sanitize($conn, $_POST['name']);
            $position = sanitize($conn, $_POST['position']);
            $education = sanitize($conn, $_POST['education'] ?? '');
            $experience = sanitize($conn, $_POST['experience'] ?? '');
            $description = sanitize($conn, $_POST['description'] ?? '');
            $avatar_icon = sanitize($conn, $_POST['avatar_icon'] ?? '👨‍💼');
            
            if ($id) {
                // Update
                $sql = "UPDATE executives SET 
                        name = '$name',
                        position = '$position',
                        education = '$education',
                        experience = '$experience',
                        description = '$description',
                        avatar_icon = '$avatar_icon'
                        WHERE id = $id";
                $message = 'แก้ไขข้อมูลผู้บริหารเรียบร้อยแล้ว';
            } else {
                // Insert
                $sql = "INSERT INTO executives (name, position, education, experience, description, avatar_icon)
                        VALUES ('$name', '$position', '$education', '$experience', '$description', '$avatar_icon')";
                $message = 'เพิ่มข้อมูลผู้บริหารเรียบร้อยแล้ว';
            }
            break;
            
        case 'staff':
            $name = sanitize($conn, $_POST['name']);
            $position = sanitize($conn, $_POST['position']);
            $department = sanitize($conn, $_POST['department'] ?? '');
            $education = sanitize($conn, $_POST['education'] ?? '');
            $expertise = sanitize($conn, $_POST['expertise'] ?? '');
            $avatar_icon = sanitize($conn, $_POST['avatar_icon'] ?? '👨‍🏫');
            
            if ($id) {
                // Update
                $sql = "UPDATE staff SET 
                        name = '$name',
                        position = '$position',
                        department = '$department',
                        education = '$education',
                        expertise = '$expertise',
                        avatar_icon = '$avatar_icon'
                        WHERE id = $id";
                $message = 'แก้ไขข้อมูลบุคลากรเรียบร้อยแล้ว';
            } else {
                // Insert
                $sql = "INSERT INTO staff (name, position, department, education, expertise, avatar_icon)
                        VALUES ('$name', '$position', '$department', '$education', '$expertise', '$avatar_icon')";
                $message = 'เพิ่มข้อมูลบุคลากรเรียบร้อยแล้ว';
            }
            break;
            
        case 'departments':
            $name = sanitize($conn, $_POST['name']);
            $category = sanitize($conn, $_POST['category']);
            $icon = sanitize($conn, $_POST['icon'] ?? '📚');
            $levels = sanitize($conn, $_POST['levels'] ?? 'ปวช. และ ปวส.');
            $expertise = sanitize($conn, $_POST['expertise'] ?? '');
            $career_opportunities = sanitize($conn, $_POST['career_opportunities'] ?? '');
            
            if ($id) {
                // Update
                $sql = "UPDATE departments SET 
                        name = '$name',
                        category = '$category',
                        icon = '$icon',
                        levels = '$levels',
                        expertise = '$expertise',
                        career_opportunities = '$career_opportunities'
                        WHERE id = $id";
                $message = 'แก้ไขข้อมูลสาขาวิชาเรียบร้อยแล้ว';
            } else {
                // Insert
                $sql = "INSERT INTO departments (name, category, icon, levels, expertise, career_opportunities)
                        VALUES ('$name', '$category', '$icon', '$levels', '$expertise', '$career_opportunities')";
                $message = 'เพิ่มข้อมูลสาขาวิชาเรียบร้อยแล้ว';
            }
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
