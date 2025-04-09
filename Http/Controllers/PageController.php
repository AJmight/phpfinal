<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }
        abort(404);
    }
}
