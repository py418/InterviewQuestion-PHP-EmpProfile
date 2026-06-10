<?php
$pageTitle = 'Employee Directory';
require_once 'includes/header.php';

$dataFile  = __DIR__ . '/data/employees.json';
$employees = [];

if (file_exists($dataFile)) {
    $content   = file_get_contents($dataFile);
    $employees = json_decode($content, true) ?? [];
}

usort($employees, fn($a, $b) => strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0));

$total      = count($employees);
$deptCounts = array_count_values(array_column($employees, 'department'));
$typeCounts = array_count_values(array_column($employees, 'employment_type'));
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<main class="main-layout">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Employee Directory</h1>
            <div class="header-stats">
                <span class="stat-chip">
                    <i class='bx bx-group'></i>
                    <?php echo $total; ?> Total
                </span>
                <?php foreach (array_slice($deptCounts, 0, 3) as $dept => $count): ?>
                <span class="stat-chip">
                    <i class='bx bx-buildings'></i>
                    <?php echo html_entity_decode(htmlspecialchars($dept)); ?> (<?php echo $count; ?>)
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="add_employee.php" class="btn btn-primary">
            <i class='bx bx-plus'></i> Add Employee
        </a>
    </div>

    <?php if (empty($employees)): ?>

        <div class="empty-state">
            <i class='bx bx-group'></i>
            <h3>No employees yet</h3>
            <p>Start by adding your first employee to the directory.</p>
            <a href="add_employee.php" class="btn btn-primary">
                <i class='bx bx-plus'></i> Add First Employee
            </a>
        </div>

    <?php else: ?>

        <!-- Search & Filter Row -->
        <div class="filter-surface">
            <div class="filter-row">
            <div class="search-wrapper">
                <i class='bx bx-search search-icon'></i>
                <input type="text" id="searchInput" placeholder="Search by name, email, department...">
            </div>
                <select id="filterDept" class="filter-select">
                    <option value="">All Departments</option>
                    <option value="Engineering & Product">Engineering &amp; Product</option>
                    <option value="Growth & Marketing">Growth &amp; Marketing</option>
                    <option value="Corporate Sales">Corporate Sales</option>
                    <option value="Finance & Treasury">Finance &amp; Treasury</option>
                    <option value="Human Resources">Human Resources (HR)</option>
                    <option value="Operations & Security">Operations &amp; Security</option>
                </select>
                <select id="filterType" class="filter-select">
                    <option value="">All Types</option>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Contract">Contract</option>
                    <option value="Temporary">Temporary</option>
                    <option value="Intern">Intern</option>
                </select>
            </div>
        </div>

        <!-- Results Bar -->
        <div class="results-bar">
            <div class="results-bar-left">
                <span class="results-dot"></span>
                <span id="resultsCount">Showing <strong><?php echo $total; ?></strong> of <strong><?php echo $total; ?></strong> employees</span>
            </div>
            <button id="btnClearFilters" class="text-btn hidden">
                <i class='bx bx-x'></i> Clear filters
            </button>
        </div>

        <!-- Employee Grid -->
        <div class="employee-grid" id="employeeGrid">
            <?php foreach ($employees as $emp): ?>
            <div class="employee-card"
                 data-name="<?php echo strtolower(htmlspecialchars($emp['name'] ?? '')); ?>"
                 data-email="<?php echo strtolower(htmlspecialchars($emp['email'] ?? '')); ?>"
                 data-dept="<?php echo htmlspecialchars($emp['department'] ?? ''); ?>"
                 data-type="<?php echo htmlspecialchars($emp['employment_type'] ?? ''); ?>">

                <div class="card-top">
                    <img
                        src="<?php echo htmlspecialchars($emp['avatar_url'] ?? ''); ?>"
                        alt="<?php echo htmlspecialchars($emp['name'] ?? ''); ?>"
                        class="card-avatar"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($emp['name'] ?? 'E'); ?>&background=4167b1&color=fff&size=256'"
                    >
                    <div class="card-identity">
                        <h3 class="card-name"><?php echo htmlspecialchars($emp['name'] ?? '—'); ?></h3>
                        <p class="card-job"><?php echo htmlspecialchars($emp['job_title'] ?? '—'); ?></p>
                        <span class="card-badge"><?php echo htmlspecialchars($emp['employment_type'] ?? 'Full-Time'); ?></span>
                    </div>
                </div>

                <div class="card-details">
                    <div class="card-detail-row">
                        <i class='bx bx-buildings'></i>
                        <span><?php echo htmlspecialchars($emp['department'] ?? '—'); ?></span>
                    </div>
                    <div class="card-detail-row">
                        <i class='bx bx-envelope'></i>
                        <span><?php echo htmlspecialchars($emp['email'] ?? '—'); ?></span>
                    </div>
                    <div class="card-detail-row">
                        <i class='bx bx-phone'></i>
                        <span><?php echo htmlspecialchars($emp['phone'] ?? '—'); ?></span>
                    </div>
                    <div class="card-detail-row">
                        <i class='bx bx-flag'></i>
                        <span><?php echo htmlspecialchars($emp['nationality'] ?? '—'); ?></span>
                    </div>
                    <div class="card-detail-row">
                        <i class='bx bx-calendar-check'></i>
                        <span>Hired <?php echo htmlspecialchars($emp['hire_date'] ?? '—'); ?></span>
                    </div>
                </div>

                <div class="card-footer">
                    <span class="card-id font-mono"><?php echo htmlspecialchars($emp['emp_id'] ?? '—'); ?></span>
                    <span class="card-date">
                        <?php echo isset($emp['created_at']) ? date('d M Y', strtotime($emp['created_at'])) : '—'; ?>
                    </span>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <div id="noResults" class="empty-state hidden">
            <i class='bx bx-search-alt'></i>
            <h3>No results found</h3>
            <p>Try adjusting your search or filters.</p>
        </div>

    <?php endif; ?>

