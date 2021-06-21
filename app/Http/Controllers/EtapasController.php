<?php

namespace App\Http\Controllers;

use App\Etapas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtapasController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('byTodayCheckRange');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            array(
                'status' => 200,
                'data' => Etapas::all(),
                'token' => auth()->refresh()
            )
        );
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
        $auth = auth()->refresh();
        $json = json_decode($request->json, JSON_FORCE_OBJECT);
        try {
            $json['inicio'] = Carbon::parse($json['inicio']);
            $json['final'] = Carbon::parse($json['final']);
            $json['created_at'] = Carbon::now();
            $json['updated_at'] = Carbon::now();
            $data = array(
                'status' => 201,
                'data' => Etapas::create($json),
                'token' => $auth
            );
        } catch (\Exception $ex) {
            $data = array(
                'status' => 403,
                'data' => $ex->getMessage(),
                'token' => $auth
            );
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Etapas  $etapa
     * @return \Illuminate\Http\Response
     */
    public function show(Etapas $etapa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Etapas  $etapa
     * @return \Illuminate\Http\Response
     */
    public function edit(Etapas $etapa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Etapas  $etapa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etapas $etapa)
    {
        $auth = auth()->refresh();
        $json = json_decode($request->json);
        try {
            $etapa->inicio = Carbon::parse($json->inicio);
            $etapa->final = Carbon::parse($json->final);
            $etapa->estado = $json->estado;
            $etapa->updated_at = Carbon::now();
            $data = array(
                'status' => 201,
                'data' => $etapa->save(),
                'token' => $auth
            );
        } catch (\Exception $ex) {
            $data = array(
                'status' => 403,
                'data' => $ex->getMessage(),
                'token' => $auth
            );
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Etapas  $etapa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etapas $etapa)
    {
        //
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function active()
    {
        return response()->json(
            array(
                'status' => 200,
                'data' => DB::table('etapas')->where('estado', 1)->get(),
                'token' => auth()->refresh()
            )
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeExToken()
    {
        return response()->json(
            array(
                'status' => 200,
                'data' => DB::table('etapas')->where('estado', 1)->get()
            )
        );
    }
}
