<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private function getDate()
    {
        return Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'));
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_professors = User::where('rol_id', 3)->with('Person')->get();
        $professors = [];
        foreach ($all_professors as $prof) {
            $cant_pps = Application::where('teacher_id', $prof->Person->id)->where('is_finished', false)->count();
            if ($cant_pps <= 10) {
                $professors[] = $prof;
            }
        }

        return view('home', compact('professors'));
    }
}
