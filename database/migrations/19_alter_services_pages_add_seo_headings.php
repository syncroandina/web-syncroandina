<?php
return "
ALTER TABLE services_pages 
ADD COLUMN heading_description VARCHAR(255) DEFAULT 'Descripción',
ADD COLUMN heading_details VARCHAR(255) DEFAULT 'Detalles del servicio',
ADD COLUMN heading_gallery VARCHAR(255) DEFAULT 'Trabajos Realizados',
ADD COLUMN heading_cta VARCHAR(255) DEFAULT '¿Interesado en este Servicio?',
ADD COLUMN cta_description VARCHAR(1000) DEFAULT 'Nuestro equipo de especialistas está listo para diseñar una cotización personalizada adaptada a los requerimientos de tu proyecto.';
";
