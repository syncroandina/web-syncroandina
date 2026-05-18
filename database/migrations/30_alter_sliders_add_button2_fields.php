<?php
return "
ALTER TABLE sliders 
ADD COLUMN button2_text VARCHAR(100) DEFAULT NULL AFTER button_link,
ADD COLUMN button2_link VARCHAR(255) DEFAULT NULL AFTER button2_text;
";
