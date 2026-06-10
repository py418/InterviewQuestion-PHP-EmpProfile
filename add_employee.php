<?php
$pageTitle = 'Onboarding - Add Employee';
require_once "includes/header.php";
?>

<!-- Boxicons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<!-- Notification Toast -->
 <div id="toast" class="toast hidden">
    <i class = 'bx bx-check-circle toast-icon'></i>
    <span id="toast-msg">Action completed successfully!</span>
 </div>

 <!-- Main Content -->
    <main class="main-layout">
        <!-- Header Introduction -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Onboarding - Add Employee</h1>
                <p class="page-subtitle">Please complete the profile, background, and occupational details to provision a clean corporate record.</p>
            </div>

            <button type="button" id="btn-reset-form" class="btn btn-outline">
            <i class='bx bx-refresh'></i> Reset Form
        </button>
    </div>

    <!-- Two-Column Grid -->
    <div class="dashboard-grid">

        <!-- Left Side: Form -->
        <section class="form-container">
            <form id="onboarding-form" novalidate>

                <!-- Section 1: Personal Information -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-title-wrapper">
                            <div class="section-icon"><i class='bx bx-user'></i></div>
                            <div>
                                <h2 class="section-heading">Personal Information</h2>
                                <p class="section-subheading">Basic identification and personal backgrounds</p>
                            </div>
                        </div>
                        <span class="badge">Section 1 of 4</span>
                    </div>

                    <div class="section-body grid-2">

                        <!-- Full Name -->
                        <div class="col-span-2">
                            <label for="fullName">Employee Name <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class='bx bx-user input-icon'></i>
                                <input type="text" id="fullName" name="fullName" placeholder="e.g. Lai Pei Yi">
                            </div>
                            <span class="error-msg" id="error-fullName"></span>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                            <span class="error-msg" id="error-gender"></span>
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label for="maritalStatus">Marital Status <span class="required">*</span></label>
                            <select id="maritalStatus" name="maritalStatus">
                                <option value="">Select Marital Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                            <span class="error-msg" id="error-maritalStatus"></span>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="dob">Date of Birth <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class='bx bx-calendar input-icon'></i>
                                <input type="date" id="dob" name="dob">
                            </div>
                            <span class="error-msg" id="error-dob"></span>
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label for="nationality">Nationality <span class="required">*</span></label>
                            <select id="nationality" name="nationality">
                                <option value="">Select Nationality</option>
                                <!-- Populated by JS from countries.js -->
                            </select>
                            <span class="error-msg" id="error-nationality"></span>
                        </div>

                        <!-- Avatar Picker -->
                        <div class="col-span-2">
                            <label>Select Profile Avatar Preview</label>
                            <div class="avatar-presets">
                                <?php
                                $avatars = [
                                    'https://plus.unsplash.com/premium_photo-1739178656537-ea88ababab9b?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                                    'https://plus.unsplash.com/premium_photo-1739178656567-068b26a4b979?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                                    'https://plus.unsplash.com/premium_photo-1739178656557-16b949fea186?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                                    'https://plus.unsplash.com/premium_photo-1739178656495-8109a8bc4f53?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                                ];
                                foreach ($avatars as $i => $url): ?>
                                    <button type="button" class="avatar-btn <?php echo $i === 0 ? 'active' : ''; ?>" data-url="<?php echo htmlspecialchars($url); ?>">
                                        <img src="<?php echo htmlspecialchars($url); ?>" alt="Avatar <?php echo $i + 1; ?>">
                                    </button>
                                <?php endforeach; ?>
                                <input type="hidden" id="avatarUrl" name="avatarUrl" value="<?php echo htmlspecialchars($avatars[0]); ?>">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Section 2: Contact Details -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-title-wrapper">
                            <div class="section-icon"><i class='bx bx-phone'></i></div>
                            <div>
                                <h2 class="section-heading">Contact Details</h2>
                                <p class="section-subheading">Communication routes and current residence address</p>
                            </div>
                        </div>
                        <span class="badge">Section 2 of 4</span>
                    </div>

                    <div class="section-body grid-2">

                        <!-- Phone -->
                        <div>
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <select id="phoneCode" name="phoneCode" class="phone-code-select">
                                    <option value="+60">🇲🇾 +60</option>
                                    <!-- Populated by JS -->
                                </select>
                                <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="12-345 6789">
                                <input type="hidden" id="phone" name="phone">
                            </div>
                            <span class="error-msg" id="error-phone"></span>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email">Work Email Address <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class='bx bx-envelope input-icon'></i>
                                <input type="email" id="email" name="email" placeholder="e.g. name@company.com">
                            </div>
                            <span class="error-msg" id="error-email"></span>
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label for="address">Home Address <span class="required">*</span></label>
                            <div class="input-wrapper align-start">
                                <i class='bx bx-map input-icon pt-1'></i>
                                <textarea id="address" name="address" rows="2" placeholder="Queens Residence 1, Jalan Bayan Indah, 11900 Bayan Lepas, Penang"></textarea>
                            </div>
                            <span class="error-msg" id="error-address"></span>
                        </div>

                    </div>
                </div>

                <!-- Section 3: Employment Details -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-title-wrapper">
                            <div class="section-icon"><i class='bx bx-briefcase'></i></div>
                            <div>
                                <h2 class="section-heading">Employment Details</h2>
                                <p class="section-subheading">Role assignment, department, and pay rates</p>
                            </div>
                        </div>
                        <span class="badge">Section 3 of 4</span>
                    </div>

                    <div class="section-body grid-2">

                        <!-- Employee ID -->
                        <div>
                            <label class="flex-label">
                                <span>Employee ID (Auto-Generated)</span>
                                <button type="button" id="btn-regen-id" class="text-btn">
                                    <i class='bx bx-refresh'></i> Re-gen
                                </button>
                            </label>
                            <div class="input-wrapper">
                                <i class='bx bx-id-card input-icon'></i>
                                <input type="text" id="empId" name="empId" class="input-readonly font-mono" readonly>
                            </div>
                        </div>

                        <!-- Employment Type -->
                        <div>
                            <label for="employmentType">Employment Type <span class="required">*</span></label>
                            <select id="employmentType" name="employmentType">
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Contract">Contract</option>
                                <option value="Temporary">Temporary</option>
                                <option value="Intern">Intern</option>
                            </select>
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department">Department <span class="required">*</span></label>
                            <select id="department" name="department">
                                <option value="">Select Department</option>
                                <option value="Engineering & Product">Engineering &amp; Product</option>
                                <option value="Growth & Marketing">Growth &amp; Marketing</option>
                                <option value="Corporate Sales">Corporate Sales</option>
                                <option value="Finance & Treasury">Finance &amp; Treasury</option>
                                <option value="Human Resources">Human Resources (HR)</option>
                                <option value="Operations & Security">Operations &amp; Security</option>
                            </select>
                            <span class="error-msg" id="error-department"></span>
                        </div>

                        <!-- Job Title -->
                        <div>
                            <label for="jobTitle">Job Title <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class='bx bx-briefcase input-icon'></i>
                                <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g. Junior Software Engineer">
                            </div>
                            <span class="error-msg" id="error-jobTitle"></span>
                        </div>

                        <!-- Hire Date -->
                        <div>
                            <label for="hireDate">Official Hire Date <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <i class='bx bx-calendar-event input-icon'></i>
                                <input type="date" id="hireDate" name="hireDate">
                            </div>
                            <span class="error-msg" id="error-hireDate"></span>
                        </div>

                    </div>
                </div>

                <!-- Section 4: Emergency & Extra Details -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-title-wrapper">
                            <div class="section-icon"><i class='bx bx-heart'></i></div>
                            <div>
                                <h2 class="section-heading">Emergency &amp; Extra Details</h2>
                                <p class="section-subheading">Critical primary safety contacts and customized notes</p>
                            </div>
                        </div>
                        <span class="badge">Section 4 of 4</span>
                    </div>

                    <div class="section-body grid-3">

                        <!-- Emergency Name -->
                        <div>
                            <label for="emergencyName">Contact Name <span class="required">*</span></label>
                            <input type="text" id="emergencyName" name="emergencyName" placeholder="e.g. Wu Yu Xin">
                            <span class="error-msg" id="error-emergencyName"></span>
                        </div>

                        <!-- Relationship -->
                        <div>
                            <label for="emergencyRelation">Relationship <span class="required">*</span></label>
                            <input type="text" id="emergencyRelation" name="emergencyRelation" placeholder="e.g. Spouse / Sibling">
                            <span class="error-msg" id="error-emergencyRelation"></span>
                        </div>

                        <!-- Emergency Phone -->
                        <div>
                            <label for="emergencyPhone">Contact Phone <span class="required">*</span></label>
                            <input type="tel" id="emergencyPhone" name="emergencyPhone" placeholder="+60 12-987 6543">
                            <span class="error-msg" id="error-emergencyPhone"></span>
                        </div>

                        <!-- Notes -->
                        <div class="col-span-3">
                            <label for="notes">Additional Comments / Notes</label>
                            <div class="input-wrapper align-start">
                                <i class='bx bx-note input-icon pt-1'></i>
                                <textarea id="notes" name="notes" rows="3" placeholder="Add background notes, relocation details, or internal onboarding reminders..."></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Submission Row -->
                <div class="submission-row">
                    <button type="button" id="btn-clear" class="btn btn-outline">Clear Form</button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-plus'></i> Add Employee to Directory
                    </button>
                </div>

            </form>
        </section>

        <!-- Right Side: Live Badge Preview -->
        <aside class="sidebar-wrapper">
            <div class="preview-card">
                <div class="accent-light-top"></div>
                <div class="accent-light-bottom"></div>

                <div class="live-tag">
                    <span class="pulse-dot"></span>
                    Live ID Badge Preview
                </div>

                <div class="preview-body">
                    <div class="preview-avatar-container">
                        <div class="avatar-ring">
                            <img id="preview-avatar" src="<?php echo htmlspecialchars($avatars[0]); ?>" alt="Preview Photo">
                        </div>
                        <span class="camera-icon"><i class='bx bx-camera'></i></span>
                    </div>

                    <h3 id="preview-name" class="preview-name">Lai Pei Yi</h3>
                    <p id="preview-title" class="preview-title">Job Title / Designation</p>

                    <div class="preview-id-badge">
                        <span id="preview-empid" class="font-mono">EMP-2026-XXXX</span>
                    </div>

                    <div class="preview-details-grid">
                        <div>
                            <span class="detail-label">Department</span>
                            <span id="preview-dept" class="detail-value">Not Assigned</span>
                        </div>
                        <div>
                            <span class="detail-label">Contract Type</span>
                            <span id="preview-type" class="detail-value">Full-Time</span>
                        </div>
                        <div class="col-span-2">
                            <span class="detail-label">Work Email</span>
                            <span id="preview-email" class="detail-value truncate">mail@enterprise.io</span>
                        </div>
                    </div>

                    <!-- Simulated Barcode -->
                    <div class="barcode-wrapper">
                        <div class="barcode-lines">
                            <div class="line w-2"></div><div class="line w-1"></div><div class="line w-3"></div><div class="line w-1"></div>
                            <div class="line w-05"></div><div class="line w-2"></div><div class="line w-1"></div><div class="line w-05"></div>
                            <div class="line w-3"></div><div class="line w-1"></div><div class="line w-2"></div><div class="line w-1"></div>
                            <div class="line w-05"></div><div class="line w-3"></div><div class="line w-1"></div><div class="line w-2"></div>
                        </div>
                        <span class="barcode-caption">MYWAVE VERIFIED RECORD</span>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</main>

<!-- Success Modal -->
<div id="modal-success" class="modal-overlay hidden">
    <div class="modal-card">
        <div class="modal-icon">
            <i class='bx bx-check-circle'></i>
        </div>
        <h3 class="modal-title">Employee Onboarded!</h3>
        <p class="modal-desc">
            <strong id="modal-emp-name" class="highlight-text">John Doe</strong> has been registered successfully. A secure record was created and processed on the server.
        </p>
        <button type="button" id="btn-close-modal" class="btn btn-primary w-full">Continue Onboarding</button>
    </div>
</div>

<script src="js/countries.js"></script>
<script src="js/validate.js"></script>

<?php require_once "includes/footer.php"; ?>