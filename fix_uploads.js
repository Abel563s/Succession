const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            if (file.endsWith('.blade.php')) results.push(file);
        }
    });
    return results;
}

const search1 = '@change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"';
const replace1 = `@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert('File too large. Maximum size is 500KB.'); $event.target.value = ''; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"`;

const search2 = '@change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }"';
const replace2 = `@change="const file = $event.target.files[0]; if (file) { if (file.size > 512000) { alert('File too large. Maximum size is 500KB.'); $event.target.value = ''; preview = null; } else { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } } else { preview = null; }"`;

const files = walk('c:/Users/Dark/Videos/success-app/resources/views/admin');
files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    let newContent = content.replace(search1, replace1).replace(search2, replace2).replace(/\(Max 2MB\)/g, '(Max 500KB)').replace(/Max 2MB/g, 'Max 500KB');
    if (content !== newContent) {
        fs.writeFileSync(file, newContent, 'utf8');
        console.log('Updated: ' + file);
    }
});
