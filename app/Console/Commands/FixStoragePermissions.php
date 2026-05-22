<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStoragePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage and cache permissions, and recreate the public/storage symlink using a relative path for cPanel/Apache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Starting Storage & Cache Permissions Fix ===');

        $storagePath = storage_path();
        $cachePath = base_path('bootstrap/cache');
        $storageLink = public_path('storage');

        // 1. Fix permissions recursively
        $this->info("Fixing permissions for {$storagePath}...");
        $this->chmodRecursive($storagePath);

        $this->info("Fixing permissions for {$cachePath}...");
        $this->chmodRecursive($cachePath);

        // 2. Output current owner/group info if possible
        if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
            $ownerInfo = posix_getpwuid(fileowner($storagePath));
            $groupInfo = posix_getgrgid(filegroup($storagePath));
            $ownerName = $ownerInfo ? $ownerInfo['name'] : 'unknown';
            $groupName = $groupInfo ? $groupInfo['name'] : 'unknown';
            $this->line("Current storage directory owner: <comment>{$ownerName}</comment>, group: <comment>{$groupName}</comment>");
        } else {
            $this->line("Unable to determine owner/group info (non-POSIX system or function disabled).");
        }

        // 3. Recreate the symlink
        if (file_exists($storageLink) || is_link($storageLink)) {
            $this->info("Removing existing storage link/directory at {$storageLink}...");
            if (is_link($storageLink)) {
                if (PHP_OS_FAMILY === 'Windows') {
                    if (is_dir($storageLink)) {
                        @rmdir($storageLink);
                    } else {
                        @unlink($storageLink);
                    }
                } else {
                    @unlink($storageLink);
                }
            } elseif (is_dir($storageLink)) {
                // If it is a real directory, rename it as backup to prevent data loss
                $backup = public_path('storage_backup_' . time());
                if (@rename($storageLink, $backup)) {
                    $this->warn("Renamed physical public/storage directory to {$backup} to avoid data loss.");
                } else {
                    $this->error("Failed to rename physical public/storage directory.");
                    return 1;
                }
            }

            if (file_exists($storageLink) || is_link($storageLink)) {
                $this->error("Failed to remove the existing 'public/storage' link. If you are on Windows, you must run this command in a terminal with Administrator privileges.");
            }
        }

        // 4. Create relative symbolic link (highly recommended for cPanel/Apache)
        // From public/ to storage/app/public is ../storage/app/public
        $target = '../storage/app/public';
        if (PHP_OS_FAMILY === 'Windows') {
            // Windows symlinks usually require absolute paths to work correctly in standard environments
            $target = storage_path('app/public');
        }

        $this->info("Creating symbolic link: {$storageLink} -> {$target}");
        if (@symlink($target, $storageLink)) {
            $this->info('Relative symbolic link created successfully.');
        } else {
            $this->warn('Failed to create symlink using PHP symlink(). Attempting fallback with artisan storage:link...');
            $this->call('storage:link');
        }

        // 5. Ensure storage/app/public directories exist
        $signaturesDir = storage_path('app/public/signatures');
        if (!file_exists($signaturesDir)) {
            $this->info("Creating signatures directory at {$signaturesDir}...");
            @mkdir($signaturesDir, 0755, true);
        }
        $this->chmodRecursive($signaturesDir);

        $this->info('=== Storage and Cache permissions fix completed! ===');
        return 0;
    }

    /**
     * Recursively set directory and file permissions.
     */
    private function chmodRecursive(string $path, int $dirPermissions = 0755, int $filePermissions = 0644): void
    {
        if (!file_exists($path)) {
            return;
        }

        if (is_dir($path)) {
            @chmod($path, $dirPermissions);
            try {
                $items = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($items as $item) {
                    if ($item->isDir()) {
                        @chmod($item->getPathname(), $dirPermissions);
                    } else {
                        @chmod($item->getPathname(), $filePermissions);
                    }
                }
            } catch (\Exception $e) {
                // Suppress iterator exceptions in case some folders are not readable
                $this->line("Warning traversing directory: " . $e->getMessage(), 'v');
            }
        } else {
            @chmod($path, $filePermissions);
        }
    }
}
