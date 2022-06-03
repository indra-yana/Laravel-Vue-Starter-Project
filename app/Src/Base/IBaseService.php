<?php

namespace App\Src\Base;

interface IBaseService
{
    /**
     * Get the result data of model.
     *
     * @param object $model
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
