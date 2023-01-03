<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
       
    }

    public function data_payment()
    {
        $param['page'] = 1;
        $param['rows'] = 10;

        $result['total'] = Payment::get_data_payment($param, 'total');
        $result['rows'] = Payment::get_data_payment($param, 'rows');

        echo json_encode($result);
    }



}
