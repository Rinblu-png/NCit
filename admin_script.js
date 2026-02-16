// admin_script.js - Script สำหรับหน้า Admin

// Display Executives Table
function displayExecutivesTable(data) {
    let html = '<table class="data-table"><thead><tr>';
    html += '<th>ชื่อ-นามสกุล</th><th>ตำแหน่ง</th><th>การศึกษา</th><th>ประสบการณ์</th><th>จัดการ</th>';
    html += '</tr></thead><tbody>';

    if (data && data.length > 0) {
        data.forEach(item => {
            html += `<tr>
                <td>${item.avatar_icon} ${item.name}</td>
                <td>${item.position}</td>
                <td>${item.education || '-'}</td>
                <td>${item.experience || '-'}</td>
                <td class="actions">
                    <button class="btn btn-warning" onclick='editItem("executives", ${JSON.stringify(item)})'>แก้ไข</button>
                    <button class="btn btn-danger" onclick="deleteItem('executives', ${item.id})">ลบ</button>
                </td>
            </tr>`;
        });
    } else {
        html += '<tr><td colspan="5" style="text-align:center;">ไม่มีข้อมูล</td></tr>';
    }

    html += '</tbody></table>';
    document.getElementById('executivesTable').innerHTML = html;
}

// Display Staff Table
function displayStaffTable(data) {
    let html = '<table class="data-table"><thead><tr>';
    html += '<th>ชื่อ-นามสกุล</th><th>ตำแหน่ง</th><th>แผนก</th><th>การศึกษา</th><th>จัดการ</th>';
    html += '</tr></thead><tbody>';

    if (data && data.length > 0) {
        data.forEach(item => {
            html += `<tr>
                <td>${item.avatar_icon} ${item.name}</td>
                <td>${item.position}</td>
                <td>${item.department || '-'}</td>
                <td>${item.education || '-'}</td>
                <td class="actions">
                    <button class="btn btn-warning" onclick='editItem("staff", ${JSON.stringify(item)})'>แก้ไข</button>
                    <button class="btn btn-danger" onclick="deleteItem('staff', ${item.id})">ลบ</button>
                </td>
            </tr>`;
        });
    } else {
        html += '<tr><td colspan="5" style="text-align:center;">ไม่มีข้อมูล</td></tr>';
    }

    html += '</tbody></table>';
    document.getElementById('staffTable').innerHTML = html;
}

// Display Students Form
function displayStudentsForm(data) {
    if (!data) {
        document.getElementById('studentsForm').innerHTML = '<p>ไม่พบข้อมูล</p>';
        return;
    }

    let html = `
        <form id="studentsUpdateForm" onsubmit="updateStudentStats(event)">
            <div class="form-group">
                <label>จำนวนนักเรียน นักศึกษาทั้งหมด</label>
                <input type="number" name="total_students" value="${data.total_students || 0}" required>
            </div>
            <div class="form-group">
                <label>จำนวนนักเรียน ระดับ ปวช.</label>
                <input type="number" name="vocational_students" value="${data.vocational_students || 0}" required>
            </div>
            <div class="form-group">
                <label>จำนวนนักเรียน ระดับ ปวส.</label>
                <input type="number" name="diploma_students" value="${data.diploma_students || 0}" required>
            </div>
            <div class="form-group">
                <label>อัตราการมีงานทำ (%)</label>
                <input type="number" step="0.01" name="employment_rate" value="${data.employment_rate || 0}" required>
            </div>
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
        </form>
    `;

    document.getElementById('studentsForm').innerHTML = html;
}

