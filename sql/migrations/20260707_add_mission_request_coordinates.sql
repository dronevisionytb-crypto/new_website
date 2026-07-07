ALTER TABLE mission_requests
  ADD COLUMN site_latitude DECIMAL(10,7) NULL AFTER site_gps,
  ADD COLUMN site_longitude DECIMAL(10,7) NULL AFTER site_latitude;
