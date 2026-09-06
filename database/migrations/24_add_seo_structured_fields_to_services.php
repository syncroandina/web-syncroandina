<?php
return "
ALTER TABLE services_pages 
ADD COLUMN consists_of TEXT DEFAULT NULL,
ADD COLUMN types_json LONGTEXT DEFAULT NULL,
ADD COLUMN benefits_json LONGTEXT DEFAULT NULL,
ADD COLUMN process_json LONGTEXT DEFAULT NULL,
ADD COLUMN materials_methodology TEXT DEFAULT NULL,
ADD COLUMN pricing_timeline TEXT DEFAULT NULL,
ADD COLUMN why_choose_us TEXT DEFAULT NULL,
ADD COLUMN coverage TEXT DEFAULT NULL,
ADD COLUMN faqs_json LONGTEXT DEFAULT NULL,
ADD COLUMN related_services_json TEXT DEFAULT NULL,
ADD COLUMN heading_consists_of VARCHAR(255) DEFAULT '¿En qué consiste?',
ADD COLUMN heading_types VARCHAR(255) DEFAULT 'Tipos de servicio',
ADD COLUMN heading_benefits VARCHAR(255) DEFAULT 'Beneficios',
ADD COLUMN heading_process VARCHAR(255) DEFAULT 'Proceso de trabajo',
ADD COLUMN heading_materials VARCHAR(255) DEFAULT 'Materiales o metodología',
ADD COLUMN heading_pricing VARCHAR(255) DEFAULT 'Precio y tiempo',
ADD COLUMN heading_why_choose_us VARCHAR(255) DEFAULT '¿Por qué elegirnos?',
ADD COLUMN heading_coverage VARCHAR(255) DEFAULT 'Cobertura',
ADD COLUMN heading_faqs VARCHAR(255) DEFAULT 'Preguntas frecuentes',
ADD COLUMN heading_related VARCHAR(255) DEFAULT 'Servicios relacionados';
";
