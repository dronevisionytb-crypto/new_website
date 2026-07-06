<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../src/helpers/auth.php';

$pdo = get_pdo();

require __DIR__ . '/../src/controllers/ClientController.php';
require __DIR__ . '/../src/controllers/AdminController.php';
require __DIR__ . '/../src/controllers/UploadController.php';

$page = $_GET['page'] ?? 'dashboard';

if (!is_logged_in()) {
    header('Location: /login.php');
    exit;
}

$user = $_SESSION['user'];

if ($user['role'] === 'admin') {
    $controller = new AdminController($pdo);
} else {
    $controller = new ClientController($pdo);
}

switch ($page) {
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'new_request':
        $controller->newRequest();
        break;
    case 'new_request_submit':
        $controller->newRequestSubmit();
        break;
    case 'my_requests':
        $controller->myRequests();
        break;
    case 'documents':
        $controller->documents();
        break;
    case 'invoices':
        $controller->invoices();
        break;
    case 'companies':
        $controller->companies();
        break;
    case 'companies_create':
        $controller->companiesCreate();
        break;
    case 'company_user_create':
        $controller->companyUserCreate();
        break;
    case 'company_user_delete':
        $controller->companyUserDelete();
        break;
    case 'company_view':
        $controller->companyView();
        break;
    case 'users':
        $controller->users();
        break;
    case 'users_create':
        $controller->usersCreate();
        break;
    case 'upload_document':
        (new AdminController($pdo))->uploadDocumentForm();
        break;
    case 'upload_document_submit':
        (new UploadController($pdo))->uploadDocumentSubmit();
        break;
    default:
        $controller->dashboard();
}
