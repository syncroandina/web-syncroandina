<?php
return "
ALTER TABLE blog_posts 
ADD COLUMN cta_tagline VARCHAR(255) DEFAULT NULL AFTER image_alt,
ADD COLUMN cta_title VARCHAR(255) DEFAULT NULL AFTER cta_tagline,
ADD COLUMN cta_description TEXT DEFAULT NULL AFTER cta_title,
ADD COLUMN cta_btn_text VARCHAR(255) DEFAULT NULL AFTER cta_description;
";
