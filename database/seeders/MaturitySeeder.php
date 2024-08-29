<?php

namespace Database\Seeders;

use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MaturitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $maturityLevels = [
            [
                'maturity_name' => 'Incomplete',
                'maturity_description' => 'Incomplete process with no standards or control.',
                'maturity_level' => 0,
            ],
            [
                'maturity_name' => 'Initial',
                'maturity_description' => 'Unpredictable process, little control.',
                'maturity_level' => 1,
            ],
            [
                'maturity_name' => 'Managed',
                'maturity_description' => 'Process by project, defined documentation.',
                'maturity_level' => 2,
            ],
            [
                'maturity_name' => 'Defined',
                'maturity_description' => 'Standardization of the processes in the organization, consistency in processes.',
                'maturity_level' => 3,
            ],
            [
                'maturity_name' => 'Quantitatively Managed',
                'maturity_description' => 'Measurable and predictable processes.',
                'maturity_level' => 4,
            ],
            [
                'maturity_name' => 'Optimizing',
                'maturity_description' => 'Continuous process improvement.',
                'maturity_level' => 5,
            ],
        ];

        // Loop through the array and create each maturity level
        foreach ($maturityLevels as $level) {
            MaturityLevel::create($level);
        }

    }
}
