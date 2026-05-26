const fs = require('fs');
const path = require('path');

const baseDir = 'C:/Users/Dark/Videos/success-app';

function glob(dir, ext) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        if (stat && stat.isDirectory()) {
            results = results.concat(glob(filePath, ext));
        } else if (file.endsWith(ext)) {
            results.push(filePath);
        }
    });
    return results;
}

// 1. Update create.blade.php
const createFiles = glob(path.join(baseDir, 'resources/views/admin'), 'create.blade.php');
createFiles.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    let changed = false;
    
    // Fix signature inputs (can be named signature or manager_sig)
    const regex = /<input[^>]*type="file"[^>]*name="(signature|manager_sig)"([^>]*)required([^>]*)/i;
    if (regex.test(content)) {
        content = content.replace(regex, '<input type="file" name="$1"$2{{ auth()->user()->signature_path ? \'\' : \'required\' }}$3');
        changed = true;
    }

    if (changed && !content.includes('<!-- Existing Signature Preview -->')) {
        const existingSignatureHtml = `
                            @if(auth()->user()->signature_path)
                                <!-- Existing Signature Preview -->
                                <div class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                                        <span class="text-sm font-bold text-emerald-700">Signature on file will be used. You can upload a new one to override it.</span>
                                    </div>
                                    <img src="{{ \\App\\Support\\StorageUrl::public(auth()->user()->signature_path) }}" class="h-10 rounded border border-emerald-200" alt="Existing Signature">
                                    <input type="hidden" name="use_saved_signature" value="1">
                                </div>
                            @endif
        `;
        content = content.replace(/(<input[^>]*type="file"[^>]*name="(?:signature|manager_sig)"[\s\S]*?<\/label>)/i, '$1\n' + existingSignatureHtml);
        fs.writeFileSync(file, content, 'utf8');
        console.log(`Updated create view: ${file}`);
    }
});

// 2. Update Controllers
const controllerFiles = glob(path.join(baseDir, 'app/Http/Controllers/Admin'), 'Controller.php');
controllerFiles.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    let changed = false;
    
    if (content.includes("'signature' => 'required|image|max:500'")) {
        content = content.replace(
            "'signature' => 'required|image|max:500'", 
            "'signature' => auth()->user()->signature_path ? 'nullable|image|max:500' : 'required|image|max:500'"
        );
        changed = true;
    }
    
    const searchBlock = `if ($request->hasFile('signature')) {
            $validated['signature_path'] = $request->file('signature')->store('signatures', 'public');
        }`;
    const replaceBlock = `if ($request->hasFile('signature')) {
            $validated['signature_path'] = $request->file('signature')->store('signatures', 'public');
        } elseif (auth()->user()->signature_path) {
            $validated['signature_path'] = auth()->user()->signature_path;
        }`;
        
    if (content.includes(searchBlock)) {
        content = content.replace(searchBlock, replaceBlock);
        changed = true;
    }

    if (changed) {
        fs.writeFileSync(file, content, 'utf8');
        console.log(`Updated controller: ${file}`);
    }
});

console.log("Done.");
