<?php

namespace App\Http\Controllers;

use App\Models\Person;
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
        $user = Auth::user();
        $students = Person::all();

        return view('home', compact('user', 'students'));
    }
}
