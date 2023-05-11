<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;


class ParsingXLSX implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * Data array.
     *
     * @var array $rowsArr
     */
    protected $rowsArr;

    /**
     * Redis progress key.
     *
     * @var string $progressKey
     */
    protected $progressKey;

    /**
     * User id.
     *
     * @var int $userID
     */
    protected $userID;


    /**
     * Create a new job instance.
     */
    public function __construct($rowsArr, $progressKey, $userID)
    {
        $this->rowsArr = $rowsArr;
        $this->progressKey = $progressKey;
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // можно сделать вставку всего чанка через insert (подготовив массив).
        // будет быстрее, но точность учета прогресса будет кратна размеру чанка.
        
        foreach($this->rowsArr as $row) {
            $createdRow = Row::create([
                'import_id' => $row['id'],
                'name' => $row['name'],
                'date' => date_format($row['date'], 'Y-m-d'),
            ]);

            Redis::incr($this->progressKey);
            event(new \App\Events\DbRowsAddedEvent(Redis::get($this->progressKey), $this->userID));
        }
        
    }
}
