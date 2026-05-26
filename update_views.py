import os
import glob
import re

count_index = 0
for filepath in glob.glob('resources/views/admin/*/index.blade.php', recursive=True):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    if '@if(auth()->user()->isAdmin())' in content:
        new_content = content.replace(
            '@if(auth()->user()->isAdmin())',
            '@if(auth()->user()->isAdmin() || (auth()->user()->isManager() && $record->approval_status === \'pending\'))'
        )
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        count_index += 1
        print(f'Updated {filepath}')
print(f'Total index files updated: {count_index}')
