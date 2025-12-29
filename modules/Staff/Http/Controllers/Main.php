<?php

namespace Modules\Staff\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class Main extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('staff::index');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function roles()
    {
        return view('staff::roles');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function permissions()
    {
        return view('staff::permissions');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('staff::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('staff::show');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function role($id)
    {
        return view('staff::role');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function permission($id)
    {
        return view('staff::permission');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('staff::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
