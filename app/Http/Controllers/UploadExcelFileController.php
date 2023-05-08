<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

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
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $fileContentArr = fastexcel()->import($request->file);
        $formatedFileContentArr = $this->getFormatedFileContent($fileContentArr);

        if(!$formatedFileContentArr) {
            return back()->withErrors(['Wrong file data']);
        }

        DB::table('rows')->insert($formatedFileContentArr);

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
        if(!gettype($fileContentArr) == 'object') {
            return false;
        }

        $formatedFileContentArr = [];

        foreach($fileContentArr as $fileContentArrElem) {

            if(!$this->validateFileContentArrElem($fileContentArrElem)) {
                return false;
            }           

            $strArr['import_id'] = $fileContentArrElem['id'];
            $strArr['name'] = $fileContentArrElem['name'];
            $strArr['date'] =  date_format($fileContentArrElem['date'], 'Y-m-d');
            $strArr['created_at'] = now();
            $strArr['updated_at'] = now();

            $formatedFileContentArr[] =  $strArr;
        }

        return $formatedFileContentArr;
    }

    /**
     * Проверить входящие данные строки файла.
     *
     * @param  array $fileContentArrElem
     * @return bool
     */

    public function validateFileContentArrElem($fileContentArrElem)
    {
        if(
            !array_key_exists('id', $fileContentArrElem)
            || !array_key_exists('name', $fileContentArrElem)
            || !array_key_exists('date', $fileContentArrElem)
        ) {
            return false;
        }

        if(
            strlen($fileContentArrElem['id']) > 254
            || strlen($fileContentArrElem['name']) > 254
            || gettype($fileContentArrElem['date']) != 'object'
        ) {
            return false;
        }

        return true;
    }
}
