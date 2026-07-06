<?php

class AdminController {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    private function render(string $viewPath, array $data = []) {
        extract($data);
        $view = __DIR__ . '/../views/admin/' . $viewPath;
        include __DIR__ . '/../views/admin/layout.php';
    }

    private function redirectToCompanies(array $query = []): void {
        $params = array_merge(['page' => 'companies'], $query);
        header('Location: /index.php?' . http_build_query($params));
        exit;
    }

    private function getCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function hasValidCsrfToken(?string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public function dashboard() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS c FROM mission_requests WHERE status = 'nouvelle'");
        $countNew = $stmt->fetch()['c'] ?? 0;

        $stmt = $this->pdo->query("SELECT COUNT(*) AS c FROM mission_requests WHERE status = 'en_etude'");
        $countStudy = $stmt->fetch()['c'] ?? 0;

        $stmt = $this->pdo->query("SELECT * FROM mission_requests ORDER BY created_at DESC LIMIT 10");
        $requests = $stmt->fetchAll();

        $this->render('dashboard.php', compact('countNew', 'countStudy', 'requests'));
    }

    public function companies() {
        $stmt = $this->pdo->query("SELECT * FROM companies ORDER BY created_at DESC");
        $companies = $stmt->fetchAll();

        $selectedCompanyId = isset($_GET['selected_company_id']) ? (int)$_GET['selected_company_id'] : null;
        $selectedCompany = null;
        $companyUsers = [];

        if ($selectedCompanyId) {
            $stmt = $this->pdo->prepare("SELECT * FROM companies WHERE id = ?");
            $stmt->execute([$selectedCompanyId]);
            $selectedCompany = $stmt->fetch();

            if ($selectedCompany) {
                $stmt = $this->pdo->prepare("
                    SELECT id, name, email, role, created_at
                    FROM users
                    WHERE company_id = ?
                    ORDER BY created_at DESC
                ");
                $stmt->execute([$selectedCompanyId]);
                $companyUsers = $stmt->fetchAll();
            } else {
                $selectedCompanyId = null;
            }
        }

        $status = $_GET['status'] ?? null;
        $error = $_GET['error'] ?? null;
        $csrfToken = $this->getCsrfToken();

        $this->render('companies.php', compact(
            'companies',
            'selectedCompanyId',
            'selectedCompany',
            'companyUsers',
            'status',
            'error',
            'csrfToken'
        ));
    }

    public function companiesCreate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToCompanies();
        }
        if (!$this->hasValidCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirectToCompanies(['error' => 'csrf_invalid']);
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->redirectToCompanies(['error' => 'company_name_required']);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO companies (
                name, siret, address, postal_code, city, department,
                contact_name, contact_email, contact_phone
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $created = $stmt->execute([
            $name,
            trim($_POST['siret'] ?? ''),
            trim($_POST['address'] ?? ''),
            trim($_POST['postal_code'] ?? ''),
            trim($_POST['city'] ?? ''),
            trim($_POST['department'] ?? ''),
            trim($_POST['contact_name'] ?? ''),
            trim($_POST['contact_email'] ?? ''),
            trim($_POST['contact_phone'] ?? '')
        ]);
        if (!$created) {
            $this->redirectToCompanies(['error' => 'company_create_failed']);
        }

        $newCompanyId = (int)$this->pdo->lastInsertId();

        $redirectParams = ['status' => 'company_created'];
        if ($newCompanyId > 0) {
            $redirectParams['selected_company_id'] = $newCompanyId;
        }
        $this->redirectToCompanies($redirectParams);
    }

    public function companyUserCreate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToCompanies();
        }

        if (!$this->hasValidCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirectToCompanies([
                'error' => 'csrf_invalid',
            ]);
        }
        $companyId = isset($_POST['company_id']) ? (int)$_POST['company_id'] : 0;
        if ($companyId <= 0) {
            $this->redirectToCompanies(['error' => 'company_required']);
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $password === '') {
            $this->redirectToCompanies([
                'selected_company_id' => $companyId,
                'error' => 'user_fields_required',
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectToCompanies([
                'selected_company_id' => $companyId,
                'error' => 'invalid_email',
            ]);
        }

        if (strlen($password) < 8) {
            $this->redirectToCompanies([
                'selected_company_id' => $companyId,
                'error' => 'password_too_short',
            ]);
        }

        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("
                INSERT INTO users (company_id, role, name, email, password_hash)
                VALUES (?, 'client', ?, ?, ?)
            ");
            $stmt->execute([$companyId, $name, $email, $hash]);
        } catch (PDOException $e) {
            error_log('AdminController::companyUserCreate failed: ' . $e->getMessage());
            $this->redirectToCompanies([
                'selected_company_id' => $companyId,
                'error' => 'user_create_failed',
            ]);
        }

        $this->redirectToCompanies([
            'selected_company_id' => $companyId,
            'status' => 'user_created',
        ]);
    }

    public function companyUserDelete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToCompanies();
        }

        if (!$this->hasValidCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirectToCompanies([
                'error' => 'csrf_invalid',
            ]);
        }
        $companyId = isset($_POST['company_id']) ? (int)$_POST['company_id'] : 0;
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

        if ($companyId <= 0 || $userId <= 0) {
            $this->redirectToCompanies(['error' => 'invalid_user_delete']);
        }

        $stmt = $this->pdo->prepare("
            DELETE FROM users
            WHERE id = ? AND company_id = ? AND role <> 'admin'
        ");
        $stmt->execute([$userId, $companyId]);

        if ($stmt->rowCount() === 0) {
            $this->redirectToCompanies([
                'selected_company_id' => $companyId,
                'error' => 'invalid_user_delete',
            ]);
        }

        $this->redirectToCompanies([
            'selected_company_id' => $companyId,
            'status' => 'user_deleted',
        ]);
    }

    public function companyView() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /index.php?page=companies');
            exit;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM companies WHERE id = ?");
        $stmt->execute([$id]);
        $company = $stmt->fetch();

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE company_id = ?");
        $stmt->execute([$id]);
        $employees = $stmt->fetchAll();

        $stmt = $this->pdo->prepare("SELECT * FROM documents WHERE company_id = ?");
        $stmt->execute([$id]);
        $documents = $stmt->fetchAll();

        $this->render('company_view.php', compact('company', 'employees', 'documents'));
    }

    public function users() {
        $stmt = $this->pdo->query("
            SELECT u.*, c.name AS company_name
            FROM users u
            LEFT JOIN companies c ON c.id = u.company_id
            ORDER BY u.created_at DESC
        ");
        $users = $stmt->fetchAll();
        $this->render('users.php', compact('users'));
    }

    public function usersCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $company_id = $_POST['company_id'] ?: null;

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("
                INSERT INTO users (company_id, role, name, email, password_hash)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$company_id, $role, $name, $email, $hash]);

            header('Location: /index.php?page=users');
            exit;
        }

        $companies = $this->pdo->query("SELECT * FROM companies ORDER BY name")->fetchAll();
        $this->render('users.php', compact('companies'));
    }

    public function uploadDocumentForm() {
        $company_id = $_GET['company_id'] ?? null;
        $this->render('upload_document.php', compact('company_id'));
    }
}
