<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * SystemHealthCheck Command
 *
 * Artisan command that performs a comprehensive health check
 * on the school management system, verifying database connectivity,
 * cache availability, storage permissions, and key table integrity.
 *
 * Usage: php artisan system:health
 *
 * @author Mohammed Belmekki
 */
class SystemHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a comprehensive health check on the school management system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('');
        $this->info('========================================');
        $this->info('  School Management System Health Check');
        $this->info('========================================');
        $this->info('');

        $checks = [];

        // 1. Database connectivity
        $checks[] = $this->checkDatabase();

        // 2. Cache system
        $checks[] = $this->checkCache();

        // 3. Storage permissions
        $checks[] = $this->checkStorage();

        // 4. Key tables existence
        $checks[] = $this->checkKeyTables();

        // 5. Environment configuration
        $checks[] = $this->checkEnvironment();

        $this->info('');
        $this->info('----------------------------------------');

        $failedCount = collect($checks)->filter(function ($check) {
            return !$check;
        })->count();

        if ($failedCount === 0) {
            $this->info('All checks passed! System is healthy.');
        } else {
            $this->error("{$failedCount} check(s) failed. Please review the issues above.");
        }

        $this->info('');

        return $failedCount === 0 ? 0 : 1;
    }

    /**
     * Check database connectivity.
     *
     * @return bool
     */
    protected function checkDatabase()
    {
        $this->line('Checking database connection...');

        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();
            $this->info("  [OK] Database connected: {$dbName}");
            return true;
        } catch (\Exception $e) {
            $this->error("  [FAIL] Database connection failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check cache system availability.
     *
     * @return bool
     */
    protected function checkCache()
    {
        $this->line('Checking cache system...');

        try {
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'ok', 10);
            $value = Cache::get($testKey);
            Cache::forget($testKey);

            if ($value === 'ok') {
                $driver = config('cache.default');
                $this->info("  [OK] Cache working (driver: {$driver})");
                return true;
            }

            $this->error("  [FAIL] Cache read/write mismatch");
            return false;
        } catch (\Exception $e) {
            $this->error("  [FAIL] Cache error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check storage directory permissions.
     *
     * @return bool
     */
    protected function checkStorage()
    {
        $this->line('Checking storage permissions...');

        $directories = [
            storage_path('app'),
            storage_path('framework'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
        ];

        $allWritable = true;
        foreach ($directories as $dir) {
            if (!is_writable($dir)) {
                $this->error("  [FAIL] Not writable: {$dir}");
                $allWritable = false;
            }
        }

        if ($allWritable) {
            $this->info("  [OK] All storage directories are writable");
        }

        return $allWritable;
    }

    /**
     * Check that key database tables exist.
     *
     * @return bool
     */
    protected function checkKeyTables()
    {
        $this->line('Checking key database tables...');

        $requiredTables = [
            'users',
            'roles',
            'user_roles',
            'permissions',
            'students',
            'employees',
            'i_classes',
            'sections',
            'subjects',
            'exams',
            'marks',
            'results',
            'registrations',
            'academic_years',
        ];

        $missingTables = [];

        try {
            foreach ($requiredTables as $table) {
                if (!\Schema::hasTable($table)) {
                    $missingTables[] = $table;
                }
            }

            if (empty($missingTables)) {
                $this->info("  [OK] All " . count($requiredTables) . " key tables exist");
                return true;
            }

            $this->error("  [FAIL] Missing tables: " . implode(', ', $missingTables));
            return false;
        } catch (\Exception $e) {
            $this->error("  [FAIL] Could not check tables: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check essential environment configuration.
     *
     * @return bool
     */
    protected function checkEnvironment()
    {
        $this->line('Checking environment configuration...');

        $issues = [];

        if (empty(env('APP_KEY'))) {
            $issues[] = 'APP_KEY is not set';
        }

        if (env('APP_ENV') === 'production' && env('APP_DEBUG', false)) {
            $issues[] = 'APP_DEBUG is enabled in production';
        }

        if (empty(env('DB_DATABASE'))) {
            $issues[] = 'DB_DATABASE is not configured';
        }

        if (empty($issues)) {
            $this->info("  [OK] Environment configuration looks good");
            $this->info("  Environment: " . env('APP_ENV', 'unknown'));
            $this->info("  Debug mode: " . (env('APP_DEBUG') ? 'ON' : 'OFF'));
            return true;
        }

        foreach ($issues as $issue) {
            $this->warn("  [WARN] {$issue}");
        }

        return false;
    }
}
