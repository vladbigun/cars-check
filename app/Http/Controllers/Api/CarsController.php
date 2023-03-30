<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarsStoreRequest;

use App\Models\Cars;
use App\Models\CarsSearch;
use HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use function Symfony\Component\Translation\t;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Cars::search(request()->all());
        return $cars->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarsStoreRequest $request)
    {
        $url = "https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/".$request->vin."?format=json";
        $response = Http::get($url);

        $car = new Cars();
        $car->fill($request->validated());
        if (!$response->failed()) {
            $data = $response->json()['Results'][0];
            $car->brand = $data['Make'];
            $car->model = $data['Model'];
            $car->year = $data['ModelYear'];
            $car->save();
        }
        return $car;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Cars::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarsStoreRequest $request, string $id)
    {
        $car = Cars::find($id);
        $car->fill($request->validated())->save();
        return $car;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cars::findOrfail($id)->delete();
    }
}
