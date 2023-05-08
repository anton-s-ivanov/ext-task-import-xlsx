<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Row;

class DisplayRowsController extends Controller
{
    /**
     * Вывод данных таблицы rows.
     *
     * @return array $rowsGroupedByDate
     */

    public function index()
    {
       $rows = Row::all();
       $rowsGroupedByDate = $this->getRowsGroupedByDate($rows);

       return $rowsGroupedByDate;
    }

    /**
    * Формирование массива с группировкой по date.
    * 
    * @param array $rows
    * @return array $rowsGroupedByDate
    */

    public function getRowsGroupedByDate($rows)
    {
       $rowsGroupedByDate = [];

       foreach($rows as $row){
           $rowsGroupedByDate[$row['date']][] = $row;
       }

       return $rowsGroupedByDate;
    }
}
