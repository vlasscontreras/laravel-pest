<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRepository;
use App\Http\Requests\UpdateRepository;
use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Repository::class, 'repository');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('repositories.index', [
            'repositories' => $request->user()->repositories()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repositories.create');
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
     * @param  Repository $repository
     * @return \Illuminate\Http\Response
     */
    public function show(Repository $repository)
    {
        return view('repositories.show', [
            'repository' => $repository,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Repository $repository
     * @return \Illuminate\Http\Response
     */
    public function edit(Repository $repository)
    {
        return view('repositories.edit', [
            'repository' => $repository,
        ]);
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
