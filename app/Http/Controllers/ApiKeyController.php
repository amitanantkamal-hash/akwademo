<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApiKey $api_keys)
    {
        return view('user.api-keys', ['api_keys' => $api_keys->paginate(10)]);
    }
}
