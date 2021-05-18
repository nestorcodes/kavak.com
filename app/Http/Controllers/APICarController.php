<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class APICarController extends Controller
{
    //

    public function index(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'modelid' => ['integer'],
            'brandid' => ['integer'],
            'model' => ['string'],
            'brand' => ['string'],
            'year' => ['integer'],
            'transmission' => ['integer'],
            'typeid' => ['integer'],
            'type' => ['string'],
            'gastype' => ['integer'],
            'seats' => ['integer'],
            'minprice' => ['numeric'],
            'maxprice' => ['numeric'],
            'status'=> Rule::in(['1', '0'])
        ], [
            'status.in' => 'The selected status is invalid. options: 1,0',
            
        ]);

        if (!$Validator->fails()) {
   
            $select = "

            cars.id as code,
            cars.status_id,
            cars.model_id,
            cars.type_id,
            cars.price,
            cars.creator_id,
            cars.buyer_id,
            cars.price,
            cars.transmission,
            cars.motor,
            cars.traction,
            cars.details,
            cars.horse_power,
            cars.gas_type,
            cars.seats,
            cars.year,

            car_brands.id AS brand_id,
            car_brands.name as brand,
            car_brands.picture_uri,

            car_models.name as model,

            car_types.name AS type
            
            ";



            $cars = DB::table('cars')
                ->selectRaw($select)
                ->leftJoin('car_models', 'car_models.id', '=', 'cars.model_id')
                ->leftJoin('car_brands', 'car_brands.id', '=', 'car_models.brand_id')
                ->leftJoin('car_types' , 'car_types.id' , '=', 'cars.type_id' );
            //->get();

            if (isset($request['modelid'])) {
                $cars->where('model_id', '=', $request['modelid']);
            }

            if (isset($request['model'])) {
                $cars->where('car_models.name', 'REGEXP', $request['model']);
           
            }

            if (isset($request['brandid'])) {
                $cars->where('brand_id', '=', $request['brandid']);
            }

            if (isset($request['brand'])) {
                 $cars->where('car_brands.name', 'REGEXP', $request['brand']);
           
            }

            if (isset($request['status'])) {
                $cars->where('status', '=', $request['status']);
            }

            if (isset($request['year'])) {
                $cars->where('year', '=', $request['year']);
            }

            if (isset($request['transmission'])) {
                $cars->where('transmission', '=', $request['transmission']);
            }

            if (isset($request['typeid'])) {
                $cars->where('type_id', '=', $request['typeid']);
            }

            if (isset($request['type'])) {
                $cars->where('car_types.name', 'REGEXP', $request['type']);
           
            }


            if (isset($request['gastype'])) {
                $cars->where('gas_type', '=', $request['gastype']);
            }

            if (isset($request['seats'])) {
                $cars->where('seats', '=', $request['seats']);
            }

            if (isset($request['minprice'])) {
                $cars->where('price', '>=', (int)$request['minprice'] );
            }

            if (isset($request['maxprice'])) {
                $cars->where('price', '<=', (int)$request['maxprice'] );
            }

            return $cars->get();


        }

        return Response()->json(['errors' => $Validator->errors()], 422);

    }
 
    public function show($id)
    {
        return Car::find($id);
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    }


        /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}