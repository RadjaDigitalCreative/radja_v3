<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Services\AttendanceService;
use App\Http\Controllers\Controller;
use App\Model\Student;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

/**
 * Class AttendanceController
 * @package App\Http\Controllers\Admin
 */
class AttendanceController extends Controller
{
    /**
     * @var AttendanceService
     */
    private $attendanceService;
    private $titlePage='Absensi Pegawai';
    private $titlePage2='Create Absensi Pegawai';

    /**
     * AttendanceController constructor.
     * @param AttendanceService $attendanceService
     */
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * @return Factory|RedirectResponse|View
     */
    public function index()
    {
        $params=[
            'title' => $this->titlePage
        ];
        $data = DB::table('students')
        ->leftJoin('attendances', function($join){
            $join->on('students.id', '=', 'attendances.student_id');
        })
        ->groupBy('first_name')
        ->select(array('attendances.*', 'students.*', DB::raw('COUNT(attendances.student_id) as total')))
        ->get();
        $pegawai = DB::table('users')
        ->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->groupBy('id_team')
        ->get();
        $selectedYear  = Route::current()->parameters()['year'];
        $selectedMonth = Route::current()->parameters()['month'];

        //don't let to navigate to future attendances
        if ($this->attendanceService->isProvidedMonthGreaterThanCurrentMonth($selectedYear, $selectedMonth)) {
            return redirect()->route('admin.attendances.redirect');
        }

        $daysInMonth     = $this->attendanceService->daysInMonth($selectedYear, $selectedMonth);
        $students        = Student::all();
        $attendances     = $this->attendanceService->getAttendances();
        $paginationLinks = $this->attendanceService->getAttendancePaginationLinks($selectedYear, $selectedMonth);


        $dataGaji = DB::table('gaji')
        ->select(DB::raw("
            COUNT(attendances.id) as total_kerja,
            students.first_name,
            gaji.created_at, 
            SUM(gaji.nominal_potongan) as gaji_kurang, 
            SUM(gaji.nominal_gaji) as gaji_total
            "))
        ->join('students', function($join){
            $join->on('gaji.pegawai_id', '=', 'students.id');
        })
        ->join('attendances', function($join){
            $join->on('gaji.pegawai_id', '=', 'attendances.student_id');
        })
        ->groupBy('attendances.student_id')
        ->get();
        return view('backend.admin.pegawai.index',$params, compact(
            'attendances', 'students', 'paginationLinks', 'daysInMonth', 'selectedYear', 'selectedMonth', 'role', 'bayar', 'data', 'link', 'pegawai' ,'dataGaji'
        ));
    }

    public function create(){
        $params=[
            'title' => $this->titlePage2
        ];
        $pegawai = DB::table('users')
        ->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->groupBy('id_team')
        ->get();
        return view('backend.admin.pegawai.create', $params ,compact('pegawai', 'role', 'bayar', 'link'));
    }
    public function store2(Request $request){
        $student = Student::create($request->all());
        return redirect()->route('attendances.index' ,['year' => now()->year, 'month' => now()->format('m')])->with('success', 'Data Berhasil Masuk.');;

    }
    /**
     * @return RedirectResponse
     */
    public function store()
    {
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $year  = request()->segment(3);
        $month = request()->segment(4);

        $attendances = array_filter(request()->all(), function ($key) {
            return strpos($key, 'student_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $this->attendanceService->storeAttendances($year, $month, $attendances);

        return redirect()->route('attendances.index', [
            'year'  => $year,
            'month' => $month,
        ])->with('success', 'Attendances updated successfully.');
    }

    public function createGaji(){
        $params=[
            'title' => $this->titlePage2
        ];
        $pegawai = DB::table('students')
        ->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->groupBy('id_team')
        ->get();
        return view('backend.admin.gaji.create', $params ,compact('pegawai', 'role', 'bayar', 'link'));
    }
    public function storeGaji(Request $request){

        $count  = count($request->jumlah);
        $count2  = count($request->jumlah2);
        for ($i=0; $i < $count; $i++) { 
            DB::table('gaji')
            ->insert([
                'pegawai_id'  => $request->pegawai_id,
                'komponen_gaji'  => $request->jumlah[$i],
                'nominal_gaji' => $request->harga[$i],
                'created_at' => now()
            ]);
        }
        for ($i=0; $i < $count2; $i++) { 
            DB::table('gaji')
            ->insert([
                'pegawai_id'  => $request->pegawai_id,
                'komponen_potongan'  => $request->jumlah2[$i],
                'nominal_potongan' => $request->harga2[$i],
                'created_at' => now()

            ]);
        }

        return redirect()->route('attendances.index' ,['year' => now()->year, 'month' => now()->format('m')])->with('success', 'Data Berhasil Masuk.');;

    }
}

function getBlokir()
{
    $kadaluarsa = 
    DB::table('loan')
    ->where('is_lent','==', 1)
    ->orWhere(function($q){
        $q->where('is_return','==', 0);
        $q->where('due_date','==', 'loan_date');
    })
    ->get();

    return response()->json(
        [
            "message" => "get blokir success",
            "data" => $kadaluarsa
        ]
    );
}

