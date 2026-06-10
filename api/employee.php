<?php
/**
 * Employee REST API
 * Location: /api/employee.php
 * Handles GET (fetch all) and POST (add new employee)
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

$dataFile = __DIR__ . '/../data/employees.json';

/* ─────────────────────────────────────────
   HELPER FUNCTIONS
───────────────────────────────────────── */

function getEmployees($dataFile) {
    if (!file_exists($dataFile)) return [];
    $content = file_get_contents($dataFile);
    return json_decode($content, true) ?? [];
}

function saveEmployees($dataFile, $employees) {
    file_put_contents($dataFile, json_encode($employees, JSON_PRETTY_PRINT));
}

function validateEmployee($data) {
    $errors = [];

    // Personal
    if (empty(trim($data['name'] ?? '')))
        $errors['fullName'] = 'Employee name is required.';

    if (!in_array($data['gender'] ?? '', ['Male', 'Female', 'Prefer not to say']))
        $errors['gender'] = 'Please select a valid gender.';

    if (!in_array($data['marital_status'] ?? '', ['Single', 'Married', 'Divorced', 'Widowed']))
        $errors['maritalStatus'] = 'Please select a valid marital status.';

    if (empty($data['dob'] ?? ''))
        $errors['dob'] = 'Date of birth is required.';
    elseif (strtotime($data['dob']) >= strtotime('today'))
        $errors['dob'] = 'Date of birth must be in the past.';

    if (empty(trim($data['nationality'] ?? '')))
        $errors['nationality'] = 'Nationality is required.';

    // Contact
    if (!preg_match('/^[0-9\s\-\+]{8,15}$/', $data['phone'] ?? ''))
        $errors['phone'] = 'Phone must be 8-15 digits.';

    $email = $data['email'] ?? '';

    // Max 320 characters
    if (strlen($email) > 320) {
        $errors['email'] = 'Email address cannot exceed 320 characters.';

    // Must contain exactly one @
    } elseif (substr_count($email, '@') !== 1) {
        $errors['email'] = 'Email must contain exactly one @ symbol.';

    } else {
        [$localPart, $domain] = explode('@', $email);

        // Local part max 64 characters
        if (strlen($localPart) > 64) {
            $errors['email'] = 'The part before @ cannot exceed 64 characters.';

        // Local part cannot start or end with a dot
        } elseif (str_starts_with($localPart, '.') || str_ends_with($localPart, '.')) {
            $errors['email'] = 'Email cannot start or end with a dot before @.';

        // Local part cannot have consecutive dots
        } elseif (str_contains($localPart, '..')) {
            $errors['email'] = 'Email cannot have consecutive dots before @.';

        // Domain max 255 characters
        } elseif (strlen($domain) > 255) {
            $errors['email'] = 'The domain part cannot exceed 255 characters.';

        // Domain must contain a dot
        } elseif (!str_contains($domain, '.')) {
            $errors['email'] = 'Email domain must include a TLD (e.g. .com).';

        } else {
            $tld = substr($domain, strrpos($domain, '.') + 1);

            // TLD minimum 2 characters
            if (strlen($tld) < 2) {
                $errors['email'] = 'Email TLD must be at least 2 characters (e.g. .com, .my).';

            // TLD cannot be all digits
            } elseif (ctype_digit($tld)) {
                $errors['email'] = 'Email TLD cannot contain only numbers.';

            // TLD can only contain letters
            } elseif (!preg_match('/^[a-zA-Z\-]+$/', $tld)) {
                $errors['email'] = 'Email TLD can only contain letters.';

            // Full format check
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email address.';
            }
        }
    }

    if (empty(trim($data['address'] ?? '')))
        $errors['address'] = 'Address is required.';

    // Employment
    if (empty(trim($data['department'] ?? '')))
        $errors['department'] = 'Department is required.';

    if (empty(trim($data['job_title'] ?? '')))
        $errors['jobTitle'] = 'Job title is required.';

    if (empty($data['hire_date'] ?? ''))
        $errors['hireDate'] = 'Hire date is required.';

    // Emergency
    if (empty(trim($data['emergency_name'] ?? '')))
        $errors['emergencyName'] = 'Emergency contact name is required.';

    if (empty(trim($data['emergency_relation'] ?? '')))
        $errors['emergencyRelation'] = 'Emergency relationship is required.';

    if (!preg_match('/^[0-9\s\-\+]{8,15}$/', $data['emergency_phone'] ?? ''))
        $errors['emergencyPhone'] = 'Emergency phone must be 8-15 digits.';

    return $errors;
}

/* ─────────────────────────────────────────
   GET → Return all employees
───────────────────────────────────────── */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employees = getEmployees($dataFile);
    echo json_encode([
        'success' => true,
        'data'    => $employees
    ]);
    exit;
}

/* ─────────────────────────────────────────
   POST → Add new employee
───────────────────────────────────────── */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from fetch()
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid or empty request body.']);
        exit;
    }

    // Sanitize all fields
    $data = [
        // Personal
        'name'               => trim($input['name'] ?? ''),
        'gender'             => trim($input['gender'] ?? ''),
        'marital_status'     => trim($input['marital_status'] ?? ''),
        'dob'                => trim($input['dob'] ?? ''),
        'nationality'        => trim($input['nationality'] ?? ''),
        // Contact
        'phone'              => trim($input['phone'] ?? ''),
        'email'              => trim($input['email'] ?? ''),
        'address'            => trim($input['address'] ?? ''),
        // Employment
        'emp_id'             => trim($input['emp_id'] ?? ''),
        'employment_type'    => trim($input['employment_type'] ?? 'Full-Time'),
        'department'         => trim($input['department'] ?? ''),
        'job_title'          => trim($input['job_title'] ?? ''),
        'hire_date'          => trim($input['hire_date'] ?? ''),
        // Emergency
        'emergency_name'     => trim($input['emergency_name'] ?? ''),
        'emergency_relation' => trim($input['emergency_relation'] ?? ''),
        'emergency_phone'    => trim($input['emergency_phone'] ?? ''),
        // Extra
        'avatar_url'         => filter_var(trim($input['avatar_url'] ?? ''), FILTER_SANITIZE_URL),
        'notes'              => trim($input['notes'] ?? ''),
    ];

    // Validate
    $errors = validateEmployee($data);
    if (!empty($errors)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed.',
            'errors'  => $errors
        ]);
        exit;
    }

    // Add timestamp
    $data['created_at'] = date('Y-m-d H:i:s');

    // Save to JSON
    $employees   = getEmployees($dataFile);
    $employees[] = $data;
    saveEmployees($dataFile, $employees);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Employee added successfully.',
        'data'    => $data
    ]);
    exit;
}

/* ─────────────────────────────────────────
   Any other method
───────────────────────────────────────── */

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);