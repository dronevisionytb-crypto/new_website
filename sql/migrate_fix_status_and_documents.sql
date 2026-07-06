-- Migration: fix mission_requests status ENUM and add company_id to documents
-- Run this against your existing database (inspection_drone)

USE inspection_drone;

-- 1. Add 'nouvelle' to the mission_requests status ENUM
ALTER TABLE mission_requests
  MODIFY COLUMN status ENUM('nouvelle','envoyée','en_etude','facture_envoyée','terminée') DEFAULT 'nouvelle';

-- 2. Add company_id column to documents (if it doesn't exist)
ALTER TABLE documents
  ADD COLUMN company_id INT NOT NULL AFTER id,
  ADD CONSTRAINT fk_documents_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE;
