<?php
return "
ALTER TABLE menu_links 
ADD COLUMN parent_id INT DEFAULT NULL,
ADD CONSTRAINT fk_menu_parent FOREIGN KEY (parent_id) REFERENCES menu_links(id) ON DELETE CASCADE;
";
