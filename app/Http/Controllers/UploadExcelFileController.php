<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\XLSXFormat;
use App\Jobs\ParsingXLSX;
use Illuminate\Support\Facades\Redis;


class UploadExcelFileController extends Controller
{
    /**
     * Загрузить файл.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function uploadFile(Request $request)
    {
        //При объединении в одну проверку не срабатывает 'mimes:xlsx'
        $request->validate(['file' => ['mimes:xlsx', 'required']]); 
        $request->validate(['file' => new XLSXFormat]);

        $fileContentArr = fastexcel()->import($request->file);

        $progressKey = 'parsingProgress_'.auth()->user()->id;
        Redis::set($progressKey,  0);

        foreach (collect($fileContentArr)->chunk(1000) as $rowsArr) {
            ParsingXLSX::dispatch($rowsArr, $progressKey, auth()->user()->id);
        }
            
        $message = 'File '. $request->file->getClientOriginalName() . ' uploaded ('. count($fileContentArr) . ' elems)';
        return back()->with('success', $message) ;
    }
    
}
