<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'f_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public static function get_data_user($vars = [], $mode)
    {
        $connection = DB::connection('sqlsrv');
        $q1 = 'SELECT a.*, ROW_NUMBER() OVER (ORDER BY a.f_id) AS num_rows FROM d_temporary.dbo.t_users_log AS a';
        $db = $connection->select("SELECT b.* FROM (".$q1.") AS b
                                    WHERE b.num_rows BETWEEN ".$vars['page']." AND ".$vars['rows']." 
                                    AND b.f_fullname LIKE '%".$vars['srcvt']."%'
                                    OR b.f_username LIKE '%".$vars['srcvt']."%'
                                    OR b.f_address LIKE '%".$vars['srcvt']."%'
                                ");

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
