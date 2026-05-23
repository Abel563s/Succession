<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views/admin');
$iterator = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($iterator, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$search = '/@change="const file = \$event\.target\.files\[0\]; if \(file\) \{ const reader = new FileReader\(\); reader\.onload = \(e\) => preview = e\.target\.result; reader\.readAsDataURL\(file\); \}"/';

$replace = '@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert(\'File too large. Maximum size is 500KB.\'); $event.target.value = \'\'; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"';

$search2 = '/@change="const file = \$event\.target\.files\[0\]; if \(file\) \{ const reader = new FileReader\(\); reader\.onload = \(e\) => preview = e\.target\.result; reader\.readAsDataURL\(file\); \} else \{ preview = null; \}"/';

$replace2 = '@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert(\'File too large. Maximum size is 500KB.\'); $event.target.value = \'\'; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"';


foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $newContent = preg_replace($search, $replace, $content);
    $newContent = preg_replace($search2, $replace2, $newContent);
    
    // Also replace text "(Max 2MB)" with "(Max 500KB)"
    $newContent = str_replace('(Max 2MB)', '(Max 500KB)', $newContent);
    $newContent = str_replace('Max 2MB', 'Max 500KB', $newContent);
    
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated: $path\n";
    }
}
echo "Done.\n";
