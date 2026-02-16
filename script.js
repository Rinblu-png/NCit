// script.js - JavaScript สำหรับเว็บไซต์หน้าบ้าน

// Navigation
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });

    // Show selected section
    document.getElementById(sectionId).classList.add('active');

    // Update active nav link
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    event.target.classList.add('active');

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Close mobile menu if open
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.remove('active');

    // Load data for the section
    loadSectionData(sectionId);
}

// Mobile menu toggle
function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('active');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const navMenu = document.getElementById('navMenu');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (!navMenu.contains(event.target) && !menuToggle.contains(event.target)) {
        navMenu.classList.remove('active');
    }
});

// Load section data
async function loadSectionData(sectionId) {
    try {
        switch(sectionId) {
            case 'executives':
                await loadExecutives();
                break;
            case 'staff':
                await loadStaff();
                break;
            case 'students':
                await loadStudents();
                break;
            case 'departments':
                await loadDepartments();
                break;
        }
    } catch (error) {
        console.error('Error loading data:', error);
    }
}

// Load Executives
async function loadExecutives() {
    try {
        const response = await fetch('api_executives.php');
        
        // ตรวจสอบว่า response เป็น JSON หรือไม่
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            console.error('Response is not JSON:', await response.text());
            throw new TypeError("Response is not JSON");
        }
        
        const result = await response.json();
        
        if (result.success && result.data && result.data.length > 0) {
            let html = '';
            result.data.forEach(exec => {
                html += `
                    <div class="profile-card">
                        <div class="profile-avatar">${exec.avatar_icon || '👨‍💼'}</div>
                        <div class="profile-name">${exec.name}</div>
                        <div class="profile-position">${exec.position}</div>
                        <div class="profile-info">
                            ${exec.education ? `<p><strong>การศึกษา:</strong> ${exec.education}</p>` : ''}
                            ${exec.experience ? `<p><strong>ประสบการณ์:</strong> ${exec.experience}</p>` : ''}
                            ${exec.description ? `<p>${exec.description}</p>` : ''}
                        </div>
                    </div>
                `;
            });
            document.getElementById('executivesContent').innerHTML = html;
        } else {
            // ถ้าไม่มีข้อมูลจาก API ให้แสดงข้อความ
            document.getElementById('executivesContent').innerHTML = `
                <div style="text-align:center; padding:3rem; color:#718096;">
                    <p>⚠️ กรุณาตรวจสอบ:</p>
                    <p>1. MySQL ทำงานอยู่ใน XAMPP</p>
                    <p>2. Import ไฟล์ database.sql แล้ว</p>
                    <p>3. เปิดทดสอบ: <a href="test_connection.php" style="color:#667eea;">test_connection.php</a></p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading executives:', error);
        document.getElementById('executivesContent').innerHTML = `
            <div style="text-align:center; padding:3rem; color:#e53e3e;">
                <p>❌ ไม่สามารถโหลดข้อมูลผู้บริหารได้</p>
                <p style="font-size:0.9rem; color:#718096; margin-top:1rem;">
                    กรุณาตรวจสอบการเชื่อมต่อฐานข้อมูล<br>
                    <a href="test_connection.php" style="color:#667eea;">คลิกที่นี่เพื่อทดสอบระบบ</a>
                </p>
            </div>
        `;
    }
}

// Load Staff
async function loadStaff() {
    try {
        const response = await fetch('api_staff.php');
        const result = await response.json();
        
        if (result.success && result.data) {
            // Update stats (เหลือแค่ 2 ค่า)
            if (result.stats) {
                const stats = result.stats;
                document.querySelector('#staffStats .stat-item:nth-child(1) .stat-number').textContent = stats.total_staff || 0;
                document.querySelector('#staffStats .stat-item:nth-child(2) .stat-number').textContent = 0;
            }
            
            // Display staff cards
            let html = '';
            result.data.forEach(staff => {
                html += `
                    <div class="profile-card">
                        <div class="profile-avatar">${staff.avatar_icon}</div>
                        <div class="profile-name">${staff.name}</div>
                        <div class="profile-position">${staff.position}</div>
                        <div class="profile-info">
                            ${staff.education ? `<p>วุฒิการศึกษา: ${staff.education}</p>` : ''}
                            ${staff.expertise ? `<p>ความเชี่ยวชาญ: ${staff.expertise}</p>` : ''}
                        </div>
                    </div>
                `;
            });
            document.getElementById('staffContent').innerHTML = html;
        }
    } catch (error) {
        document.getElementById('staffContent').innerHTML = '<p>ไม่สามารถโหลดข้อมูลได้</p>';
    }
}

// Load Students
async function loadStudents() {
    try {
        const response = await fetch('api_students.php');
        
        // ตรวจสอบว่า response เป็น JSON หรือไม่
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            throw new TypeError("Response is not JSON");
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update stats (เหลือแค่ 3 ค่า)
            if (result.stats) {
                const stats = result.stats;
                document.querySelector('#studentStats .stat-item:nth-child(1) .stat-number').textContent = stats.total_students?.toLocaleString() || '-';
                document.querySelector('#studentStats .stat-item:nth-child(2) .stat-number').textContent = stats.vocational_students?.toLocaleString() || '-';
                document.querySelector('#studentStats .stat-item:nth-child(3) .stat-number').textContent = stats.diploma_students?.toLocaleString() || '-';
            }
            
            // Display student list
            if (result.student_list) {
                let html = '';
                const levelOrder = ['ปวช.1', 'ปวช.2', 'ปวช.3', 'ปวส.1', 'ปวส.2'];
                
                levelOrder.forEach(level => {
                    if (result.student_list[level] && result.student_list[level].length > 0) {
                        html += `
                            <div style="margin-bottom: 3rem;">
                                <h3 style="font-size: 1.8rem; color: #667eea; margin-bottom: 1.5rem; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">
                                    📚 ${level} (${result.student_list[level].length} คน)
                                </h3>
                                <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background: #f7fafc; border-bottom: 2px solid #e2e8f0;">
                                                <th style="padding: 1rem; text-align: left; width: 80px;">ลำดับ</th>
                                                <th style="padding: 1rem; text-align: left; width: 150px;">รหัสนักเรียน</th>
                                                <th style="padding: 1rem; text-align: left;">ชื่อ-นามสกุล</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        
                        result.student_list[level].forEach((student, index) => {
                            html += `
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 1rem;">${index + 1}</td>
                                    <td style="padding: 1rem; font-family: monospace; color: #667eea; font-weight: 600;">${student.student_id}</td>
                                    <td style="padding: 1rem;">${student.name}</td>
                                </tr>
                            `;
                        });
                        
                        html += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    }
                });
                
                document.getElementById('studentListContent').innerHTML = html;
            }
            
            // Display activities
            if (result.activities) {
                let html = '';
                result.activities.forEach(activity => {
                    html += `
                        <div class="card">
                            <div class="card-icon">${activity.icon}</div>
                            <h3>${activity.title}</h3>
                            <p>${activity.description}</p>
                        </div>
                    `;
                });
                document.getElementById('activitiesContent').innerHTML = html;
            }
        }
    } catch (error) {
        console.error('Error:', error);
        // แสดงข้อความเมื่อเกิด error
        document.getElementById('studentListContent').innerHTML = '<p style="text-align:center; color:#e53e3e; padding:2rem;">กรุณาตรวจสอบการเชื่อมต่อฐานข้อมูล</p>';
        document.getElementById('activitiesContent').innerHTML = '<p style="text-align:center; color:#e53e3e;">ไม่สามารถโหลดข้อมูลได้</p>';
    }
}

