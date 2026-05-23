$Path = "resources\views\admin"
$Search1 = '@change="const file = \$event.target.files\[0\]; if \(file\) \{ const reader = new FileReader\(\); reader.onload = \(e\) => preview = e.target.result; reader.readAsDataURL\(file\); \}"'
$Replace1 = '@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert(''File too large. Maximum size is 500KB.''); $event.target.value = ''''; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"'

$Search2 = '@change="const file = \$event.target.files\[0\]; if \(file\) \{ const reader = new FileReader\(\); reader.onload = \(e\) => preview = e.target.result; reader.readAsDataURL\(file\); \} else \{ preview = null; \}"'
$Replace2 = '@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert(''File too large. Maximum size is 500KB.''); $event.target.value = ''''; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"'

Get-ChildItem -Path $Path -Filter "*.blade.php" -Recurse | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    $newContent = $content -replace $Search1, $Replace1
    $newContent = $newContent -replace $Search2, $Replace2
    $newContent = $newContent -replace '\(Max 2MB\)', '(Max 500KB)'
    $newContent = $newContent -replace 'Max 2MB', 'Max 500KB'
    
    if ($content -ne $newContent) {
        Set-Content -Path $_.FullName -Value $newContent -NoNewline
        Write-Host "Updated $($_.FullName)"
    }
}
