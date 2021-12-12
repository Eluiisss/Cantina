<?php


namespace App\Util;
use App\Models\Nre;
use Illuminate\Support\Str;



trait SpecialUserCodeGenerator
{
    public function generateSpecialUserCode()
    {
        $random = Str::random(7);
        while(Nre::where('nre', '=', $random)->count() > 0) {
            $random = Str::random(7);
        }
        return $random;
         
        
    }
   
}