</main>

<script>
const searchInput    = document.getElementById('searchInput');
const filterDept     = document.getElementById('filterDept');
const filterType     = document.getElementById('filterType');
const grid           = document.getElementById('employeeGrid');
const noResults      = document.getElementById('noResults');
const resultsCount   = document.getElementById('resultsCount');
const btnClearFilters = document.getElementById('btnClearFilters');
const total          = <?php echo $total; ?>;

function filterCards() {
    const search = searchInput.value.toLowerCase().trim();
    const dept   = filterDept.value;
    const type   = filterType.value;
    const cards  = grid ? grid.querySelectorAll('.employee-card') : [];
    let visible  = 0;

    cards.forEach(card => {
        const matchSearch = !search ||
            card.dataset.name.includes(search)  ||
            card.dataset.email.includes(search) ||
            card.dataset.dept.toLowerCase().includes(search);
        const matchDept = !dept || card.dataset.dept === dept;
        const matchType = !type || card.dataset.type === type;

        const show = matchSearch && matchDept && matchType;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    if (resultsCount) {
        resultsCount.innerHTML = `Showing <strong>${visible}</strong> of <strong>${total}</strong> employee${total !== 1 ? 's' : ''}`;
    }
    if (noResults)      noResults.classList.toggle('hidden', visible > 0);
    if (btnClearFilters) btnClearFilters.classList.toggle('hidden', !search && !dept && !type);
}

function clearFilters() {
    searchInput.value = '';
    filterDept.value  = '';
    filterType.value  = '';
    filterCards();
}

if (searchInput)     searchInput.addEventListener('input', filterCards);
if (filterDept)      filterDept.addEventListener('change', filterCards);
if (filterType)      filterType.addEventListener('change', filterCards);
if (btnClearFilters) btnClearFilters.addEventListener('click', clearFilters);
</script>

<?php require_once 'includes/footer.php'; ?>