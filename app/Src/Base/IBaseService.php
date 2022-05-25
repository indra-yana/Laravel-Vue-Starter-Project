<?php

namespace App\Src\Base;

interface IBaseService
{
    /**
     * Get the model or data result as defined.
     *
     * @return array
     */
    public function formatResult($model);
    
    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance();

}
