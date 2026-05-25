<?php

$controllers = [
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
];

foreach ($controllers as $controller) {
    $path = "c:/Users/Dark/Videos/success-app/app/Http/Controllers/Admin/" . $controller;
    if (!file_exists($path)) {
        echo "Missing: $path\n";
        continue;
    }
    
    $content = file_get_contents($path);
    $column = ($controller === 'TransitionController.php') ? 'user_id' : 'created_by';
    
    // Replace index query filter
    $searchDeptName = <<<'EOD'
        if (! auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->whereRaw('1 = 0');
            }
        }
EOD;

    $replaceDeptName = <<<EOD
        if (! auth()->user()->isAdmin()) {
            \$query->where('$column', auth()->id());
        }
EOD;

    // Alternative dept name block sometimes formatted differently
    $searchDeptName2 = <<<'EOD'
        if (! auth()->user()->isAdmin()) {
            $deptName = auth()->user()->department ? auth()->user()->department->name : null;
            if ($deptName) {
                $query->where('department', $deptName);
            } else {
                $query->where('id', 0);
            }
        }
EOD;

    $content = str_replace($searchDeptName, $replaceDeptName, $content);
    $content = str_replace($searchDeptName2, $replaceDeptName, $content);
    
    // Add created_by to store method
    // Find: $model = Model::create($validated);
    // Replace: $validated['created_by'] = auth()->id(); \n $model = Model::create($validated);
    
    $pattern = '/(\$[a-zA-Z0-9_]+)\s*=\s*([a-zA-Z0-9_]+)::create\(\$validated\);/';
    $replacement = "\$validated['$column'] = auth()->id();\n        $1 = $2::create(\$validated);";
    $content = preg_replace($pattern, $replacement, $content);
    
    file_put_contents($path, $content);
    echo "Updated $controller\n";
}
