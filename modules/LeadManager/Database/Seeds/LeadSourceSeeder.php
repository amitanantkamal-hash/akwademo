<?php

namespace Modules\LeadManager\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSourceSeeder extends Seeder
{
    public function run()
    {
        $defaultSources = [
            'Website',
            'Phone Call',
            'Email',
            'Referral',
            'Social Media',
            'Walk-in',
            'Advertisement',
            'Trade Show',
            'Other'
        ];

        // Get all company IDs
        $companyIds = DB::table('companies')->pluck('id');

        foreach ($companyIds as $companyId) {
            foreach ($defaultSources as $source) {
                DB::table('lead_sources')->insert([
                    'company_id' => $companyId,
                    'name' => $source,
                    'description' => 'Default lead source',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}