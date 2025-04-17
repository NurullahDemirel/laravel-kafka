<?php

namespace App\Http\Controllers;

use App\Kafka\Producer\UserCreated\InsertAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|string',
            'address' => 'required|string',
        ]);


        $user = User::query()->updateOrCreate(
            ['email' => $request->string('email')],
            $request->only('name', 'email', 'password')
        );
        app(InsertAddress::class)->produce('user-created', json_encode([
            'address' => $request->string('address'),
            'email' => $request->string('email'),
            'user_id' => $user->id
        ]));

        return response()->json([
            'user' => $request->all()
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
