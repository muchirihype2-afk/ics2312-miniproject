<?php

declare(strict_types=1);

namespace App;

class ErrorHandler
{
    /**
     * Read and return the contents of a file while handling missing or unreadable files safely.
     *
     * @param string $filePath Absolute or relative path to the file to read.
     * @return string File contents.
     * @throws \RuntimeException If the file does not exist or is not readable.
     */
    public function safeReadFile(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File not found: $filePath");
        }

        if (!is_readable($filePath)) {
            throw new \RuntimeException("File is not readable: $filePath");
        }

        $contents = @file_get_contents($filePath);
        if ($contents === false) {
            throw new \RuntimeException("Failed to read file: $filePath");
        }

        return $contents;
    }

    /**
     * Write text content to a file while reporting unwritable destinations safely.
     *
     * @param string $filePath Absolute or relative path to the file to write.
     * @param string $content Content to be written to the file.
     * @return int Number of bytes written.
     * @throws \RuntimeException If the file cannot be written.
     */
    public function safeWriteFile(string $filePath, string $content): int
    {
        // Try to write the content; if the directory doesn't exist or permissions fail, file_put_contents returns false
        $bytes = @file_put_contents($filePath, $content);
        if ($bytes === false) {
            throw new \RuntimeException("Unable to write to file: $filePath");
        }

        return $bytes;
    }

    /**
     * Divide two numbers safely and reject division by zero.
     *
     * @param int|float $dividend Number being divided.
     * @param int|float $divisor Number to divide by.
     * @return float Result of the division.
     * @throws \RuntimeException If the divisor is zero.
     */
    public function safeDivide(int|float $dividend, int|float $divisor): float
    {
        if ($divisor === 0 || $divisor === 0.0) {
            throw new \RuntimeException("Division by zero: cannot divide $dividend by zero.");
        }

        return $dividend / $divisor;
    }
}
