<?php
$file = 'register.php';
$content = file_get_contents($file);

// We need to parse all field blocks. 
// A field block looks like <div<?php echo sathi_reg_field_wrap_attrs('FIELD_NAME'... </div>
// It might be nested. A simple way is to use regex to find each block.

$pattern = '/<div<\?php echo sathi_reg_field_wrap_attrs\(\'([^\']+)\'(?:, \'[^\']+\')?\); \?>.*?<\/div>\s*<\/div>\s*<\/div>/s';
// Wait, the closing tags can vary because some fields are inside grids, some aren't.
// Let's use a simpler approach. I will split the document by panels, but that doesn't help extracting.
