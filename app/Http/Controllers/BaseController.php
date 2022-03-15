<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $model;
    protected $service;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            if(empty($id)){
                throw new Exception("Parâmetros inválidos para a função Destroy");
            }

            $ret = $this->model::destroy($id);
            if($ret === 0){
                throw new Exception("Id não encontrado");
            }

            return response()->json(['error' => false, 'message' => 'Informação deletado com sucesso'], 200);
        } catch (\Throwable $ex) {
            return response()->json(['error' => true, 'message' => $ex->getMessage()], 404);
        }
    }
}
