<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Logic\Maintenance\Maintenance;
use App\Models\CarBrand;

use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('maintenance.brand');
    }

    public function load(Request $request)
    {
        $Logic = new Maintenance(new CarBrand);
        $Query = $Logic->Query();

        return DataTables::of($Query)
            ->make(true);
    }

    public function get(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'code' => ['required', 'integer', 'min:1'],
        ], [
            'code.required' => 'El identificador de la marca es requerido',
            'code.integer'  => 'El identificador de la marca es un numero entero',
            'code.min:1'    => 'El identificador de la marca es invalido',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarBrand());

            $Logic->get($request->input('code'));

            $brand = $Logic->returnModel();

            if (isset($brand->id)) {
                return Response()->json(['d' => $brand], 200);
            }

            return Response()->json(['m' => 'No existe ninguna marca con ese identificador'], 422);
        }

        return Response()->json(['errors' => $Validator->errors()], 422);
    }

    public function create(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'picture_uri' => ['nullable']
        ], [
            'name.required' => 'El Nombre de la Marca es requerido',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarBrand());

            $formData = $Logic->parseForm($request->all());

            $Logic->validate($formData);

            if (!$Logic->hasErrors()) {
                $Logic->create($formData);

                return Response()->json(['m' => 'Se ha creado la marca correctamente'], 200);
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
            'picture_uri' => ['nullable'],
        ], [
            'code.required' => 'El identificador de la marca es requerido',
            'code.integer'  => 'El identificador de la marca es un entero',
            'code.min:1'    => 'El identificador de la marca no es valido',
            'name.required' => 'El nombre de la marca es requerido',
            'name.string'   => 'El nombre de la marca es una cadena de texto',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarBrand());

            $Logic->get($request->input('code'));

            $formData = $Logic->parseForm($request->all());
            $Logic->validate($formData);

            if (!$Logic->hasErrors()) {
                $Logic->update($formData);

                return Response()->json(['m' => 'Se ha actualizado la marca correctamente'], 200);
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
            'code.required' => 'El identificador de la marca es requerido',
            'code.integer'  => 'El identificador de la marca es un numero entero',
            'code.min:1'    => 'El identificador de la marca es invalido',
        ]);

        if (!$Validator->fails()) {
            $Logic = new Maintenance(new CarBrand());

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
