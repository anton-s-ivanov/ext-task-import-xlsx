<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Illuminate\Support\Facades\DB;
use App\Models\Row;

class ParsingXLSX implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rowsArr;

    /**
     * Create a new job instance.
     */
    public function __construct($rowsArr)
    {
        $this->rowsArr = $rowsArr;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->rowsArr as $row) {
            $createdRow = Row::create([
                'import_id' => $row['id'],
                'name' => $row['name'],
                'date' => date_format($row['date'], 'Y-m-d'),
            ]);
        }
    }
}
