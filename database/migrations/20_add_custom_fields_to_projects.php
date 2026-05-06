<?php
return "
ALTER TABLE projects 
ADD COLUMN challenge_title VARCHAR(255) DEFAULT 'El Reto',
ADD COLUMN challenge_desc TEXT NULL,
ADD COLUMN solution_title VARCHAR(255) DEFAULT 'La Solución',
ADD COLUMN solution_desc TEXT NULL,
ADD COLUMN impact_label VARCHAR(255) DEFAULT 'Impacto Logrado',
ADD COLUMN impact_value VARCHAR(255) DEFAULT '100% Optimizado';
";
