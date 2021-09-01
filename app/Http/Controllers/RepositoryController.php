<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRepository;
use App\Http\Requests\UpdateRepository;
use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRepository $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRepository $request)
    {
        $request->user()
            ->repositories()
            ->create($request->validated());

        return redirect()->route('repositories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRepository  $request
     * @param  Repository  $repository
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepository $request, Repository $repository)
    {
        $repository->update($request->validated());

        return redirect()->route('repositories.edit', [$repository]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Repository $repository
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repository $repository)
    {
        $repository->delete();

        return redirect()->route('repositories.index');
    }
}
