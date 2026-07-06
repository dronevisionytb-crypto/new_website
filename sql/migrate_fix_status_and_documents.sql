-- Migration: fix mission_requests status ENUM and add company_id to documents
-- Run this against your existing database (inspection_drone)

USE inspection_drone;

-- 1. Add 'nouvelle' to the mission_requests status ENUM
ALTER TABLE mission_requests
  MODIFY COLUMN status ENUM('nouvelle','envoyée','en_etude','facture_envoyée','terminée') DEFAULT 'nouvelle';

-- 2. Add company_id column to documents
--    Step a: add as nullable first (safe if the table already has rows)
ALTER TABLE documents
  ADD COLUMN company_id INT NULL AFTER id;

--    Step b: if you have existing rows, update them to a valid company before the next step:
--    UPDATE documents SET company_id = <your_company_id> WHERE company_id IS NULL;

--    Step c: once all rows have a company_id, enforce NOT NULL and add the FK
ALTER TABLE documents
  MODIFY COLUMN company_id INT NOT NULL,
  ADD CONSTRAINT fk_documents_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE;
