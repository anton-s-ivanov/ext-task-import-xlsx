<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class XLSXFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fileContentArr = fastexcel()->import($value);
        $formatedFileContentArr = $this->validateFileContentArr($fileContentArr);
    
        if(!$formatedFileContentArr) {
            $fail('Wrong file data.');
        }
    }

    /**
     * Проверить формат данных файла.
     *
     * @param  object $fileContentArr
     * @return bool
     */

    public function validateFileContentArr($fileContentArr) 
    {
        if(!gettype($fileContentArr) == 'object') {
            return false;
        }

        foreach($fileContentArr as $fileRow) {

            if(!$this->validateFileRow($fileRow)) {
                return false;
            }   
        }

        return true;
    }
    
    
    /**
     * Проверка данных строки файла.
     *
     * @param  array $fileContentArrElem
     * @return bool
     */

    public function validateFileRow($fileRow)
    {
        if(
            !array_key_exists('id', $fileRow)
            || !array_key_exists('name', $fileRow)
            || !array_key_exists('date', $fileRow)
        ) {
            return false;
        }

        if(
            strlen($fileRow['id']) > 254
            || strlen($fileRow['name']) > 254
            || gettype($fileRow['date']) != 'object'
        ) {
            return false;
        }

        if(get_class($fileRow['date']) != 'DateTimeImmutable') {
            return false;
        }

        return true;
    }
    
    
}
