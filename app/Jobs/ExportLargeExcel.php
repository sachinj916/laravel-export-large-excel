<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportLargeExcel implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $start;
    private int $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $batchId = $this->batch()->id;
        $fileName = 'excel_' . $batchId . '.csv';
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        // store array in file for later use
        $array = [];
        for ($i = $this->start; $i <= $this->end; $i++) {
            $array[] = [
                'name' => 'Test ' . $i,
                'job' => 'software engineer ' . $i,
                'column3' => 'column3 ' . $i,
                'column4' => 'column4 ' . $i,
                'column5' => 'column5 ' . $i,
                'column6' => 'column6 ' . $i,
                'column7' => 'column7 ' . $i,
                'column8' => 'column8 ' . $i,
                'column9' => 'column9 ' . $i,
                'column10' => 'column10 ' . $i,
                'column11' => 'column11 ' . $i,
                'column12' => 'column12 ' . $i,
            ];
        }

        if ($array) {
            $fileName1 = storage_path($fileName);
            $file = fopen($fileName1, 'a');

            foreach ($array as $fields) {
                fputcsv($file, $fields);
            }
            fclose($file);
        }
        return;
    }
}
