<?php

namespace Database\Seeders;

use App\Models\JobFamily;
use Illuminate\Database\Seeder;

class JobFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Teaching', 'code' => 'TEA', 'status' => 'active', 'sort_order' => 1],
            ['name' => 'Administration', 'code' => 'ADM', 'status' => 'active', 'sort_order' => 2],
            ['name' => 'Operations', 'code' => 'OPS', 'status' => 'active', 'sort_order' => 3],
            ['name' => 'Technology', 'code' => 'TEC', 'status' => 'active', 'sort_order' => 4],
        ])->each(fn (array $jobFamily): JobFamily => JobFamily::query()->updateOrCreate(
            ['code' => $jobFamily['code']],
            $jobFamily
        ));
    }
}
