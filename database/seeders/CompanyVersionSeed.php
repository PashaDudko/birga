<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyVersionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Company::all() as $company) {
            CompanyVersion::factory(1, [
                'company_id' => $company->id,
                'data' => serialize([
                    'name' => $company->name,
                    'edrpou' => $company->edrpou,
                    'address' => $company->address,
                ])
            ])->create();
        }
    }
}
