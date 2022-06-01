<?php

namespace App\Src\Traits;

use Illuminate\Support\Facades\Schema;

trait Truncateable
{

   /**
     * Truncate the table
     *
     * @return void
     */
    public static function truncateModel()
    {
        Schema::disableForeignKeyConstraints();

        \DB::table((new static)->getTable())->truncate();
        
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Get the table associated with the model overide from laravel model.
     *
     * @return string
     */
    public function getTable()
    {
        return parent::getTable();
    }
    
}