// Load Departments
async function loadDepartments() {
    try {
        const response = await fetch('api_departments.php');
        const result = await response.json();
        
        if (result.success && result.data) {
            let html = '';
            let totalCredit = 0;
            
            const categoryNames = {
                'วิชาพื้นฐาน': 'รายวิชาพื้นฐาน',
                'วิชาชีพ': 'รายวิชาชีพ'
            };
            
            // เรียงลำดับหมวดหมู่
            const categoryOrder = ['วิชาพื้นฐาน', 'วิชาชีพ'];
            
            // หัวข้อหลัก
            html += '<div style="text-align: center; margin-bottom: 3rem;">';
            html += '<h2 style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;">📚 รายวิชา ปวช.3</h2>';
            html += '<p style="font-size: 1.2rem; color: #718096;">สาขาเทคโนโลยีสารสนเทศ</p>';
            html += '</div>';
            
            categoryOrder.forEach(category => {
                if (result.data[category]) {
                    html += `<h3 style="margin: 2rem 0 1.5rem; font-size: 1.8rem; color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 0.5rem;">${categoryNames[category] || category}</h3>`;
                    
                    html += '<div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">';
                    html += '<table style="width: 100%; border-collapse: collapse;">';
                    html += '<thead><tr style="background: #f7fafc; border-bottom: 2px solid #e2e8f0;">';
                    html += '<th style="padding: 1rem; text-align: left; width: 150px;">รหัสวิชา</th>';
                    html += '<th style="padding: 1rem; text-align: left;">ชื่อวิชา</th>';
                    html += '<th style="padding: 1rem; text-align: center; width: 120px;">หน่วยกิต</th>';
                    html += '</tr></thead><tbody>';
                    
                    result.data[category].forEach(dept => {
                        // แปลง credit เป็น number เพื่อให้แน่ใจว่าคำนวณถูกต้อง
                        const credit = parseInt(dept.credit) || 0;
                        totalCredit += credit;
                        
                        html += `<tr style="border-bottom: 1px solid #e2e8f0;">`;
                        html += `<td style="padding: 1rem; font-family: monospace; color: #667eea; font-weight: 600;">${dept.code}</td>`;
                        html += `<td style="padding: 1rem;">${dept.name}</td>`;
                        html += `<td style="padding: 1rem; text-align: center; font-weight: 600; color: #667eea;">${credit}</td>`;
                        html += `</tr>`;
                    });
                    
                    html += '</tbody></table>';
                    html += '</div>';
                }
            });
            
            // แสดงรวมหน่วยกิตทั้งหมด
            html += '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 12px; text-align: center; margin-top: 3rem;">';
            html += '<h3 style="font-size: 1.8rem; margin-bottom: 0.5rem;">รวมหน่วยกิตทั้งหมด</h3>';
            html += `<div style="font-size: 4rem; font-weight: 700;">${totalCredit}</div>`;
            html += '<p style="font-size: 1.2rem; opacity: 0.95;">หน่วยกิต</p>';
            html += '</div>';
            
            document.getElementById('departmentsContent').innerHTML = html;
        }
    } catch (error) {
        document.getElementById('departmentsContent').innerHTML = '<p>ไม่สามารถโหลดข้อมูลได้</p>';
    }
}

