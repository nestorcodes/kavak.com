<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Logic\Car as CarLogic;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    /**
     * Vista de Listado de Vehiculos
     * @return View
     */
    public function index()
    {
        return view('cars.index');
    }

    /**
     * Vista de Formulario de Creación de Vehiculos
     * @return View
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Vista de Detalles de Vehiculo
     * @return View
     */
    public function show(CarLogic $car)
    {
        return view('cars.show', [
            'car' => $car
        ]);
    }

    /**
     * Vista de Formulario de Edición de Vehiculo
     * @return View
     */
    public function edit(CarLogic $car)
    {
        return view('cars.edit', [
            'car' => $car
        ]);
    }

    /**
     * Listado de Vehiculos
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function DTLoad(Request $request)
    {
        $Query = CarLogic::getList();

        $page = (int) $request->input('pageNumber') - 1;
        $size = (int) $request->input('pageSize');


        $response = [
            'total_items' => count($Query->get()),
            'items' => $Query->skip($page * $size)->take($size)->get(),
        ];

        return Response()->json($response, 200);
    }

    /**
     * Guarda el vehiculo
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Car::create(request()->all());
        return redirect()->route('cars.index');
    }

    /**
     * Actualiza el vehiculo
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Car $car , Request $request)
    {
        $car->update($request->all());
        return redirect()->route('cars.show', $car);
    }

    /**
     * Elimina el vehiculo
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }
}
