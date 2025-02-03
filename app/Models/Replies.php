<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Replies extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $fillable = ['id','tki','cui','msg'];

    public static function customers($cid,$ref)
    {
        
        $customers = DB::table('customers As a')
        ->selectRaw('a.id, a.name, a.email, a.phone, tickets.remrk AS ref, tickets.id AS tid, CONCAT(
                    IF(tickets.sts = 1, "resolved", 
                    IF(tickets.sts = 2, "pending", 
                    IF(tickets.sts = 0, "inactive", "unknown"))
                 )) AS sts, replies.id AS rid, replies.msg')
        ->leftJoin('tickets', 'a.id', '=', 'tickets.cui')  // Join clients with tickets
        ->leftJoin('replies', 'a.id', '=', 'replies.cui') 
        ->where('a.id',$cid)
        ->where('tickets.ref',$ref)
        ->first();

        return $customers;

        //return $this->hasMany(Tickets::class, 'cui', 'id'); 
    }


}
