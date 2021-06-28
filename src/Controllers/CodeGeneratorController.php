<?php

namespace CG\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class CodeGeneratorController
 * @package CG\Controllers
 */
class CodeGeneratorController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function index()
    {
        return view('CG::index');
    }

    /**
     * generate files
     * @param \Illuminate\Http\Request $request
     */
    public function generate(Request $request)
    {
        dump($request->all());die;
    }

}