// Display Departments Table
function displayDepartmentsTable(data) {
    let html = '';

    const categories = {
        'พาณิชยกรรม': [],
        'อุตสาหกรรม': [],
        'ศิลปกรรม': [],
        'คหกรรม': []
    };

    // จัดกลุ่มข้อมูล
    for (let category in data) {
        if (categories.hasOwnProperty(category)) {
            categories[category] = data[category];
        }
    }

    // สร้างตารางแต่ละประเภท
    for (let category in categories) {
        if (categories[category].length > 0) {
            html += `<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #667eea;">📚 ${category}</h3>`;
            html += '<table class="data-table"><thead><tr>';
            html += '<th>สาขาวิชา</th><th>ระดับที่เปิดสอน</th><th>จัดการ</th>';
            html += '</tr></thead><tbody>';

            categories[category].forEach(item => {
                html += `<tr>
                    <td>${item.icon} ${item.name}</td>
                    <td>${item.levels}</td>
                    <td class="actions">
                        <button class="btn btn-warning" onclick='editItem("departments", ${JSON.stringify(item).replace(/'/g, "&apos;")})'>แก้ไข</button>
                        <button class="btn btn-danger" onclick="deleteItem('departments', ${item.id})">ลบ</button>
                    </td>
                </tr>`;
            });

            html += '</tbody></table>';
        }
    }

    if (html === '') {
        html = '<p>ไม่มีข้อมูล</p>';
    }

    document.getElementById('departmentsTable').innerHTML = html;
}

// Open Add Modal
function openAddModal(type) {
    editingId = null;
    document.getElementById('modalTitle').textContent = 'เพิ่มข้อมูล';
    
    let fields = '';
    
    switch(type) {
        case 'executives':
            fields = `
                <div class="form-group">
                    <label>ชื่อ-นามสกุล *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง *</label>
                    <input type="text" name="position" required>
                </div>
                <div class="form-group">
                    <label>การศึกษา</label>
                    <input type="text" name="education">
                </div>
                <div class="form-group">
                    <label>ประสบการณ์</label>
                    <input type="text" name="experience">
                </div>
                <div class="form-group">
                    <label>รายละเอียด</label>
                    <textarea name="description"></textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="avatar_icon" value="👨‍💼">
                </div>
            `;
            break;
            
        case 'staff':
            fields = `
                <div class="form-group">
                    <label>ชื่อ-นามสกุล *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง *</label>
                    <input type="text" name="position" required>
                </div>
                <div class="form-group">
                    <label>แผนก</label>
                    <input type="text" name="department">
                </div>
                <div class="form-group">
                    <label>การศึกษา</label>
                    <input type="text" name="education">
                </div>
                <div class="form-group">
                    <label>ความเชี่ยวชาญ</label>
                    <textarea name="expertise"></textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="avatar_icon" value="👨‍🏫">
                </div>
            `;
            break;
            
        case 'departments':
            fields = `
                <div class="form-group">
                    <label>ชื่อสาขาวิชา *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>ประเภท *</label>
                    <select name="category" required>
                        <option value="พาณิชยกรรม">พาณิชยกรรม</option>
                        <option value="อุตสาหกรรม">อุตสาหกรรม</option>
                        <option value="ศิลปกรรม">ศิลปกรรม</option>
                        <option value="คหกรรม">คหกรรม</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ระดับที่เปิดสอน</label>
                    <input type="text" name="levels" value="ปวช. และ ปวส.">
                </div>
                <div class="form-group">
                    <label>ความเชี่ยวชาญ</label>
                    <textarea name="expertise"></textarea>
                </div>
                <div class="form-group">
                    <label>โอกาสทางอาชีพ</label>
                    <textarea name="career_opportunities"></textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="icon" value="📚">
                </div>
            `;
            break;
    }
    
    document.getElementById('formFields').innerHTML = fields;
    document.getElementById('dataModal').classList.add('active');
    
    // Set form submit handler
    document.getElementById('dataForm').onsubmit = (e) => {
        e.preventDefault();
        saveData(type);
    };
}

