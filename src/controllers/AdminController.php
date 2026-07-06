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
        $stmt = $this->pdo->query("SELECT * FROM companies ORDER BY name ASC");
        $companies = $stmt->fetchAll();
        foreach ($companies as &$c) {
            $s = $this->pdo->prepare("SELECT id, name, email FROM users WHERE company_id = ? ORDER BY name");
            $s->execute([$c['id']]);
            $c['users'] = $s->fetchAll();
        }
        unset($c);
        $this->render('companies.php', compact('companies'));
    }

    public function companiesCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $this->pdo->prepare("
                INSERT INTO companies (name, address, postal_code, city, department, siret, contact_name, contact_email, contact_phone)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['address'] ?: null,
                $_POST['postal_code'] ?: null,
                $_POST['city'] ?: null,
                $_POST['department'] ?: null,
                $_POST['siret'] ?: null,
                $_POST['contact_name'] ?: null,
                $_POST['contact_email'] ?: null,
                $_POST['contact_phone'] ?: null,
            ]);
        }
        header('Location: /index.php?page=companies&msg=company_created');
        exit;
    }

    public function companyAddUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $company_id = (int)$_POST['company_id'];
            $name  = trim($_POST['name']);
            $email = trim($_POST['email']);
            $hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO users (company_id, role, name, email, password_hash)
                    VALUES (?, 'client', ?, ?, ?)
                ");
                $stmt->execute([$company_id, $name, $email, $hash]);
                header('Location: /index.php?page=companies&msg=user_added');
            } catch (PDOException $e) {
                header('Location: /index.php?page=companies&error=email_exists');
            }
            exit;
        }
        header('Location: /index.php?page=companies');
        exit;
    }

    public function companyDeleteUser() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'client'");
            $stmt->execute([$id]);
        }
        header('Location: /index.php?page=companies&msg=user_deleted');
        exit;
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
