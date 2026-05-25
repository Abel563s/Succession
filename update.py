import os
import re

controllers = [
    'NineBoxController.php',
    'MentorController.php',
    'CoachingController.php',
    'ProgressController.php',
    'SuccessionDashboardController.php',
    'LeadershipController.php',
    'TransitionController.php',
    'CriticalRoleController.php',
    'DevelopmentController.php',
    'TrainingController.php'
]

base_dir = r"c:\Users\Dark\Videos\success-app\app\Http\Controllers\Admin"

pattern_index_dept = re.compile(
    r"if \(\! auth\(\)->user\(\)->isAdmin\(\)\) \{\s*"
    r"\$deptName = auth\(\)->user\(\)->department \? auth\(\)->user\(\)->department->name : null;\s*"
    r"if \(\$deptName\) \{\s*"
    r"\$query->where\('department', \$deptName\);\s*"
    r"\} else \{\s*"
    r"\$query->where(?:Raw\('1 = 0'\)|id, 0);\s*"
    r"\}\s*"
    r"\}",
    re.MULTILINE
)

pattern_index_dept2 = re.compile(
    r"if \(\! auth\(\)->user\(\)->isAdmin\(\)\) \{\s*"
    r"\$deptName = auth\(\)->user\(\)->department \? auth\(\)->user\(\)->department->name : null;\s*"
    r"if \(\$deptName\) \{\s*"
    r"\$query->where\('department', \$deptName\);\s*"
    r"\} else \{\s*"
    r"\$query->where\('id', 0\);\s*"
    r"\}\s*"
    r"\}",
    re.MULTILINE
)


pattern_store = re.compile(r"(\$\w+)\s*=\s*(\w+)::create\(\$validated\);")

for c in controllers:
    path = os.path.join(base_dir, c)
    if not os.path.exists(path):
        continue
        
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    col = 'user_id' if c == 'TransitionController.php' else 'created_by'
    
    # Replace index
    replacement = f"if (! auth()->user()->isAdmin()) {{\n            $query->where('{col}', auth()->id());\n        }}"
    content = pattern_index_dept.sub(replacement, content)
    content = pattern_index_dept2.sub(replacement, content)
    
    # Check if already added
    if col not in content.split('::create')[0][-50:]:
        replacement_store = f"$validated['{col}'] = auth()->id();\n        \\1 = \\2::create($validated);"
        content = pattern_store.sub(replacement_store, content)
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"Updated {c}")
