<?php
return "
ALTER TABLE scripts 
ADD COLUMN page_restriction ENUM('all', 'thanks_only') DEFAULT 'all' AFTER placement;
";
