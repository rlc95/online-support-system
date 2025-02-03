<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
//Models
use App\Models\Customer; 
use App\Models\Tickets;  
use App\Models\Replies;
use Exception;
use App\Mail\CustomerEmail;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function userHome(Request $request){ 
        return view('frontpage');
    }

    
    public function custmrsts(Request $req){

        $validated = $req->validate([
            'refrnc' => 'required',
        ]);

        
        $customers = Tickets::stschck($req->refrnc);

        if ($customers) {
            return response()->json([
                'status' => 'success',
                'ref' => $customers->ref,
                'cuid' => $customers->cui,
            ]);
        }else{
            return response()->json([
                'status' => 'fail',
                'ref' => '',
                'cuid' => '',
            ]);
        }


    }

    public function userStore(Request $req){

    try{
        
        $validated = $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'remrk' => 'required',
            'mobile' => 'required|numeric',
        ]);


    $db = new Customer();

    $db->name = $req->name;
    $db->email = $req->email;
    $db->phone = $req->mobile;

    if (!$db->save()) {
        throw new ErrorCodeException('Create customers');
    }

    $cusId = $db->id;

    $referenceNumber = Str::random(10);
    $refNum = 'TICKET-' . strtoupper($referenceNumber);

    $db2 = new Tickets();

    $db2->cui = $cusId;
    $db2->remrk = $req->remrk;
    $db2->ref = $refNum;
    $db2->sts = '2';   // pending

    if (!$db2->save()) {
        throw new ErrorCodeException('Create tickets');
    }


        
    $customer = Customer::customerData($cusId);

    /*

    if ($customer) {
        // Send the email
        Mail::to($customer->email)->send(new CustomerEmail($customer));

        $message = 'Email sent successfully';
    }else{
        $message = 'Email sent unsuccessfully! Customer not found';
    }*/

    $to = $customer->email;
     // *** Subject Email ***
    $subject = "Reference Number for Online Support";
    // *** Content Email ***
    $content = "Hellow, Ref No: ".$customer->ref." Thank you for reaching out to support. Your ticket has been created successfully. Our team will get back to you shortly.</p>
    <p>If you need immediate assistance, please reply to this email.";
    //*** Head Email ***
    $headers = "From: ranganalak@gmail.com\r\n";
     //*** Show the result... ***
    if (mail($to, $subject, $content, $headers))
    {
        $message = 'Email sent successfully';
    }else{
        $message = 'Email sent unsuccessfully! Customer not found';
    }

        return response()->json([
            'status' => 'success',
            'ref' => $refNum,
            'cuid' => $cusId,
            'msg'=>$message
        ]);


    }catch(Exception $e){
        dd($e);
        return response()->json([
            'status' => 'Unsuccess',
            'ref' => '',
            'cuid' => '',
            'msg'=>''
        ]);
    }

    }


    public function dashboard(Request $request)
    {
        // Retrieve the parameters from the URL
        $refNum = $request->query('ref');
        $cusId = $request->query('cuid');

        $customers = Replies::customers($cusId,$refNum);
        // Optionally, you can do additional logic with these variables, such as fetching customer/ticket info

        // Return the view, passing the parameters to it
        return view('customer.support_ticket_open', compact('customers'));
    }














}
