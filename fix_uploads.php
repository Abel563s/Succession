<?php

$baseDir = 'c:/Users/Dark/Videos/success-app';

// 1. Update index.blade.php
$indexFiles = glob($baseDir . '/resources/views/admin/*/index.blade.php');
foreach ($indexFiles as $file) {
    $content = file_get_contents($file);
    if (strpos($content, '@if(auth()->user()->isAdmin())') !== false) {
        $content = str_replace(
            '@if(auth()->user()->isAdmin())',
            '@if(auth()->user()->isAdmin() || (auth()->user()->isManager() && $record->approval_status === \'pending\'))',
            $content
        );
        file_put_contents($file, $content);
        echo "Updated index view: $file\n";
    }
}

// 2. Update create.blade.php
$createFiles = glob($baseDir . '/resources/views/admin/*/create.blade.php');
foreach ($createFiles as $file) {
    $content = file_get_contents($file);
    
    // Fix required attribute on signature input
    if (strpos($content, 'name="signature"') !== false && strpos($content, 'required') !== false) {
        // Find the input element and replace required with conditional required
        $content = preg_replace(
            '/<input type="file" name="signature"([^>]*)required([^>]*)/i',
            '<input type="file" name="signature"$1{{ auth()->user()->signature_path ? \'\' : \'required\' }}$2',
            $content
        );
        
        // Add a preview or message if signature exists
        if (strpos($content, '<!-- Existing Signature Preview -->') === false) {
            $existingSignatureHtml = '
                            @if(auth()->user()->signature_path)
                                <!-- Existing Signature Preview -->
                                <div class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                                        <span class="text-sm font-bold text-emerald-700">Signature on file will be used. You can upload a new one to override it.</span>
                                    </div>
                                    <img src="{{ \App\Support\StorageUrl::public(auth()->user()->signature_path) }}" class="h-10 rounded border border-emerald-200" alt="Existing Signature">
                                </div>
                            @endif
            ';
            
            // Insert after the input
            $content = preg_replace(
                '/(<input type="file" name="signature"[\s\S]*?<\/label>)/i',
                '$1' . "\n" . $existingSignatureHtml,
                $content
            );
        }
        
        file_put_contents($file, $content);
        echo "Updated create view: $file\n";
    }
}

// 3. Update Controllers
$controllers = glob($baseDir . '/app/Http/Controllers/Admin/*Controller.php');
foreach ($controllers as $file) {
    $content = file_get_contents($file);
    $changed = false;
    
    // Replace validation
    if (strpos($content, "'signature' => 'required|image|max:500'") !== false) {
        $content = str_replace(
            "'signature' => 'required|image|max:500'",
            "'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500'",
            $content
        );
        $changed = true;
    }
    
    // Add logic to use existing signature if not uploaded
    $searchBlock = "if (\$request->hasFile('signature')) {
            \$validated['signature_path'] = \$request->file('signature')->store('signatures', 'public');
        }";
    $replaceBlock = "if (\$request->hasFile('signature')) {
            \$validated['signature_path'] = \$request->file('signature')->store('signatures', 'public');
        } elseif (auth()->user()->signature_path) {
            \$validated['signature_path'] = auth()->user()->signature_path;
        }";

    if (strpos($content, $searchBlock) !== false) {
        $content = str_replace($searchBlock, $replaceBlock, $content);
        $changed = true;
    }

    if ($changed) {
        file_put_contents($file, $content);
        echo "Updated controller: $file\n";
    }
}

echo "Done.\n";
