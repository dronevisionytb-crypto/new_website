<?php

class UploadController {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function uploadDocumentSubmit() {

        $company_id = $_POST['company_id'];
        $title = $_POST['title'];

        $file = $_FILES['file'];
        $filename = time() . "_" . basename($file['name']);
        $path = "/uploads/" . $filename;

        move_uploaded_file($file['tmp_name'], __DIR__ . "/../../public/uploads/" . $filename);

        $stmt = $this->pdo->prepare("INSERT INTO documents (title, file_path, company_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $path, $company_id]);

        header("Location: /index.php?page=company_view&id=" . $company_id);
        exit;
    }
}
