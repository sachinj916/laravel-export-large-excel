<?php

namespace App\Http\Controllers;

use App\Jobs\ExportLargeExcel;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class LargeExcelController extends Controller
{
    public function exportLargeExcel()
    {
        $data_array = [];
        $i = 1;
        while ($i <= 50000) {
            $data_array[] = [$i, ($i + 4999)];
            $i = $i + 5000;
        }

        $loadData = [];
        foreach ($data_array as $val) {
            $loadData[] = new ExportLargeExcel($val[0], $val[1]);
        }

        $batch = Bus::batch($loadData)->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
        })->finally(function (Batch $batch) use ($data_array) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Csv');

            // If the files uses a delimiter other than a comma (e.g. a tab), then tell the reader
            // $reader->setDelimiter("\t");
            // If the files uses an encoding other than UTF-8 or ASCII, then tell the reader
            // $reader->setInputEncoding('UTF-16LE');

            $objPHPExcel = $reader->load(storage_path('excel_' . $batch->id . '.csv'));
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
            $objWriter->save(storage_path('excel1_' . $batch->id . '.Xlsx'));
        })->dispatch();
        \Log::info('export ended');
        return response()->json([
            'message' => 'Success',
            'data' => $batch->id,
            'state' => 200,
        ]);
    }

    public function downloadLargeExcel()
    {
        return response()->json([
            'message' => 'Success',
            'state' => 200,
        ]);
    }
}
