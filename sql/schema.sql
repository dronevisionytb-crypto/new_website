CREATE DATABASE IF NOT EXISTS inspection_drone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inspection_drone;

CREATE TABLE companies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  address VARCHAR(255),
  postal_code VARCHAR(10),
  city VARCHAR(100),
  department VARCHAR(100),
  siret VARCHAR(20),
  contact_name VARCHAR(255),
  contact_email VARCHAR(255),
  contact_phone VARCHAR(20),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NULL,
  role ENUM('admin','client') NOT NULL DEFAULT 'client',
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL
);

CREATE TABLE mission_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  user_id INT NOT NULL,
  status ENUM('envoyée','en_etude','facture_envoyée','terminée') DEFAULT 'envoyée',
  site_name VARCHAR(255) NOT NULL,
  site_address VARCHAR(255) NOT NULL,
  site_postal_code VARCHAR(10) NOT NULL,
  site_city VARCHAR(100) NOT NULL,
  site_department VARCHAR(100) NOT NULL,
  site_gps VARCHAR(100),
  site_latitude DECIMAL(10,7) NULL,
  site_longitude DECIMAL(10,7) NULL,
  installed_power_mwc DECIMAL(10,2),
  plant_type ENUM('ombrière','toiture','sol','autre') DEFAULT 'autre',
  mission_type VARCHAR(255) NOT NULL,
  mission_objective TEXT,
  mission_context TEXT,
  desired_period VARCHAR(255),
  desired_duration VARCHAR(255),
  site_access TEXT,
  constraints TEXT,
  cadastral_plan_url VARCHAR(255),
  client_contact VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  is_signed TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mission_request_id INT NOT NULL,
  company_id INT NOT NULL,
  amount_ht DECIMAL(10,2),
  amount_ttc DECIMAL(10,2),
  status ENUM('brouillon','envoyée','payée') DEFAULT 'brouillon',
  file_path VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (mission_request_id) REFERENCES mission_requests(id) ON DELETE CASCADE,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Création d'un admin par défaut (à changer après installation)
INSERT INTO users (company_id, role, name, email, password_hash)
VALUES (NULL, 'admin', 'Johan', 'admin@local',
        '$2y$10$8m8t8qkVqjvE0q8u5p8r8O8q8m8t8qkVqjvE0q8u5p8r8O8q8m8t8q');

-- Remplace ce hash par un vrai généré avec password_hash en PHP.
