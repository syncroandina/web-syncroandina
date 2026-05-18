<?php
return "
ALTER TABLE contacts 
ADD COLUMN project_id INT DEFAULT NULL,
ADD COLUMN product_id INT DEFAULT NULL,
ADD FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
ADD FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL;
";