// Load home page stats
async function loadHomeStats() {
    try {
        // Load students stats
        const studentsRes = await fetch('api_students.php');
        const studentsData = await studentsRes.json();
        
        // Load staff stats
        const staffRes = await fetch('api_staff.php');
        const staffData = await staffRes.json();
        
        // Load departments count
        const deptsRes = await fetch('api_departments.php');
        const deptsData = await deptsRes.json();
        
        if (studentsData.success && studentsData.stats) {
            document.querySelector('#homeStats .stat-item:nth-child(1) .stat-number').textContent = 
                (studentsData.stats.total_students?.toLocaleString() + '+') || '49+';
        }
        
        if (staffData.success && staffData.stats) {
            document.querySelector('#homeStats .stat-item:nth-child(2) .stat-number').textContent = 
                (staffData.stats.total_staff + '+') || '3+';
        }
        
        if (deptsData.success && deptsData.stats) {
            const totalDepts = Object.values(deptsData.stats).reduce((a, b) => a + b, 0);
            document.querySelector('#homeStats .stat-item:nth-child(3) .stat-number').textContent = totalDepts || '9';
        }
    } catch (error) {
        console.error('Error loading home stats:', error);
        // แสดงค่าเริ่มต้นถ้า load ไม่ได้
        document.querySelector('#homeStats .stat-item:nth-child(1) .stat-number').textContent = '49+';
        document.querySelector('#homeStats .stat-item:nth-child(2) .stat-number').textContent = '3+';
        document.querySelector('#homeStats .stat-item:nth-child(3) .stat-number').textContent = '9';
    }
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Load home stats
    loadHomeStats();
    
    // โหลดข้อมูลทุกหน้าเลยตอนเปิดเว็บ
    loadExecutives();
    loadStaff();
    loadStudents();
    loadDepartments();
    
    // Add fade-in animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.card, .profile-card, .department-card, .stat-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
