<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $comodities = DB::table('cooperative')
                    ->join('comodities', 'cooperative.id_comodities', '=', 'comodities.id')
                    ->select('cooperative.*', 'comodities.name AS comodities')
                    ->get();
        $content = DB::table('carts')
                    ->join('cooperative', 'carts.id_product', '=', 'cooperative.id')
                    ->join('comodities', 'cooperative.id_comodities', '=', 'comodities.id')
                    ->select('carts.*', 'comodities.name AS comodities', 'cooperative.price')
                    ->where('id_user', Auth::user()->id)
                    ->get();
        // dd($content);
        return view('admin.cart',['content' => $content, 'comodities' => $comodities]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $input = $request->except('_token');
        $data = DB::table('carts')
                ->insert([
                    'id_user' => Auth::user()->id,
                    'id_product' => $request->id_comodities,
                    'amount' => $request->amount
                ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getHarga($id){
        $comodities = DB::table('cooperative')
                        ->where('id_comodities', $id)
                        ->get()
                        ->toJson();
        return($comodities);
    }
}
