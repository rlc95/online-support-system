<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Customer; 
use App\Models\Replies; 
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErrorCodeException;

class SupportAgentController extends Controller
{
    
    public function userView(Request $request){ 

        $customers = Customer::customers();

        // Return data to view or pass it to the API response
        return view('supprt_agent.tickets-control', compact('customers'));
    }


    public function dashboard(Request $request)
    {
        $customers = Customer::customers();

        session(['usid' => Auth::user()->id]);
        date_default_timezone_set('Asia/Colombo');
        return view('dashboard', compact('customers'));
    }


    public function replyStore(Request $req){   
        $validated = $req->validate([
            'reply' => 'required',
        ]);

        $db = new Replies();

        $db->tki = $req->tikid;
        $db->cui = $req->cusid;
        $db->msg = $req->reply;

        if (!$db->save()) {
            throw new ErrorCodeException('Create replies');
        }

        $db1 = Tickets::find($db->tki);
        $db1->sts = "1";

        if (!$db1->save()) {
            throw new ErrorCodeException('Create replies');
        }


        return response()->json([
            'status' => 'success',
        ]);


    }


}
