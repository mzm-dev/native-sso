<?php

namespace Mzm\PhpSso\Helpers;

use Mzm\PhpSso\Enums\Cons;

class Logger
{
    protected static string $logDir = __DIR__ . Cons::LOG_DIR->value;
    protected static string $logFilePrefix = 'phpsso'; // Default log file prefix

    public function __construct()
    {
        // Pastikan log dir di set dengan betul berdasarkan lokasi
        self::setLogDirectory(self::$logDir);
    }

    /**
     * Log a message to a daily rotating file
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    public static function log(string $message, string $level = 'ERROR'): void
    {
        // Make sure log directory exists
        self::ensureLogDirectoryExists();

        // Build log file path with current date
        $dateToday = date('Y-m-d');
        $logFile = self::$logDir . '/' . self::$logFilePrefix . '-' . $dateToday . '.log';

        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[{$timestamp}] {$level}: {$message}" . PHP_EOL;

        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }

    /**
     * Ensure log directory exists, create if not
     */
    protected static function ensureLogDirectoryExists(): void
    {
        if (!is_dir(self::$logDir)) {
            // Attempt to create the log directory
            mkdir(self::$logDir, 0777, true); // 0777 allows full read, write, execute permission for all
        }
    }

    /**
     * Set custom log directory
     *
     * @param string $directory
     */
    public static function setLogDirectory(string $directory): void
    {
        // Set log directory dynamically to a relative path under 'gerak/sso'
        self::$logDir = $directory;
    }

    /**
     * Set custom log file prefix
     *
     * @param string $prefix
     */
    public static function setLogFilePrefix(string $prefix): void
    {
        self::$logFilePrefix = $prefix;
    }
}
