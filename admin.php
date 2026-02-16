<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูล - วิทยาลัยอาชีวศึกษานครปฐม</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background: #f8f9fa;
            color: #2d3748;
        }

        /* Header */
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .admin-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .admin-header p {
            opacity: 0.9;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .nav-tab {
            padding: 1rem 2rem;
            background: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .nav-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Content Sections */
        .content-section {
            display: none;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: #48bb78;
            color: white;
        }

        .btn-warning {
            background: #ed8936;
            color: white;
        }

        .btn-danger {
            background: #f56565;
            color: white;
        }

        .btn-secondary {
            background: #718096;
            color: white;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table th {
            background: #f7fafc;
            font-weight: 700;
            color: #2d3748;
        }

        .data-table tr:hover {
            background: #f7fafc;
        }

        .data-table .actions {
            display: flex;
            gap: 0.5rem;
        }

        .data-table .actions button {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2d3748;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            font-family: 'Sarabun', sans-serif;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            color: #2d3748;
        }

        .close-modal {
            font-size: 2rem;
            cursor: pointer;
            color: #718096;
            background: none;
            border: none;
        }

        .close-modal:hover {
            color: #2d3748;
        }

        /* Alert */
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #fc8181;
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }

        .loading::after {
            content: '...';
            animation: loading 1s infinite;
        }

        @keyframes loading {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-tabs {
                flex-direction: column;
            }

            .nav-tab {
                width: 100%;
            }

            .data-table {
                font-size: 0.9rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }

            .modal-content {
                padding: 1.5rem;
            }
        }

        .back-to-site {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-to-site:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>🎓 ระบบจัดการข้อมูล</h1>
        <p>วิทยาลัยอาชีวศึกษานครปฐม</p>
    </div>

    <div class="container">
        <div id="alertContainer"></div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showSection('executives')">👨‍💼 ผู้บริหาร</button>
            <button class="nav-tab" onclick="showSection('staff')">👨‍🏫 บุคลากร</button>
            <button class="nav-tab" onclick="showSection('students')">🎓 นักเรียน</button>
            <button class="nav-tab" onclick="showSection('departments')">📚 สาขาวิชา</button>
        </div>

        <!-- Executives Section -->
        <div id="executives" class="content-section active">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>จัดการข้อมูลผู้บริหาร</h2>
                <button class="btn btn-primary" onclick="openAddModal('executives')">+ เพิ่มผู้บริหาร</button>
            </div>
            <div id="executivesTable" class="loading">กำลังโหลดข้อมูล</div>
        </div>

        <!-- Staff Section -->
        <div id="staff" class="content-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>จัดการข้อมูลบุคลากร</h2>
                <button class="btn btn-primary" onclick="openAddModal('staff')">+ เพิ่มบุคลากร</button>
            </div>
            <div id="staffTable" class="loading">กำลังโหลดข้อมูล</div>
        </div>

        <!-- Students Section -->
        <div id="students" class="content-section">
            <h2>จัดการข้อมูลนักเรียน</h2>
            <div id="studentsForm" class="loading">กำลังโหลดข้อมูล</div>
        </div>

        <!-- Departments Section -->
        <div id="departments" class="content-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>จัดการข้อมูลสาขาวิชา</h2>
                <button class="btn btn-primary" onclick="openAddModal('departments')">+ เพิ่มสาขาวิชา</button>
            </div>
            <div id="departmentsTable" class="loading">กำลังโหลดข้อมูล</div>
        </div>
    </div>

    <!-- Modal -->
    <div id="dataModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">เพิ่มข้อมูล</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="dataForm">
                <div id="formFields"></div>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <a href="index.php" class="back-to-site">🏠 กลับสู่เว็บไซต์</a>

    <script>
        let currentSection = 'executives';
        let currentData = null;
        let editingId = null;

        // Show Section
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(sec => {
                sec.classList.remove('active');
            });
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected section
            document.getElementById(section).classList.add('active');
            event.target.classList.add('active');
            currentSection = section;

            // Load data
            loadData(section);
        }

        // Load Data
        async function loadData(section) {
            try {
                let response;
                switch(section) {
                    case 'executives':
                        response = await fetch('api_executives.php');
                        const execData = await response.json();
                        displayExecutivesTable(execData.data);
                        break;
                    case 'staff':
                        response = await fetch('api_staff.php');
                        const staffData = await response.json();
                        displayStaffTable(staffData.data);
                        break;
                    case 'students':
                        response = await fetch('api_students.php');
                        const studData = await response.json();
                        displayStudentsForm(studData.stats);
                        break;
                    case 'departments':
                        response = await fetch('api_departments.php');
                        const deptData = await response.json();
                        displayDepartmentsTable(deptData.data);
                        break;
                }
            } catch (error) {
                console.error('Error loading data:', error);
                showAlert('เกิดข้อผิดพลาดในการโหลดข้อมูล', 'error');
            }
        }

        // Display Tables (ต่อในไฟล์ถัดไป)
        // ... โค้ดส่วนนี้จะต่อในไฟล์ admin_script.js
    </script>
    <script src="admin_script.js"></script>
</body>
</html>
