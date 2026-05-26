<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

if (empty($_SESSION['sathi_admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

// Ensure the autoloader from composer is included
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
} else {
    exit('Dependencies not installed. Run composer install.');
}

$format = $_GET['format'] ?? 'excel';

// Fetch all members
$rows = sathi_users_list_all(999999, 0, [], 'u.id ASC');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($format === 'excel') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Members');

    // Header row
    $headers = ['ID', 'Name', 'Email', 'Mobile', 'Gender', 'DOB', 'Education', 'Occupation', 'Income', 'Status', 'Join Date'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
        $col++;
    }

    $rowNum = 2;
    foreach ($rows as $r) {
        $sheet->setCellValue('A' . $rowNum, $r['id'] ?? '');
        $sheet->setCellValue('B' . $rowNum, $r['name'] ?? '');
        $sheet->setCellValue('C' . $rowNum, $r['email'] ?? '');
        $sheet->setCellValue('D' . $rowNum, $r['mobile'] ?? '');
        $sheet->setCellValue('E' . $rowNum, $r['gender'] ?? '');
        $sheet->setCellValue('F' . $rowNum, $r['dob'] ?? '');
        $sheet->setCellValue('G' . $rowNum, $r['education_val'] ?? '');
        $sheet->setCellValue('H' . $rowNum, $r['occupation_val'] ?? '');
        $sheet->setCellValue('I' . $rowNum, $r['annual_income'] ?? '');
        $sheet->setCellValue('J' . $rowNum, $r['status'] ?? '');
        $sheet->setCellValue('K' . $rowNum, $r['created_at'] ?? '');
        $rowNum++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="members_export_' . date('Ymd_His') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} elseif ($format === 'pdf') {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Members Export');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->AddPage('L'); // Landscape for more columns

    $html = '<h2>Members List</h2>';
    $html .= '<table border="1" cellpadding="4" cellspacing="0">';
    $html .= '<thead><tr style="background-color:#f2f2f2; font-weight:bold;">';
    $headers = ['ID', 'Name', 'Email', 'Mobile', 'Gender', 'Status'];
    foreach ($headers as $header) {
        $html .= '<th>' . $header . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $r) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars((string)($r['id'] ?? '')) . '</td>';
        $html .= '<td>' . htmlspecialchars((string)($r['name'] ?? '')) . '</td>';
        $html .= '<td>' . htmlspecialchars((string)($r['email'] ?? '')) . '</td>';
        $html .= '<td>' . htmlspecialchars((string)($r['mobile'] ?? '')) . '</td>';
        $html .= '<td>' . htmlspecialchars((string)($r['gender'] ?? '')) . '</td>';
        $html .= '<td>' . htmlspecialchars((string)($r['status'] ?? '')) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('members_export_' . date('Ymd_His') . '.pdf', 'D');
    exit;
}

echo "Invalid format requested.";
