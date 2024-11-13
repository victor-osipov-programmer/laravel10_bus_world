<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'from' => ['required', Rule::exists('stations', 'code')],
            'to' => ['required', Rule::exists('stations', 'code')],
            'date1' => ['required', 'date_format:Y-m-d'],
            'date2' => ['required', 'date_format:Y-m-d'],
            'passengers' => ['required', 'min:1', 'max:25'],
        ]);

        $trips_to = Trip::where('from', $data['from'])
        ->where('to', $data['to'])
        ->where('from_date', $data['date1'])
        ->get();
        $trips_back = Trip::where('from', $data['to'])
        ->where('to', $data['from'])
        ->where('from_date', $data['date2'])
        ->get();

        return [
            'data' => [
                'trips_to' => $trips_to->map(fn ($trip) => [
                    'trip_id' => $trip->id,
                    'trip_code' => $trip->code,
                    'from' => [
                        'city' => $trip->from_station->city,
                        'station' => $trip->from_station->name,
                        'code' => $trip->from_station->code,
                        'date' => $trip->from_date,
                        'time' => $trip->from_time,
                    ],
                    'to' => [
                        'city' => $trip->to_station->city,
                        'station' => $trip->to_station->name,
                        'code' => $trip->to_station->code,
                        'date' => $trip->to_date,
                        'time' => $trip->to_time,
                    ],
                    'cost' => $trip->cost,
                    'availability' => $trip->availability,
                ]),
                'trips_back' => $trips_back->map(fn ($trip) => [
                    'trip_id' => $trip->id,
                    'trip_code' => $trip->code,
                    'from' => [
                        'city' => $trip->from_station->city,
                        'station' => $trip->from_station->name,
                        'code' => $trip->from_station->code,
                        'date' => $trip->from_date,
                        'time' => $trip->from_time,
                    ],
                    'to' => [
                        'city' => $trip->to_station->city,
                        'station' => $trip->to_station->name,
                        'code' => $trip->to_station->code,
                        'date' => $trip->to_date,
                        'time' => $trip->to_time,
                    ],
                    'cost' => $trip->cost,
                    'availability' => $trip->availability,
                ])
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
