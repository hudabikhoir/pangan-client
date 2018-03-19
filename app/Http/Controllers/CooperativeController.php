<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CooperativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $content = DB::table('warehouse')
                ->join('comodities', 'warehouse.id_comodities', '=', 'comodities.id')
                ->leftJoin('cooperative', 'warehouse.id_comodities', '=', 'cooperative.id_comodities')
                ->select(DB::raw('sum(warehouse.stock) as stock'), 'comodities.name', 'cooperative.price', 'cooperative.id','comodities.id AS id_comodities')
                ->groupBy('warehouse.id_comodities','cooperative.price','cooperative.id')
                ->get();
        // dd($content);
        return view('admin.cooperative',['content' => $content]);
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
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $data = DB::table('cooperative')
                ->insert($input);
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
        $content = DB::table('warehouse')
                ->join('comodities', 'warehouse.id_comodities', '=', 'comodities.id')
                ->leftJoin('cooperative', 'warehouse.id_comodities', '=', 'cooperative.id_comodities')
                ->select(DB::raw('sum(warehouse.stock) as stock'), 'comodities.name', 'cooperative.price', 'cooperative.id','comodities.id AS id_comodities')
                ->where('comodities.id', $id)
                ->groupBy('warehouse.id_comodities','cooperative.price','cooperative.id')
                ->get();
        // dd($content->toJson());
        return $content->toJson();
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
        $user = DB::table('cooperative')
                ->where('id', $request->id)
                ->update([
                    'id_comodities' => $request->id_comodities,
                    'price' => $request->price
                ]);
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
}
