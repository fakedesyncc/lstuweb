<?php

namespace App\Utils;

/**
 * @author fakedesyncc
 */
class CsvHandler
{
    public static function writeToCsv(string $filename, array $data, array $headers = []): bool
    {
        $file = fopen($filename, 'a');
        
        if ($file === false) {
            return false;
        }

        if (filesize($filename) === 0 && !empty($headers)) {
            fputcsv($file, $headers);
        }

        fputcsv($file, $data);
        fclose($file);
        
        return true;
    }

    public static function readFromCsv(string $filename): array
    {
        if (!file_exists($filename)) {
            return [];
        }

        $data = [];
        $file = fopen($filename, 'r');
        
        if ($file === false) {
            return [];
        }

        $headers = fgetcsv($file);
        
        if ($headers === false) {
            fclose($file);
            return [];
        }
        
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) === count($headers)) {
                $combined = array_combine($headers, $row);
                if ($combined !== false) {
                    $data[] = $combined;
                }
            }
        }
        
        fclose($file);
        
        return $data;
    }
}
