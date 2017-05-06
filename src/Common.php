<?php
namespace Epoque\Chameleon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * Common
 *
 * A class that all Chameleon classes can extend.
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */

abstract class Common
{
    /** @var The log to use for logging warnings and errors. **/
    protected static $log = NULL;


    /**
     * URI
     *
     * @return string The current REQUEST_URI filtered and sanitized.
     */

    public static function URI()
    {
        return trim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');
    }


    /**
     * initLog
     *
     * Sets up the self::$log variable.
     */

    protected static function initLog()
    {
        if (self::$log === NULL) {
            self::$log = new Logger('chameleon.log');
            self::$log->pushHandler(new StreamHandler(LOG_FILE, Logger::WARNING));
        }
    }


    /**
     * logWarning
     *
     * Logs a warning message to self::$log.
     *
     * @param string $message The message to log.
     */

    protected static function logWarning($message='')
    {
        self::initLog();
        self::$log->warn($message);
    }


    /**
     * logError
     *
     * Logs an error message to self::$log.
     *
     * @param string $message The message to log.
     */

    protected static function logError($message='')
    {
        self::initLog();
        self::$log->err($message);
    }
}
