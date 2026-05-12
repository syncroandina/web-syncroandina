<?php
return "
ALTER TABLE blog_posts 
ADD COLUMN category_id INT DEFAULT NULL AFTER author_id,
ADD CONSTRAINT fk_blog_post_category FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL;
";
