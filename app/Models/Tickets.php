<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Replies;

class Tickets extends Model
{
   
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = ['id','cui','remrk','ref','sts'];

    public static function stschck($ref)
    {
        
        $customers = Tickets::selectRaw('ref, cui')->where(['ref' => $ref])->first();
        return $customers;

    }


}
