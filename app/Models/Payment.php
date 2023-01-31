<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{

    public static function get_data_payment($vars = [], $mode)
    {
        $connection = DB::connection('sqlsrv');
        
        $q1 = 'SELECT a.*, ROW_NUMBER() OVER (ORDER BY a.f_id) AS num_rows FROM d_temporary.dbo.t_users_log AS a';
        $db = $connection->select("SELECT b.* FROM (".$q1.") AS b WHERE b.num_rows BETWEEN ".$vars['page']." AND ".$vars['rows']." ");

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
