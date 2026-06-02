<?php

declare(strict_types=1);

namespace App;

class FileHandler
{
    /**
     * Write a complete CSV file using the supplied associative record as the first row.
     *
     * @param string $filePath
     * @param array<string, scalar|null> $record
     * @return bool
     */
    public function writeRecord(string $filePath, array $record): bool
    {
        // Reject an empty record early
        if (empty($record)) {
            return false;
        }

        $handle = @fopen($filePath, 'w');
        if (!$handle) {
            return false;
        }

        // Write header row from the keys, preserving their order
        fputcsv($handle, array_keys($record));
        // Write the data row in the same column order
        fputcsv($handle, array_values($record));
        fclose($handle);

        return true;
    }

    /**
     * Read every row from a CSV file and return an array of associative arrays.
     *
     * @param string $filePath
     * @return array<int, array<string, string>>
     */
    public function readAllRecords(string $filePath): array
    {
        // File missing or unreadable → return empty array without warnings
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return [];
        }

        $handle = @fopen($filePath, 'r');
        if (!$handle) {
            return [];
        }

        $header = fgetcsv($handle);
        // Empty file (no header line) → return empty set
        if ($header === false) {
            fclose($handle);
            return [];
        }

        $records = [];
        while (($data = fgetcsv($handle)) !== false) {
            // Ignore empty lines (e.g., trailing newline)
            if (count($data) === 1 && $data[0] === null) {
                continue;
            }
            // Make data length match header length to avoid array_combine warnings
            $data = array_pad($data, count($header), '');
            $data = array_slice($data, 0, count($header));
            $records[] = array_combine($header, $data);
        }

        fclose($handle);
        return $records;
    }

    /**
     * Append one associative record to an existing CSV file, creating headers if needed.
     *
     * @param string $filePath
     * @param array<string, scalar|null> $record
     * @return bool
     */
    public function appendRecord(string $filePath, array $record): bool
    {
        if (empty($record)) {
            return false;
        }

        // Decide whether we need to write the header row first
        $fileExists = file_exists($filePath);
        $fileIsEmpty = $fileExists ? (filesize($filePath) === 0) : false;
        $writeHeader = !$fileExists || $fileIsEmpty;

        $handle = @fopen($filePath, 'a');
        if (!$handle) {
            return false;
        }

        // If the file is brand new or empty, start with the header row
        if ($writeHeader) {
            fputcsv($handle, array_keys($record));
        }

        // Append the data row (column order matches the header)
        fputcsv($handle, array_values($record));
        fclose($handle);

        return true;
    }
}
