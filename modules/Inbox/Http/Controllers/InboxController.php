<?php

namespace Modules\Inbox\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    public function index()
    {
        
        return view('inbox::index');
    }
}
