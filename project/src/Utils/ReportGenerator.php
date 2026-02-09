<?php

namespace App\Utils;

/**
 * @author fakedesyncc
 */
class ReportGenerator
{
    public static function generateCsv(array $data, array $headers, string $filename): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        if ($output === false) {
            throw new \RuntimeException('Failed to open output stream');
        }
        
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, $headers);
        
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }

    public static function generateExcel(array $data, array $headers, string $filename): void
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            throw new \RuntimeException('PhpSpreadsheet library is not installed. Run: composer require phpoffice/phpspreadsheet');
        }

        /** @var \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet */
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }
        
        $row = 2;
        foreach ($data as $item) {
            $col = 'A';
            foreach ($item as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        /** @var \PhpOffice\PhpSpreadsheet\Writer\Xlsx $writer */
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public static function generatePdf(array $data, array $headers, string $filename, string $title = 'Отчет'): void
    {
        if (!class_exists('TCPDF')) {
            throw new \RuntimeException('TCPDF library is not installed. Run: composer require tecnickcom/tcpdf');
        }

        if (!defined('PDF_PAGE_ORIENTATION')) {
            define('PDF_PAGE_ORIENTATION', 'P');
        }
        if (!defined('PDF_UNIT')) {
            define('PDF_UNIT', 'mm');
        }
        if (!defined('PDF_PAGE_FORMAT')) {
            define('PDF_PAGE_FORMAT', 'A4');
        }

        /** @var \TCPDF $pdf */
        $pdf = new \TCPDF(
            PDF_PAGE_ORIENTATION,
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );
        
        $pdf->SetCreator('Автосалон');
        $pdf->SetAuthor('fakedesyncc');
        $pdf->SetTitle($title);
        
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 12);
        
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        $pdf->Ln(5);
        
        $html = '<table border="1" cellpadding="5">';
        $html .= '<thead><tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars((string)$cell) . '</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output($filename, 'D');
        exit;
    }
}
