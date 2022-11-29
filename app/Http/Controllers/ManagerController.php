<?php

namespace App\Http\Controllers;

use App\Models\Dtrans;
use App\Models\Htrans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ManagerController extends Controller
{
    //composer require barryvdh/laravel-dompdf
    public function dashboard()
    {
        $profit = DB::select("select SUM(h.total) as total from transactions t, htrans h where year(t.created_at) = year(CURRENT_DATE) and month(t.created_at) = month(CURRENT_DATE) and day(t.created_at) = day(CURRENT_DATE) and t.id = h.transaction_id");
        $date = DB::select("select CURRENT_DATE as date");
        // dd();
        return view("manager.dashboard",["profit" => $profit[0]->total,"date" => $date[0]->date]);
    }

    public function generate($awal,$akhir)
    {
        if ($awal == "no" || $akhir == "no") {
            $cek = DB::select('select h.id as id, u.name as nama_user, m.judul as movie_title, s.nama as studio, b.nama as branch, h.total from htrans h, users u, schedules sch, movies m, studios s, branches b where h.user_id = u.id and h.schedule_id = sch.id and sch.movie_id = m.id and sch.studio_id = s.id and sch.branch_id = b.id', []);
            $tipe = "Data semua transaksi";
    
            $jumlah = DB::select('SELECT SUM(htrans.total) as total FROM htrans',[]);
        }else{
            $cek = DB::select('select h.id as id, u.name as nama_user, m.judul as movie_title, s.nama as studio, b.nama as branch, h.total from htrans h, users u, schedules sch, movies m, studios s, branches b where h.user_id = u.id and h.schedule_id = sch.id and sch.movie_id = m.id and sch.studio_id = s.id and sch.branch_id = b.id and h.created_at BETWEEN ? and ?', [$awal,$akhir]);
            $tipe = "Data yang ditampilkan adalah transaksi yang terjadi pada tanggal ".$awal." s/d ".$akhir;
    
            $jumlah = DB::select('SELECT SUM(htrans.total) as total FROM htrans WHERE (htrans.created_at) between ? and ?',[$awal,$akhir]);
        }
        $script = '<h3>'.$tipe.'</h3><br><table class="table table-sm" border="1px">
        <thead>
            <tr class="fw-bold">
                <td>
                    ID Transaksi
                </td>
                <td>
                    Nama user
                </td>
                <td>
                    Judul film
                </td>
                <td>
                    Studio
                </td>
                <td>
                    Lokasi
                </td>
                <td>
                    Total transaksi
                </td>
            </tr>
        </thead>
        <tbody>';
        for ($i=0; $i < count($cek); $i++) { 
            $script = $script . '<tr height="70px" class="align-middle"><td>';
            $script = $script . $cek[$i]->id . '</td>';
            $script = $script .'<td>'. $cek[$i]->nama_user . '</td>';
            $script = $script .'<td>'. $cek[$i]->movie_title . '</td>';
            $script = $script .'<td>'. $cek[$i]->studio . '</td>';
            $script = $script .'<td>'. $cek[$i]->branch . '</td>';
            $script = $script .'<td> Rp. '. $cek[$i]->total . '</td></tr>';
        }
        $script = $script . '</tbody></table><br>';
        $script = $script . '<h3>Total semua Transaksi : Rp. '.$jumlah[0]->total.'</h3>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($script);
        return $pdf->stream();
    }

    public function cekReport(Request $request){

        $htrans = DB::select('
            select
                MONTHNAME(date_range.mm) as month_name,
                COUNT(id) as count
            from
                (
                    select (NOW() - INTERVAL counter.m MONTH) as mm
                    from
                        (
                            select @rownum := @rownum + 1 as m from
                            (select 1 union select 2 union select 3 union select 4) t1,
                            (select 1 union select 2 union select 3) t2,
                            (select @rownum := -1) t0
                        ) counter
                ) date_range    
            left join
                htrans ht
            on
                MONTH(ht.created_at) = MONTH(date_range.mm)
            group by 
                MONTH(date_range.mm), date_range.mm
            order by
                date_range.mm
        ');
        $labels = array_map(function($item) {
            return $item->month_name;
        }, $htrans);
        $data = array_map(function($item) {
            return $item->count;
        }, $htrans);

        $awal = $request->input("start") ?? "";
        $akhir = $request->input("end") ?? "";

        $awal = $awal . " 00:00:00";
        $akhir = $akhir . " 23:59:59";

        $cek = DB::select('select h.id as id, u.name as nama_user, m.judul as movie_title, s.nama as studio, b.nama as branch, h.total from htrans h, users u, schedules sch, movies m, studios s, branches b where h.user_id = u.id and h.schedule_id = sch.id and sch.movie_id = m.id and sch.studio_id = s.id and sch.branch_id = b.id and h.created_at BETWEEN ? and ?', [$awal,$akhir]);
        $tipe = "Data yang ditampilkan adalah transaksi yang terjadi pada tanggal ".$awal." s/d ".$akhir;

        $jumlah = DB::select('SELECT SUM(htrans.total) as total FROM htrans WHERE (htrans.created_at) between ? and ?',[$awal,$akhir]);
        // dd($cek);
        // dd($jumlah);
        return view('manager.laporan',[
            'awal' => $awal,
            'akhir' => $akhir,
            'report'=>$cek,
            'tipe' => $tipe,
            'jumlah' => $jumlah[0]->total,
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function laporan()
    {        
        $htrans = DB::select('
            select
                MONTHNAME(date_range.mm) as month_name,
                COUNT(id) as count
            from
                (
                    select (NOW() - INTERVAL counter.m MONTH) as mm
                    from
                        (
                            select @rownum := @rownum + 1 as m from
                            (select 1 union select 2 union select 3 union select 4) t1,
                            (select 1 union select 2 union select 3) t2,
                            (select @rownum := -1) t0
                        ) counter
                ) date_range    
            left join
                htrans ht
            on
                MONTH(ht.created_at) = MONTH(date_range.mm)
            group by 
                MONTH(date_range.mm), date_range.mm
            order by
                date_range.mm
        ');
        $labels = array_map(function($item) {
            return $item->month_name;
        }, $htrans);
        $data = array_map(function($item) {
            return $item->count;
        }, $htrans);
        
        $cek = DB::select('select h.id as id, u.name as nama_user, m.judul as movie_title, s.nama as studio, b.nama as branch, h.total from htrans h, users u, schedules sch, movies m, studios s, branches b where h.user_id = u.id and h.schedule_id = sch.id and sch.movie_id = m.id and sch.studio_id = s.id and sch.branch_id = b.id', []);
        $tipe = "";

        $jumlah = DB::select('SELECT SUM(htrans.total) as total FROM htrans');

        return view('manager.laporan',[
            'awal' => "no",
            'akhir' => "no",
            'report'=>$cek,
            'tipe' => $tipe,
            'jumlah' => $jumlah[0]->total,
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function laporanBulanan()
    {        
        $htrans = DB::select('
        select Date(date_range.dd) as date, COUNT(id) as count from ( select (NOW() - INTERVAL counter.d DAY) as dd from ( select @rownum := @rownum + 1 as d from (select 1 union select 2 union select 3 union select 4 union select 5) t1, (select 1 union select 2 union select 3) t2, (select 1 union select 2) t3, (select @rownum := -1) t0 ) counter ) date_range left join htrans ht on DAY(ht.created_at) = DAY(date_range.dd) group by DAY(date_range.dd), date_range.dd order by date_range.dd
        ');
        $labels = array_map(function($item) {
            return $item->date;
        }, $htrans);
        $data = array_map(function($item) {
            return $item->count;
        }, $htrans);
        
        return view('manager.laporan2',[
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function bar()
    {
        $bar = DB::select('select m.id, count(sch.movie_id) as count FROM htrans h join schedules sch on h.schedule_id = sch.id right join movies m on m.id = sch.movie_id GROUP by m.id',[]); 
        $semua = DB::select('select judul from movies order by id asc');
        $total = DB::select('select count(sch.movie_id) as count FROM htrans h join schedules sch on h.schedule_id = sch.id right join movies m on m.id = sch.movie_id');

        $semua = array_map(function($item) {
            return $item->judul;
        }, $semua);
        $bar = array_map(function($item) {
            return $item->count;
        }, $bar);
        return view('manager.bar',[
            'bar' => $bar,
            'semua' => $semua,
            'total' => $total[0]->count 
        ]);
    }

    public function barHari()
    {
        $bar = DB::select('select dayname(created_at) as hari,count(dayname(created_at)) as jumlah_pembeli from htrans GROUP by dayname(created_at) order by DAYOFWEEK(created_at)',[]);  
        $bar = array_map(function($item) {
            return $item->jumlah_pembeli;
        }, $bar);
        return view('manager.barHari',[
            'bar' => $bar
        ]);
    }

    public function index(){
        $profit = DB::select("select SUM(h.total) as total from transactions t, htrans h where year(t.created_at) = year(CURRENT_DATE) and month(t.created_at) = month(CURRENT_DATE) and day(t.created_at) = day(CURRENT_DATE) and t.id = h.transaction_id");
        $date = DB::select("select CURRENT_DATE as date");
        $profit =  $profit[0]->total;
        if ($profit == null) {
            $profit = 0;
        }
        return view('manager.manager',["profit" => $profit,"date" => $date[0]->date]);
    }

    public function addAdmin(){
        $admins = DB::select("SELECT * FROM users WHERE role=2");
        return view('manager.master-admin',["admins" => $admins]);
    }

    public function formAdmin(){
        return view('manager.add-admin');
    }

    public function verifyregister(Request $r){
        $credentials = $r->validate([
            'name'=>'required|max:255',
            'email'=>'required|email:dns|unique:users,email',
            'password'=>'required|min:5|max:255',
            'confirm_password'=>'required|same:password'
        ]);
        $credentials["password"] = Hash::make($credentials["password"]);
        $usr = new User();
        $usr->name = $credentials["name"];
        $usr->email = $credentials["email"];
        $usr->password = $credentials["password"];
        $usr->role = 2;
        $usr->save();

        $admins = DB::select("SELECT * FROM users WHERE role=2");
        return view('manager.master-admin',["admins" => $admins]);
    }
}
