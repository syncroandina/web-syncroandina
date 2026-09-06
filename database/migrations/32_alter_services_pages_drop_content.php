<?php
return "
UPDATE services_pages SET consists_of = content WHERE (consists_of IS NULL OR consists_of = '') AND content IS NOT NULL AND content != '';
ALTER TABLE services_pages DROP COLUMN content;
";
