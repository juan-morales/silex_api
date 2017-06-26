<?php

namespace App\Services;

class ExtraService extends BaseService
{

    //say hello
    public function index($name)
    {
        if (is_null($name)) 
        {
            return "Hello World";    
        } 
        else 
        {
            return "Hello " . $name;
        }
    }
    
		
}
