<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class PageController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function home(): View | Factory
    {
        return view('home.index', [
            'repositories' => Repository::latest()->get(),
        ]);
    }

    /**
     * Show the repository page.
     *
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function repository(Repository $repository): View | Factory
    {
        return view('home.repository', [
            'repository' => $repository,
        ]);
    }
}
