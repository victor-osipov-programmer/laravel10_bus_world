<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'query' => ['required', 'string']
        ]);
        $query = $data['query'];

        $stations = Station::select(['city', 'name', 'code'])->whereAny(['city', 'name'], 'like', "%$query%")->get();

        return [
            'data' => [
                'items' => $stations
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Station $station)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStationRequest $request, Station $station)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station)
    {
        //
    }
}
