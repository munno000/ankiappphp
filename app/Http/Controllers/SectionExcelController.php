<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Word;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SectionExcelController extends Controller
{
    public function export(int $sectionId)
    {
        $section = Section::with(['book', 'words'])->findOrFail($sectionId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($section->name);

        // ヘッダー
        $sheet->setCellValue('A1', 'English');
        $sheet->setCellValue('B1', 'Japanese');

        // ヘッダースタイル
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '89C9F0']],
        ];
        $sheet->getStyle('A1:B1')->applyFromArray($headerStyle);
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);

        // データ
        $row = 2;
        foreach ($section->words as $word) {
            $sheet->setCellValue("A{$row}", $word->english);
            $sheet->setCellValue("B{$row}", $word->japanese);
            $row++;
        }

        $filename = $section->book->name . '_' . $section->name . '.xlsx';
        $filename = preg_replace('/[\/\\\\:*?"<>|]/', '_', $filename);

        $writer = new Xlsx($spreadsheet);
        $temp = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($temp);

        return response()->download($temp, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function import(Request $request, int $sectionId)
    {
        $section = Section::findOrFail($sectionId);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // 1行目はヘッダーとしてスキップ
        $imported = 0;
        $skipped  = 0;
        foreach (array_slice($rows, 1) as $row) {
            $english  = trim((string) ($row[0] ?? ''));
            $japanese = trim((string) ($row[1] ?? ''));

            if ($english === '' || $japanese === '') {
                $skipped++;
                continue;
            }

            Word::firstOrCreate(
                ['english' => $english, 'section_id' => $sectionId],
                ['japanese' => $japanese]
            );
            $imported++;
        }

        $message = "{$imported}件インポートしました";
        if ($skipped > 0) {
            $message .= "（{$skipped}件スキップ）";
        }

        return redirect(url("/books/{$section->book_id}/sections"))
            ->with('success', $message);
    }
}
