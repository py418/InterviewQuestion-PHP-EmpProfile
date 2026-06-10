/**
 * Employee Onboarding Form - Frontend Script
 * Location: /js/validate.js
 * Pure ES6 Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ─────────────────────────────────────────
       1. ELEMENT SELECTORS
    ───────────────────────────────────────── */

    const onboardingForm       = document.getElementById('onboarding-form');

    // Personal
    const inputFullName        = document.getElementById('fullName');
    const selectGender         = document.getElementById('gender');
    const selectMaritalStatus  = document.getElementById('maritalStatus');
    const inputDob             = document.getElementById('dob');
    const inputNationality     = document.getElementById('nationality');

    // Contact
    const inputPhone           = document.getElementById('phone');
    const inputEmail           = document.getElementById('email');
    const textareaAddress      = document.getElementById('address');

    // Employment
    const inputEmpId           = document.getElementById('empId');
    const selectEmpType        = document.getElementById('employmentType');
    const selectDept           = document.getElementById('department');
    const inputJobTitle        = document.getElementById('jobTitle');
    const inputHireDate        = document.getElementById('hireDate');

    // Emergency
    const inputEmergencyName   = document.getElementById('emergencyName');
    const inputEmergencyRelation = document.getElementById('emergencyRelation');
    const inputEmergencyPhone  = document.getElementById('emergencyPhone');

    // Avatar
    const hiddenAvatarUrl      = document.getElementById('avatarUrl');
    const avatarButtons        = document.querySelectorAll('.avatar-btn');

    // Live Badge Preview
    const previewName          = document.getElementById('preview-name');
    const previewTitle         = document.getElementById('preview-title');
    const previewEmpId         = document.getElementById('preview-empid');
    const previewDept          = document.getElementById('preview-dept');
    const previewType          = document.getElementById('preview-type');
    const previewEmail         = document.getElementById('preview-email');
    const previewAvatar        = document.getElementById('preview-avatar');

    // Buttons & Modal
    const btnRegenId           = document.getElementById('btn-regen-id');
    const btnResetForm         = document.getElementById('btn-reset-form');
    const btnClearForm         = document.getElementById('btn-clear');
    const modalSuccess         = document.getElementById('modal-success');
    const modalEmpName         = document.getElementById('modal-emp-name');
    const btnCloseModal        = document.getElementById('btn-close-modal');

    // Avatar preset URLs
    const avatarUrls = [
        "https://plus.unsplash.com/premium_photo-1739178656537-ea88ababab9b?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://plus.unsplash.com/premium_photo-1739178656567-068b26a4b979?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://plus.unsplash.com/premium_photo-1739178656557-16b949fea186?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://plus.unsplash.com/premium_photo-1739178656495-8109a8bc4f53?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    ];

    /* ─────────────────────────────────────────
       POPULATE COUNTRY DROPDOWNS
    ───────────────────────────────────────── */
    function populateCountryDropdowns() {
        const nationalitySelect = document.getElementById('nationality');
        const phoneCodeSelect   = document.getElementById('phoneCode');

        if (!nationalitySelect || !phoneCodeSelect) return;

        // Clear existing options
        nationalitySelect.innerHTML = '<option value="">Select Nationality</option>';
        phoneCodeSelect.innerHTML   = '';

        COUNTRIES.forEach(country => {
            // Nationality dropdown
            const natOption    = document.createElement('option');
            natOption.value    = country.name;
            natOption.textContent = country.name;
            nationalitySelect.appendChild(natOption);

            // Phone code dropdown
            const phoneOption     = document.createElement('option');
            phoneOption.value     = country.dial;
            phoneOption.textContent = `${country.name} (${country.dial})`;
            // Default to Malaysia
            if (country.code === 'MY') phoneOption.selected = true;
            phoneCodeSelect.appendChild(phoneOption);
        });
    }

    /* ─────────────────────────────────────────
       PHONE NUMBER COMBINER
    ───────────────────────────────────────── */
    function bindPhoneListener() {
        const phoneCode   = document.getElementById('phoneCode');
        const phoneNumber = document.getElementById('phoneNumber');
        const phoneHidden = document.getElementById('phone');

        function combinePhone() {
            if (phoneCode && phoneNumber && phoneHidden) {
                const number = phoneNumber.value.trim().replace(/\s+/g, '');
                phoneHidden.value = `${phoneCode.value}${number}`;
            }
        }

        if (phoneCode)   phoneCode.addEventListener('change', combinePhone);
        if (phoneNumber) phoneNumber.addEventListener('input', combinePhone);
    }

    /* ─────────────────────────────────────────
       2. INITIALIZATION
    ───────────────────────────────────────── */

    function init() {
        populateCountryDropdowns();
        generateEmployeeId();
        setDefaultHireDate();
        bindLivePreviewListeners();
        bindErrorFlushListeners();
        bindPhoneListener();
    }

    function generateEmployeeId() {
        const year      = new Date().getFullYear();
        const randomNum = Math.floor(1000 + Math.random() * 9000);
        const newId     = `EMP-${year}-${randomNum}`;
        inputEmpId.value        = newId;
        previewEmpId.textContent = newId;
    }

    function setDefaultHireDate() {
        inputHireDate.value = new Date().toISOString().split('T')[0];
    }

    /* ─────────────────────────────────────────
       3. LIVE BADGE PREVIEW
    ───────────────────────────────────────── */

    function bindLivePreviewListeners() {

        // Text inputs → update badge instantly
        inputFullName.addEventListener('input', e => {
            previewName.textContent = e.target.value.trim() || 'Employee Name';
        });
        inputJobTitle.addEventListener('input', e => {
            previewTitle.textContent = e.target.value.trim() || 'Job Title / Designation';
        });
        inputEmail.addEventListener('input', e => {
            previewEmail.textContent = e.target.value.trim() || 'mail@company.com';
        });

        // Dropdowns → update badge instantly
        selectDept.addEventListener('change', e => {
            previewDept.textContent = e.target.value || 'Not Assigned';
        });
        selectEmpType.addEventListener('change', e => {
            previewType.textContent = e.target.value || 'Full-Time';
        });

        // Avatar picker
        avatarButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                avatarButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const url = btn.getAttribute('data-url');
                hiddenAvatarUrl.value = url;
                previewAvatar.src     = url;
            });
        });
    }

    /* ─────────────────────────────────────────
       4. VALIDATION
    ───────────────────────────────────────── */

    // Clear errors when user starts correcting a field
    function bindErrorFlushListeners() {
        onboardingForm.querySelectorAll('input, select, textarea').forEach(field => {
            ['input', 'change'].forEach(event => {
                field.addEventListener(event, () => clearFieldError(field));
            });
        });
    }

    function validateForm() {
        let isValid = true;

        // Required fields list
        const requiredFields = [
            { id: 'fullName',          label: 'Employee Name' },
            { id: 'gender',            label: 'Gender' },
            { id: 'maritalStatus',     label: 'Marital Status' },
            { id: 'dob',               label: 'Date of Birth' },
            { id: 'nationality',       label: 'Nationality' },
            { id: 'phone',             label: 'Phone Number' },
            { id: 'email',             label: 'Work Email' },
            { id: 'address',           label: 'Home Address' },
            { id: 'department',        label: 'Department' },
            { id: 'jobTitle',          label: 'Job Title' },
            { id: 'hireDate',          label: 'Hire Date' },
            { id: 'emergencyName',     label: 'Emergency Contact Name' },
            { id: 'emergencyRelation', label: 'Emergency Relationship' },
            { id: 'emergencyPhone',    label: 'Emergency Phone' },
        ];

        requiredFields.forEach(({ id, label }) => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                showFieldError(el, `${label} is required`);
                isValid = false;
            }
        });

        // Email format check
        const emailVal = inputEmail.value.trim();
        if (emailVal) {
            // Max 320 characters total
            if (emailVal.length > 320) {
                showFieldError(inputEmail, 'Email address cannot exceed 320 characters');
                isValid = false;

            // Must have exactly one @
            } else if ((emailVal.match(/@/g) || []).length !== 1) {
                showFieldError(inputEmail, 'Email must contain exactly one @ symbol');
                isValid = false;

            } else {
                const [localPart, domain] = emailVal.split('@');

                // Local part max 64 characters
                if (localPart.length > 64) {
                    showFieldError(inputEmail, 'The part before @ cannot exceed 64 characters');
                    isValid = false;

                // Local part cannot start or end with a dot
                } else if (localPart.startsWith('.') || localPart.endsWith('.')) {
                    showFieldError(inputEmail, 'Email cannot start or end with a dot before @');
                    isValid = false;

                // Local part cannot have consecutive dots
                } else if (localPart.includes('..')) {
                    showFieldError(inputEmail, 'Email cannot have consecutive dots before @');
                    isValid = false;

                // Domain max 255 characters
                } else if (domain.length > 255) {
                    showFieldError(inputEmail, 'The domain part cannot exceed 255 characters');
                    isValid = false;

                // Domain must have at least one dot
                } else if (!domain.includes('.')) {
                    showFieldError(inputEmail, 'Email domain must include a TLD (e.g. .com)');
                    isValid = false;

                } else {
                    const tld = domain.split('.').pop();

                    // TLD minimum 2 characters
                    if (tld.length < 2) {
                        showFieldError(inputEmail, 'Email TLD must be at least 2 characters (e.g. .com, .my)');
                        isValid = false;

                    // TLD cannot be all digits
                    } else if (/^\d+$/.test(tld)) {
                        showFieldError(inputEmail, 'Email TLD cannot contain only numbers');
                        isValid = false;

                    // TLD can only contain letters (and hyphens for internationalized TLDs)
                    } else if (!/^[a-zA-Z\-]+$/.test(tld)) {
                        showFieldError(inputEmail, 'Email TLD can only contain letters');
                        isValid = false;

                    // Full format check: valid characters in local and domain
                    } else if (!/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z\-]{2,}$/.test(emailVal)) {
                        showFieldError(inputEmail, 'Please enter a valid email address');
                        isValid = false;
                    }
                }
            }
        }

        // Date of birth must be in the past
        const dobVal = inputDob.value;
        if (dobVal && new Date(dobVal) >= new Date()) {
            showFieldError(inputDob, 'Date of birth must be in the past');
            isValid = false;
        }

        // Phone number validation
        const phoneNumber = document.getElementById('phoneNumber');
        const phoneCode   = document.getElementById('phoneCode');
        if (!phoneNumber || !phoneNumber.value.trim()) {
            showFieldError(document.getElementById('phone'), 'Phone number is required');
            if (phoneNumber) phoneNumber.classList.add('input-error');
            isValid = false;
        } else if (!/^[0-9\s\-]{6,14}$/.test(phoneNumber.value.trim())) {
            showFieldError(document.getElementById('phone'), 'Please enter a valid local number (digits only)');
            if (phoneNumber) phoneNumber.classList.add('input-error');
            isValid = false;
        }

        return isValid;
    }

    function showFieldError(element, message) {
        if (!element) return;
        element.classList.add('input-error');
        const errorSpan = document.getElementById(`error-${element.id}`);
        if (errorSpan) errorSpan.textContent = message;
    }

    function clearFieldError(element) {
        if (!element) return;
        element.classList.remove('input-error');
        const errorSpan = document.getElementById(`error-${element.id}`);
        if (errorSpan) errorSpan.textContent = '';
    }

    /* ─────────────────────────────────────────
       5. FORM RESET
    ───────────────────────────────────────── */

    function resetForm() {
        onboardingForm.reset();

        // Clear all error states
        onboardingForm.querySelectorAll('input, select, textarea').forEach(field => {
            clearFieldError(field);
        });

        // Reset live badge to defaults
        previewName.textContent  = 'Employee Name';
        previewTitle.textContent = 'Job Title / Designation';
        previewDept.textContent  = 'Not Assigned';
        previewType.textContent  = 'Full-Time';
        previewEmail.textContent = 'mail@company.com';

        // Reset avatar to first option
        avatarButtons.forEach(btn => btn.classList.remove('active'));
        avatarButtons[0].classList.add('active');
        hiddenAvatarUrl.value = avatarUrls[0];
        previewAvatar.src     = avatarUrls[0];

        // Re-generate ID and reset date
        generateEmployeeId();
        setDefaultHireDate();

        showToast('Form has been reset');
    }

    btnResetForm.addEventListener('click', resetForm);
    btnClearForm.addEventListener('click', resetForm);
    btnRegenId.addEventListener('click', (e) => {
        e.preventDefault();
        generateEmployeeId();
        showToast('New Employee ID generated');
    });

    /* ─────────────────────────────────────────
       6. FORM SUBMISSION → REST API
    ───────────────────────────────────────── */

    onboardingForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!validateForm()) {
            // Scroll to first error
            const firstError = onboardingForm.querySelector('.input-error');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Build JSON payload
        const payload = {
            name:              inputFullName.value.trim(),
            gender:            selectGender.value,
            marital_status:    selectMaritalStatus.value,
            dob:               inputDob.value,
            nationality:       inputNationality.value.trim(),
            phone:             inputPhone.value.trim(),
            email:             inputEmail.value.trim(),
            address:           textareaAddress.value.trim(),
            emp_id:            inputEmpId.value,
            employment_type:   selectEmpType.value,
            department:        selectDept.value,
            job_title:         inputJobTitle.value.trim(),
            hire_date:         inputHireDate.value,
            emergency_name:    inputEmergencyName.value.trim(),
            emergency_relation: inputEmergencyRelation.value.trim(),
            emergency_phone:   inputEmergencyPhone.value.trim(),
            avatar_url:        hiddenAvatarUrl.value,
            notes:             document.getElementById('notes')?.value.trim() || '',
        };

        try {
            const response = await fetch('api/employee.php', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify(payload),
            });

            const data = await response.json();

            if (data.success) {
                // Show success modal
                modalEmpName.textContent = payload.name;
                modalSuccess.classList.remove('hidden');
                resetForm();
            } else {
                // Show backend validation errors on fields
                if (data.errors) {
                    Object.entries(data.errors).forEach(([key, message]) => {
                        const field = document.getElementById(key);
                        showFieldError(field, message);
                    });
                    const firstError = onboardingForm.querySelector('.input-error');
                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    showToast(data.message || 'Something went wrong', true);
                }
            }

        } catch (error) {
            showToast('Could not connect to server. Please try again.', true);
        }
    });

    /* ─────────────────────────────────────────
       7. MODAL
    ───────────────────────────────────────── */

    btnCloseModal.addEventListener('click', () => {
        modalSuccess.classList.add('hidden');
    });

    /* ─────────────────────────────────────────
       8. TOAST NOTIFICATIONS
    ───────────────────────────────────────── */

    function showToast(message, isError = false) {
        const toast    = document.getElementById('toast');
        const toastMsg = document.getElementById('toast-msg');

        toastMsg.textContent = message;

        if (isError) {
            toast.style.backgroundColor = '#fef2f2';
            toast.style.border          = '1px solid #fee2e2';
            toast.style.color           = '#ef4444';
        } else {
            toast.removeAttribute('style');
        }

        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3500);
    }

    /* ─────────────────────────────────────────
       RUN
    ───────────────────────────────────────── */
    init();

});