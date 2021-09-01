<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

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
        return view('welcome', [
            'repositories' => Repository::latest()->paginate(10),
        ]);
    }
}
