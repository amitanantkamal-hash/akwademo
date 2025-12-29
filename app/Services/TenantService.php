<?php

// app/Services/TenantService.php
namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantService
{
    public static function setTenant(int $companyId): void
    {
        $company = Company::findOrFail($companyId);
        
        // Set tenant in container
        app()->instance(Company::class, $company);
        
        // Optional: Switch database connection if using separate databases
        if (config('tenancy.mode') === 'database') {
            self::switchDatabaseConnection($company);
        }
        
        // Optional: Set storage paths
        Config::set('filesystems.disks.tenant.root', storage_path("tenants/{$companyId}"));
    }

    protected static function switchDatabaseConnection(Company $company): void
    {
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('DB_TENANT_HOST', '127.0.0.1'),
            'port' => env('DB_TENANT_PORT', '3306'),
            'database' => $company->database_name,
            'username' => env('DB_TENANT_USERNAME'),
            'password' => env('DB_TENANT_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}