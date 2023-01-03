<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{

    public static function get_data_payment($vars = [], $mode)
    {
        // WHERE FC_BRANCH = 'COGRJG'
        $connection = DB::connection('sqlsrv');
        
        $offset = ($vars['rows'] - 1) * $vars['page'];
        $rows = $vars['rows'];
        $db = $connection->select("SELECT TOP (10) * FROM [d_master].[dbo].[t_dc]");

        if ($mode == 'total') {
            $result = count($db);
            return $result;
        } else if ($mode == 'rows') {
            $result = array();
            foreach ($db as $k => $v) {

                array_push($result, $v);
            }

            return $result;
        }
    }
}
