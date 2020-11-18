<?php

namespace App\Http\Controllers\Api;

use App\Events\Chat\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller
{
    public function listMessages(User $user)
    {
        $userFrom = auth()->id();
        $userTo = $user->id;

        $messages =  Message::where(function ($query) use ($userFrom, $userTo) {
            $query->where([
                'from' => $userFrom,
                'to' => $userTo
            ]);
        })->orWhere(function ($query) use ($userFrom, $userTo) {
            $query->where([
                'from' => $userTo,
                'to' => $userFrom
            ]);
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'messages' => $messages
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Message $message)
    {
        $return = $message->create([
            'from' => Auth::id(),
            'to' => $request->user_id,
            'content' => $request->message
        ]);

        Event::dispatch(new SendMessage($return));

        return response()->json([
            'message' => $return
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
