$baseDir = "C:\Users\Dark\Videos\success-app"

# 1. Update index.blade.php
$indexFiles = Get-ChildItem -Path "$baseDir\resources\views\admin" -Filter "index.blade.php" -Recurse
foreach ($file in $indexFiles) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    if ($content.Contains("@if(auth()->user()->isAdmin())")) {
        $content = $content.Replace("@if(auth()->user()->isAdmin())", "@if(auth()->user()->isAdmin() || (auth()->user()->isManager() && `$record->approval_status === 'pending'))")
        [System.IO.File]::WriteAllText($file.FullName, $content, [System.Text.Encoding]::UTF8)
        Write-Host "Updated index view: $($file.FullName)"
    }
}

# 2. Update create.blade.php
$createFiles = Get-ChildItem -Path "$baseDir\resources\views\admin" -Filter "create.blade.php" -Recurse
foreach ($file in $createFiles) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    if ($content -match 'name="signature"' -and $content -match 'required') {
        $content = $content -replace '<input type="file" name="signature"([^>]*)required', '<input type="file" name="signature"$1{{ auth()->user()->signature_path ? '''' : ''required'' }}'
        
        if ($content -notmatch '<!-- Existing Signature Preview -->') {
            $existingSignatureHtml = "
                            @if(auth()->user()->signature_path)
                                <!-- Existing Signature Preview -->
                                <div class=`"mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center justify-between`">
                                    <div class=`"flex items-center gap-3`">
                                        <i data-lucide=`"check-circle`" class=`"w-5 h-5 text-emerald-500`"></i>
                                        <span class=`"text-sm font-bold text-emerald-700`">Signature on file will be used. You can upload a new one to override it.</span>
                                    </div>
                                    <img src=`"{{ \App\Support\StorageUrl::public(auth()->user()->signature_path) }}`" class=`"h-10 rounded border border-emerald-200`" alt=`"Existing Signature`">
                                </div>
                            @endif
            "
            $content = $content -replace '(<input type="file" name="signature"[\s\S]*?</label>)', "`$1`n$existingSignatureHtml"
        }
        [System.IO.File]::WriteAllText($file.FullName, $content, [System.Text.Encoding]::UTF8)
        Write-Host "Updated create view: $($file.FullName)"
    }
}

# 3. Update Controllers
$controllers = Get-ChildItem -Path "$baseDir\app\Http\Controllers\Admin" -Filter "*Controller.php"
foreach ($file in $controllers) {
    $content = [System.IO.File]::ReadAllText($file.FullName)
    $changed = $false
    
    if ($content.Contains("'signature' => 'required|image|max:500'")) {
        $content = $content.Replace("'signature' => 'required|image|max:500'", "'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500'")
        $changed = $true
    }
    
    $searchBlock = "if (`$request->hasFile('signature')) {
            `$validated['signature_path'] = `$request->file('signature')->store('signatures', 'public');
        }"
    $replaceBlock = "if (`$request->hasFile('signature')) {
            `$validated['signature_path'] = `$request->file('signature')->store('signatures', 'public');
        } elseif (auth()->user()->signature_path) {
            `$validated['signature_path'] = auth()->user()->signature_path;
        }"
        
    if ($content.Contains($searchBlock)) {
        $content = $content.Replace($searchBlock, $replaceBlock)
        $changed = $true
    }

    if ($changed) {
        [System.IO.File]::WriteAllText($file.FullName, $content, [System.Text.Encoding]::UTF8)
        Write-Host "Updated controller: $($file.FullName)"
    }
}
