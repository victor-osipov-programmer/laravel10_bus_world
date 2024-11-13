<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        

        $booking_code = Str::random(5);
        DB::transaction(function () use($data, $booking_code) {

            $new_booking = Booking::create([
                'code' => $booking_code,
                'trip_from' => $data['trip_from']['id'],
                'trip_back' => $data['trip_back']['id'],
            ]);

            $users_ids = [];

            foreach ($data['passengers'] as $passenger) {
                $user = User::firstOrCreate($passenger);
                $users_ids[] = $user->id;
            }
    
            $new_booking->passengers()->attach($users_ids);
        });
        

        return response([
            'data' => [
                'code' => $booking_code
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $booking = Booking::with(['passengers'])->where('code', $code)->firstOrFail();

        $trip_from = Trip::find($booking['trip_from']);
        $trip_back = Trip::find($booking['trip_back']);

        return [
            'data' => [
                'code' => $booking->code,
                'cost' => ($trip_from->cost + $trip_back->cost) * $booking->passengers->count(),
                'trips' => [[
                    'trip_id' => $trip_from->id,
                    'trip_code' => $trip_from->code,
                    'from' => [
                        'city' => $trip_from->from_station->city,
                        'station' => $trip_from->from_station->name,
                        'code' => $trip_from->from_station->code,
                        'date' => $trip_from->from_date,
                        'time' => $trip_from->from_time,
                    ],
                    'to' => [
                        'city' => $trip_from->to_station->city,
                        'station' => $trip_from->to_station->name,
                        'code' => $trip_from->to_station->code,
                        'date' => $trip_from->to_date,
                        'time' => $trip_from->to_time,
                    ],
                    'cost' => $trip_from->cost,
                    'availability' => $trip_from->availability,
                ], [
                    'trip_id' => $trip_back->id,
                    'trip_code' => $trip_back->code,
                    'from' => [
                        'city' => $trip_back->from_station->city,
                        'station' => $trip_back->from_station->name,
                        'code' => $trip_back->from_station->code,
                        'date' => $trip_back->from_date,
                        'time' => $trip_back->from_time,
                    ],
                    'to' => [
                        'city' => $trip_back->to_station->city,
                        'station' => $trip_back->to_station->name,
                        'code' => $trip_back->to_station->code,
                        'date' => $trip_back->to_date,
                        'time' => $trip_back->to_time,
                    ],
                    'cost' => $trip_back->cost,
                    'availability' => $trip_back->availability,
                ]],
                'passengers' => $booking->passengers->map(fn($passenger) => [
                    'id' => $passenger->id,
                    'first_name' => $passenger->first_name,
                    'last_name' => $passenger->last_name,
                    'birth_date' => $passenger->birth_date,
                    'document_number' => $passenger->document_number,
                    'place_from' => $passenger->pivot->place_from,
                    'place_back' => $passenger->pivot->place_back,
                ])
            ]
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    function get_occupied_seat(Request $request, string $code) {
        $booking = Booking::with(['passengers'])->where('code', $code)->firstOrFail();

        $passengers = $booking->passengers;

        $occupied_from = $passengers
        ->filter(fn ($passenger) => isset($passenger->pivot->place_from))
        ->map(function ($passenger) {
            return [
                'passenger_id' => $passenger->pivot->user_id,
                'place' => $passenger->pivot->place_from,
            ];
        });


        $occupied_back = $passengers
        ->filter(fn ($passenger) => isset($passenger->pivot->place_back), )
        ->map(fn ($passenger) => [
            'passenger_id' => $passenger->pivot->user_id,
            'place' => $passenger->pivot->place_back,
        ]);

        return [
            'data' => [
                'occupied_from' => $occupied_from->values(),
                'occupied_back' => $occupied_back->values(),
            ]
        ];
    }
}
