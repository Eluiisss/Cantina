<?php

namespace App\Http\Controllers;

use App\Models\Nre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Util\SpecialUserCodeGenerator;
use Illuminate\Support\Facades\DB;

class NreController extends Controller
{
    use SpecialUserCodeGenerator;

    public function createSpecialUserCode(){
       
        $nre = Nre::factory()->create([
            'nre' => $this->generateSpecialUserCode(),
        ]);
         return redirect()->back()->with('key',$nre->nre);
    }

}
