<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิทยาลัยอาชีวศึกษานครปฐม</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="#" class="logo" onclick="showSection('home')">วิทยาลัยอาชีวศึกษานครปฐม</a>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="#" class="active" onclick="showSection('home')">หน้าหลัก</a></li>
                <li><a href="#" onclick="showSection('executives')">ผู้บริหาร</a></li>
                <li><a href="#" onclick="showSection('staff')">บุคลากร</a></li>
                <li><a href="#" onclick="showSection('students')">นักเรียน</a></li>
                <li><a href="#" onclick="showSection('departments')">สาขาวิชา</a></li>
            </ul>
        </div>
    </nav>

    <!-- Home Section -->
    <div id="home" class="section active">
        <div class="hero">
            <div class="hero-content">
                <h1>วิทยาลัยอาชีวศึกษานครปฐม</h1>
                <p>สถาบันการศึกษาที่มุ่งมั่นพัฒนาคุณภาพการศึกษาและผลิตบุคลากรที่มีความเชี่ยวชาญ</p>
                <a href="#" class="cta-button" onclick="showSection('departments')">สำรวจสาขาวิชา</a>
            </div>
        </div>

        <div class="container">
            <div class="stats" id="homeStats">
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">นักเรียน นักศึกษา</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">คณาจารย์</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">สาขาวิชา</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">45+</div>
                    <div class="stat-label">ปีแห่งความเป็นเลิศ</div>
                </div>
            </div>

            <h2 class="section-title">จุดเด่นของเรา</h2>
            <p class="section-subtitle">เหตุผลที่ควรเลือกเรียนกับเรา</p>

            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon">🎓</div>
                    <h3>หลักสูตรที่ทันสมัย</h3>
                    <p>หลักสูตรการเรียนการสอนที่ได้มาตรฐาน ตอบโจทย์ความต้องการของตลาดแรงงาน พร้อมอุปกรณ์ที่ทันสมัย</p>
                </div>
                <div class="card">
                    <div class="card-icon">👨‍🏫</div>
                    <h3>คณาจารย์มืออาชีพ</h3>
                    <p>ทีมคณาจารย์ที่มีประสบการณ์และความเชี่ยวชาญในสาขาวิชาต่างๆ พร้อมถ่ายทอดความรู้อย่างมีคุณภาพ</p>
                </div>
                <div class="card">
                    <div class="card-icon">🏢</div>
                    <h3>ความร่วมมือกับสถานประกอบการ</h3>
                    <p>มีเครือข่ายความร่วมมือกับสถานประกอบการชั้นนำ เพื่อเปิดโอกาสฝึกงานและการจ้างงาน</p>
                </div>
                <div class="card">
                    <div class="card-icon">🏆</div>
                    <h3>ผลงานที่โดดเด่น</h3>
                    <p>นักเรียนและนักศึกษาได้รับรางวัลระดับชาติและระดับนานาชาติอย่างต่อเนื่อง</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Executives Section -->
    <div id="executives" class="section">
        <div class="container">
            <h2 class="section-title">คณะผู้บริหาร</h2>
            <p class="section-subtitle">ผู้นำองค์กรที่มุ่งมั่นพัฒนาการศึกษา</p>
            <div class="cards-grid" id="executivesContent">
                <div class="loading">กำลังโหลดข้อมูล...</div>
            </div>
        </div>
    </div>

    <!-- Staff Section -->
    <div id="staff" class="section">
        <div class="container">
            <h2 class="section-title">บุคลากร</h2>
            <p class="section-subtitle">ทีมงานที่พร้อมสนับสนุนการเรียนรู้</p>

            <div class="stats" id="staffStats">
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">ครูผู้สอน</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">เจ้าหน้าที่สายสนับสนุน</div>
                </div>
            </div>

            <div class="cards-grid" id="staffContent">
                <div class="loading">กำลังโหลดข้อมูล...</div>
            </div>
        </div>
    </div>

    <!-- Students Section -->
    <div id="students" class="section">
        <div class="container">
            <h2 class="section-title">นักเรียน นักศึกษา</h2>
            <p class="section-subtitle">ข้อมูลและความภาคภูมิใจของสถาบัน</p>

            <div class="stats" id="studentStats">
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">นักเรียน นักศึกษา</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">ระดับ ปวช.</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">-</div>
                    <div class="stat-label">ระดับ ปวส.</div>
                </div>
            </div>

            <h3 style="text-align: center; margin: 3rem 0 2rem; font-size: 2rem; color: #2d3748;">รายชื่อนักเรียน นักศึกษา</h3>
            
            <div id="studentListContent">
                <div class="loading">กำลังโหลดข้อมูล...</div>
            </div>

            <h3 style="text-align: center; margin: 3rem 0 2rem; font-size: 2rem; color: #2d3748;">กิจกรรมนักเรียน นักศึกษา</h3>

            <div class="cards-grid" id="activitiesContent">
                <div class="loading">กำลังโหลดข้อมูล...</div>
            </div>
        </div>
    </div>

    <!-- Departments Section -->
    <div id="departments" class="section">
        <div class="container">
            <h2 class="section-title">สาขาวิชาที่เปิดสอน</h2>
            <p class="section-subtitle">หลากหลายสาขาวิชา ตอบโจทย์ความต้องการของตลาดแรงงาน</p>
            <div id="departmentsContent">
                <div class="loading">กำลังโหลดข้อมูล...</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>วิทยาลัยอาชีวศึกษานครปฐม</h3>
                <p>สถาบันการศึกษาชั้นนำด้านอาชีวศึกษา มุ่งมั่นพัฒนาบุคลากรที่มีคุณภาพสู่สังคม</p>
            </div>
            <div class="footer-section">
                <h3>ติดต่อเรา</h3>
                <p>📍 123 ถนนมาลัยแมน ตำบลพระปฐมเจดีย์<br>
                   อำเภอเมือง จังหวัดนครปฐม 73000</p>
                <p>📞 034-123-456</p>
                <p>✉️ <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fb92959d94bb959a909394958b9a8f939496d59a98d58f93">[email&#160;protected]</a></p>
            </div>
            <div class="footer-section">
                <h3>เวลาทำการ</h3>
                <p>จันทร์ - ศุกร์: 08:00 - 16:30</p>
                <p>เสาร์ - อาทิตย์: ปิดทำการ</p>
                <p style="margin-top: 1rem;"><a href="admin.php" style="color: white; text-decoration: underline;">🔧 จัดการข้อมูล</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 วิทยาลัยอาชีวศึกษานครปฐม. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
