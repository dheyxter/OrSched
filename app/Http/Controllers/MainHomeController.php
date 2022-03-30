<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon;
use App\Model\patient;
use App\Model\toAccept;
use App\Http\Controllers\LoggedUser;
use App\Model\Reservation;

class MainHomeController extends Controller
{
    public function index(Request $request)
    {
       return view('homepage\master_index') ;
    }
}