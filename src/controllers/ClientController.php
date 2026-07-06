<?php

class ClientController {

    private PDO $pdo;
    private array $user;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->user = $_SESSION['user'];
    }

    private function render(string $viewPath, array $data = []) {
        extract($data);
        $view = __DIR__ . '/../views/client/' . $viewPath;
        include __DIR__ . '/../views/client/layout.php';
    }

    public function dashboard() {
        $this->render('dashboard.php');
    }

    public function newRequest() {
        $this->render('new_request.php');
    }

    public function newRequestSubmit() {
        $stmt = $this->pdo->prepare("
            INSERT INTO mission_requests (
                company_id, user_id, status,
                site_name, site_address, site_postal_code, site_city, site_department,
                site_gps, installed_power_mwc, plant_type,
                mission_type, mission_objective, mission_context,
                desired_period, desired_duration, site_access, constraints,
                cadastral_plan_url, client_contact
            ) VALUES (
                ?, ?, 'envoyée',
                ?, ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?
            )
        ");

        $stmt->execute([
            $this->user['company_id'],
            $this->user['id'],
            $_POST['site_name'],
            $_POST['site_address'],
            $_POST['site_postal_code'],
            $_POST['site_city'],
            $_POST['site_department'],
            $_POST['site_gps'] ?? null,
            $_POST['installed_power_mwc'] ?? null,
            $_POST['plant_type'] ?? 'autre',
            $_POST['mission_type'],
            $_POST['mission_objective'] ?? null,
            $_POST['mission_context'] ?? null,
            $_POST['desired_period'] ?? null,
            $_POST['desired_duration'] ?? null,
            $_POST['site_access'] ?? null,
            $_POST['constraints'] ?? null,
            $_POST['cadastral_plan_url'] ?? null,
            $_POST['client_contact'] ?? null,
        ]);

        header('Location: /index.php?page=my_requests');
        exit;
    }

    public function myRequests() {
        $stmt = $this->pdo->prepare("SELECT * FROM mission_requests WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$this->user['id']]);
        $requests = $stmt->fetchAll();
        $this->render('my_requests.php', compact('requests'));
    }

    public function documents() {
        $stmt = $this->pdo->prepare("SELECT * FROM documents WHERE company_id = ?");
        $stmt->execute([$this->user['company_id']]);
        $documents = $stmt->fetchAll();
        $this->render('documents.php', compact('documents'));
    }

    public function invoices() {
        $stmt = $this->pdo->prepare("SELECT * FROM invoices WHERE company_id = ?");
        $stmt->execute([$this->user['company_id']]);
        $invoices = $stmt->fetchAll();
        $this->render('invoices.php', compact('invoices'));
    }
}
