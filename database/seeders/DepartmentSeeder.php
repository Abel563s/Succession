<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Building', 'code' => 'BLDG', 'description' => 'Building department and infrastructure development'],
            ['name' => 'CEO Office', 'code' => 'CEO', 'description' => 'Chief Executive Officer suite and corporate leadership'],
            ['name' => 'Commercial', 'code' => 'COMM', 'description' => 'Commercial, sales, and business partnerships'],
            ['name' => 'Compliance & Control', 'code' => 'COMP', 'description' => 'Regulatory compliance and internal control protocols'],
            ['name' => 'Design', 'code' => 'DSGN', 'description' => 'Product design, engineering, and architectural planning'],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Financial operations, accounts, and investment strategy'],
            ['name' => 'HR', 'code' => 'HR', 'description' => 'Human Resources, talent acquisition, and workforce management'],
            ['name' => 'HSE', 'code' => 'HSE', 'description' => 'Health, Safety, and Environment protocols'],
            ['name' => 'Infrastructure', 'code' => 'INFRA', 'description' => 'Physical and system infrastructure systems'],
            ['name' => 'IT', 'code' => 'IT', 'description' => 'Information Technology, cloud services, and security support'],
            ['name' => 'Legal', 'code' => 'LEG', 'description' => 'Legal affairs, contract reviews, and statutory counsel'],
            ['name' => 'MEP', 'code' => 'MEP', 'description' => 'Mechanical, Electrical, and Plumbing engineering operations'],
            ['name' => 'Operation', 'code' => 'OPS', 'description' => 'Core operations, site production, and service execution'],
            ['name' => 'Partnering', 'code' => 'PART', 'description' => 'Strategic partnering, alliances, and joint ventures'],
            ['name' => 'Plant & EQ', 'code' => 'PEQ', 'description' => 'Heavy equipment management and machinery logistics'],
            ['name' => 'Planning', 'code' => 'PLAN', 'description' => 'Project controls, planning metrics, and timelines'],
            ['name' => 'Procurement', 'code' => 'PROC', 'description' => 'Strategic sourcing, purchasing, and vendor relations'],
            ['name' => 'QAQC', 'code' => 'QAQC', 'description' => 'Quality Assurance and Quality Control standards'],
            ['name' => 'Water & Energy', 'code' => 'WE', 'description' => 'Utilities, energy conservation, and water resources management'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
