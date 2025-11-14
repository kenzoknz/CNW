// Validate form inputs
function validateForm() {
    const id = document.getElementById('id')?.value.trim();
    const name = document.getElementById('name')?.value.trim();
    const age = document.getElementById('age')?.value.trim();
    const university = document.getElementById('university')?.value.trim();

    if (id && !id.match(/^[A-Z0-9]+$/i)) {
        alert('ID chỉ được chứa chữ cái và số!');
        return false;
    }

    if (name && name.length < 3) {
        alert('Tên sinh viên phải có ít nhất 3 ký tự!');
        return false;
    }

    if (age && (isNaN(age) || age < 15 || age > 100)) {
        alert('Tuổi phải là số từ 15 đến 100!');
        return false;
    }

    if (university && university.length < 3) {
        alert('Tên trường đại học phải có ít nhất 3 ký tự!');
        return false;
    }

    return true;
}

// Add event listener to forms
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Handle delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xóa sinh viên này không?')) {
                e.preventDefault();
            }
        });
    });
});

// Format age input
const ageInput = document.getElementById('age');
if (ageInput) {
    ageInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}
