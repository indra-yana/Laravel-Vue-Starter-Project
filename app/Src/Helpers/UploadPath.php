<?php

namespace App\Src\Helpers;

class UploadPath
{
	
    /**
     * Get the avatar upload path.
     * 
     * @param string $key
     * @return string
     */
	public static function avatar(string $key)
	{
		return "uploads/avatar/$key";
	}
    
    /**
     * Get the post upload path.
     * 
     * @param string $key
     * @return string
     */
	public static function post(string $key)
	{
		return "uploads/post/$key";
	}

}
