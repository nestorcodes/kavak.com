<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Logic\Maintenance\Maintenance;
use App\Models\CarModel;
use App\Models\CarBrand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('maintenance.model', [
            'brands' => CarBrand::orderBy('name', 'asc')->get(),
        ]);
    }

    public function load(Request $request)
    {
        $Logic = new Maintenance(new CarModel);
        $Query = $Logic->Query();

        return DataTables::of($Query)
            ->make(true);
    }

    public function get(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'code' => ['required', 'integer', 'min:1'],
        ], [
            'code.required' => 'El identificador de la modelo es requerido',
            'code.integer'  => 'El identificador de la modelo es un numero entero',
            'code.min:1'    => 'El identificador de la modelo es invalido',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarModel());

            $Logic->get($request->input('code'));

            $model = $Logic->returnModel();

            if (isset($model->id)) {
                return Response()->json(['d' => $model], 200);
            }

            return Response()->json(['m' => 'No existe ninguna modelo con ese identificador'], 422);
        }

        return Response()->json(['errors' => $Validator->errors()], 422);
    }

    public function create(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'brand' => ['required', 'integer']
        ], [
            'name.required' => 'El Nombre del modelo es requerido',
            'brand.required' => 'La Marca es requerida',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarModel());

            $formData = $Logic->parseForm($request->all());

            $Logic->validate($formData);

            if (!$Logic->hasErrors()) {
                $Logic->create($formData);

                return Response()->json(['m' => 'Se ha creado el modelo correctamente'], 200);
            }

            return Response()->json(['errors' => $Logic->getErrors()], 422);
        }

        return Response()->json(['errors' => $Validator->errors()], 422);
    }

    public function update(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'code' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string'],
            'brand' => ['required', 'integer'],
        ], [
            'code.required' => 'El identificador del modelo es requerido',
            'code.integer'  => 'El identificador del modelo es un entero',
            'code.min:1'    => 'El identificador del modelo no es valido',
            'name.required' => 'El nombre del modelo es requerido',
            'name.string'   => 'El nombre del modelo es una cadena de texto',
            'brand.required' => 'La marca es requerida',
            'brand.integer'  => 'La marca es invalida'
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarModel());

            $Logic->get($request->input('code'));

            $formData = $Logic->parseForm($request->all());
            $Logic->validate($formData);

            if (!$Logic->hasErrors()) {
                $Logic->update($formData);

                return Response()->json(['m' => 'Se ha actualizado el modelo correctamente'], 200);
            }

            return Response()->json(['erros' => $Logic->getErrors()], 422);
        }

        return Response()->json(['errors' => $Validator->errors()], 422);
    }

    public function delete(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'code' => ['required', 'integer', 'min:1'],
        ], [
            'code.required' => 'El identificador de la modelo es requerido',
            'code.integer'  => 'El identificador de la modelo es un numero entero',
            'code.min:1'    => 'El identificador de la modelo es invalido',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarModel());

            $Logic->get($request->input('code'));

            $Logic->delete();

            if ($Logic->hasErrors()) {
                return Response()->json(['errors' => $Logic->getErrors()], 422);
            }

            return Response()->json(['m' => 'Se ha eliminado correctamente el registro'], 200);
        }

        return Response()->json(['errors' => $Validator->errors()], 422);
    }
}
