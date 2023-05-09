<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use App\Rules\XLSXFormat;

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
        $request->validate([
            'file' => ['mimes:xlsx', 'required'],
        ]);   
        $request->validate([
            'file' => new XLSXFormat
        ]);

        $fileContentArr = fastexcel()->import($request->file);
        $formatedFileContentArr = $this->getFormatedFileContent($fileContentArr);

        // DB::table('rows')->insert($formatedFileContentArr);

        $message = 'File '. $request->file->getClientOriginalName() . ' uploaded ('. count($formatedFileContentArr) . ' elems)';
        return back()->with('success', $message) ;
    }
    
    /**
     * Сформировать массив для сохранения в БД.
     *
     * @param  object $fileContentArr
     * @return array $formatedFileContentArr
     */

    public function getFormatedFileContent($fileContentArr) 
    {
        $formatedFileContentArr = [];

        foreach($fileContentArr as $fileContentArrElem) {

            $strArr['import_id'] = $fileContentArrElem['id'];
            $strArr['name'] = $fileContentArrElem['name'];
            $strArr['date'] =  date_format($fileContentArrElem['date'], 'Y-m-d');
            $strArr['created_at'] = now();
            $strArr['updated_at'] = now();

            $formatedFileContentArr[] =  $strArr;
        }

        return $formatedFileContentArr;
    }

}
