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
        $this->render('companies.php', compact('companies'));
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
