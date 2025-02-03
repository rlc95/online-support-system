<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Tickets;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['id','name','email','phone'];


    public static function customers()
    {
        
        $customers = DB::table('customers As a')
        ->selectRaw('a.id, a.name, a.email, a.phone, tickets.remrk AS ref, tickets.id AS tid, CONCAT(
                    IF(tickets.sts = 1, "resolved", 
                    IF(tickets.sts = 2, "pending", 
                    IF(tickets.sts = 0, "inactive", "unknown"))
                 )) AS sts, replies.id AS rid')
        ->leftJoin('tickets', 'a.id', '=', 'tickets.cui')  // Join clients with tickets
        ->leftJoin('replies', 'a.id', '=', 'replies.cui') 
        ->get();

        return $customers;
    }


    public static function customerData($cid)
    {
        
        $customers = DB::table('customers As a')
        ->selectRaw('a.id, a.name, a.email, a.phone, tickets.remrk AS ref')
        ->leftJoin('tickets', 'a.id', '=', 'tickets.cui')  // Join clients with tickets
        ->where('a.id',$cid)
        ->first();

        return $customers;

    }




    
}
