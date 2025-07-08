<?php

namespace Sportmaster\Api\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Stringable;

/**
 * File-based logger implementation using Monolog.
 */
class FileLogger implements LoggerInterface
{
    private Logger $logger;

    /**
     * FileLogger constructor.
     *
     * @param string $logFile Path to the log file (default: 'sportmaster_api.log').
     * @throws \Exception If the log file cannot be created.
     */
    public function __construct(string $logFile = 'sportmaster_api.log')
    {
        $this->logger = new Logger('sportmaster_api');
        $this->logger->pushHandler(new StreamHandler($logFile, Logger::INFO));
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level The log level.
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }

    /**
     * Logs an emergency message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->logger->emergency($message, $context);
    }

    /**
     * Logs an alert message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->logger->alert($message, $context);
    }

    /**
     * Logs a critical message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }

    /**
     * Logs an error message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function error(string|Stringable $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    /**
     * Logs a warning message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    /**
     * Logs a notice message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    /**
     * Logs an info message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function info(string|Stringable $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * Logs a debug message.
     *
     * @param string|\Stringable $message The log message.
     * @param array $context Additional context.
     */
    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }
}