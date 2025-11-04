<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         Company::create([
            'name' => 'ABC Logistics',
            'email' => 'info@abc.com',
             'subdomain' => 'abc',
            'subscription_plan' => 'basic',
            'status' => true,
        ]);

        Company::create([
            'name' => 'Bharat Movers',
            'email' => 'support@bharatmovers.in',
             'subdomain' => 'bharat',
            'subscription_plan' => 'pro',
            'status' => true,
            
        ]);
    }
}
