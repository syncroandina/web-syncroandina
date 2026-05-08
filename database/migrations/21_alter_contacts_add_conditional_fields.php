<?php
return "
ALTER TABLE contacts 
ADD COLUMN client_type VARCHAR(50) DEFAULT 'persona',
ADD COLUMN ruc VARCHAR(20) DEFAULT NULL,
ADD COLUMN service_id INT DEFAULT NULL,
ADD FOREIGN KEY (service_id) REFERENCES services_pages(id) ON DELETE SET NULL;
";