// Edit Item
function editItem(type, item) {
    editingId = item.id;
    document.getElementById('modalTitle').textContent = 'แก้ไขข้อมูล';
    
    let fields = '';
    
    switch(type) {
        case 'executives':
            fields = `
                <div class="form-group">
                    <label>ชื่อ-นามสกุล *</label>
                    <input type="text" name="name" value="${item.name}" required>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง *</label>
                    <input type="text" name="position" value="${item.position}" required>
                </div>
                <div class="form-group">
                    <label>การศึกษา</label>
                    <input type="text" name="education" value="${item.education || ''}">
                </div>
                <div class="form-group">
                    <label>ประสบการณ์</label>
                    <input type="text" name="experience" value="${item.experience || ''}">
                </div>
                <div class="form-group">
                    <label>รายละเอียด</label>
                    <textarea name="description">${item.description || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="avatar_icon" value="${item.avatar_icon}">
                </div>
            `;
            break;
            
        case 'staff':
            fields = `
                <div class="form-group">
                    <label>ชื่อ-นามสกุล *</label>
                    <input type="text" name="name" value="${item.name}" required>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง *</label>
                    <input type="text" name="position" value="${item.position}" required>
                </div>
                <div class="form-group">
                    <label>แผนก</label>
                    <input type="text" name="department" value="${item.department || ''}">
                </div>
                <div class="form-group">
                    <label>การศึกษา</label>
                    <input type="text" name="education" value="${item.education || ''}">
                </div>
                <div class="form-group">
                    <label>ความเชี่ยวชาญ</label>
                    <textarea name="expertise">${item.expertise || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="avatar_icon" value="${item.avatar_icon}">
                </div>
            `;
            break;
            
        case 'departments':
            fields = `
                <div class="form-group">
                    <label>ชื่อสาขาวิชา *</label>
                    <input type="text" name="name" value="${item.name}" required>
                </div>
                <div class="form-group">
                    <label>ประเภท *</label>
                    <select name="category" required>
                        <option value="พาณิชยกรรม" ${item.category === 'พาณิชยกรรม' ? 'selected' : ''}>พาณิชยกรรม</option>
                        <option value="อุตสาหกรรม" ${item.category === 'อุตสาหกรรม' ? 'selected' : ''}>อุตสาหกรรม</option>
                        <option value="ศิลปกรรม" ${item.category === 'ศิลปกรรม' ? 'selected' : ''}>ศิลปกรรม</option>
                        <option value="คหกรรม" ${item.category === 'คหกรรม' ? 'selected' : ''}>คหกรรม</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ระดับที่เปิดสอน</label>
                    <input type="text" name="levels" value="${item.levels}">
                </div>
                <div class="form-group">
                    <label>ความเชี่ยวชาญ</label>
                    <textarea name="expertise">${item.expertise || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>โอกาสทางอาชีพ</label>
                    <textarea name="career_opportunities">${item.career_opportunities || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>ไอคอน (Emoji)</label>
                    <input type="text" name="icon" value="${item.icon}">
                </div>
            `;
            break;
    }
    
    document.getElementById('formFields').innerHTML = fields;
    document.getElementById('dataModal').classList.add('active');
    
    document.getElementById('dataForm').onsubmit = (e) => {
        e.preventDefault();
        saveData(type);
    };
}

// Save Data
async function saveData(type) {
    const form = document.getElementById('dataForm');
    const formData = new FormData(form);
    
    if (editingId) {
        formData.append('id', editingId);
    }
    formData.append('type', type);
    
    try {
        const response = await fetch('save_data.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert(result.message, 'success');
            closeModal();
            loadData(type);
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
    }
}

// Delete Item
async function deleteItem(type, id) {
    if (!confirm('คุณต้องการลบข้อมูลนี้หรือไม่?')) {
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('type', type);
        formData.append('id', id);
        
        const response = await fetch('delete_data.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert(result.message, 'success');
            loadData(type);
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
    }
}

// Update Student Stats
async function updateStudentStats(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch('update_students.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert(result.message, 'success');
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
    }
}

// Close Modal
function closeModal() {
    document.getElementById('dataModal').classList.remove('active');
    document.getElementById('dataForm').reset();
    editingId = null;
}

// Show Alert
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass}`;
    alertDiv.textContent = message;
    
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Load initial data
document.addEventListener('DOMContentLoaded', () => {
    loadData('executives');
});
