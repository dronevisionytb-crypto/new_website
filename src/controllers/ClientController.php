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
        $this->render('dashboard.php');
    }

    public function newRequest() {
        $csrfToken = $this->getCsrfToken();
        $error = $_GET['error'] ?? null;
        $this->render('new_request.php', compact('csrfToken', 'error'));
    }

    public function newRequestSubmit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?page=new_request');
            exit;
        }
        if (!$this->hasValidCsrfToken($_POST['csrf_token'] ?? null)) {
            header('Location: /index.php?page=new_request&error=csrf_invalid');
            exit;
        }

        $requiredFields = ['site_name', 'site_address', 'site_postal_code', 'site_city', 'site_department', 'mission_type', 'desired_period'];
        foreach ($requiredFields as $field) {
            if (trim((string)($_POST[$field] ?? '')) === '') {
                header('Location: /index.php?page=new_request&error=missing_required_fields');
                exit;
            }
        }

        $latitude = $this->normalizeCoordinate($_POST['site_latitude'] ?? null, -90, 90);
        $longitude = $this->normalizeCoordinate($_POST['site_longitude'] ?? null, -180, 180);
        $siteGps = trim((string)($_POST['site_gps'] ?? ''));

        if ($latitude !== null && $longitude !== null) {
            $siteGps = sprintf('%.6f, %.6f', $latitude, $longitude);
        } elseif ($siteGps === '') {
            $siteGps = null;
        }

        $paramsWithCoordinates = [
            $this->user['company_id'],
            $this->user['id'],
            $_POST['site_name'],
            $_POST['site_address'],
            $_POST['site_postal_code'],
            $_POST['site_city'],
            $_POST['site_department'],
            $siteGps,
            $latitude,
            $longitude,
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
        ];

        $paramsWithoutCoordinates = [
            $this->user['company_id'],
            $this->user['id'],
            $_POST['site_name'],
            $_POST['site_address'],
            $_POST['site_postal_code'],
            $_POST['site_city'],
            $_POST['site_department'],
            $siteGps,
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
        ];

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO mission_requests (
                    company_id, user_id, status,
                    site_name, site_address, site_postal_code, site_city, site_department,
                    site_gps, site_latitude, site_longitude, installed_power_mwc, plant_type,
                    mission_type, mission_objective, mission_context,
                    desired_period, desired_duration, site_access, constraints,
                    cadastral_plan_url, client_contact
                ) VALUES (
                    ?, ?, 'envoyée',
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?,
                    ?, ?, ?, ?,
                    ?, ?
                )
            ");
            $stmt->execute($paramsWithCoordinates);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) !== 1054) {
                throw $e;
            }
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
            $stmt->execute($paramsWithoutCoordinates);
        }

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

    private function normalizeCoordinate($value, float $min, float $max): ?float {
        if ($value === null || $value === '') {
            return null;
        }
        if (!is_numeric($value)) {
            return null;
        }
        $floatValue = (float)$value;
        if ($floatValue < $min || $floatValue > $max) {
            return null;
        }
        return round($floatValue, 7);
    }
}
