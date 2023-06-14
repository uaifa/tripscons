<?php


namespace App\Tripscon\Services\Quote;


use App\Notification;
use App\Tripscon\Interfaces\iQuote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guide implements iQuote
{

    /**
     * @inheritDoc
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'description' => 'required',
            'min_price' => 'required|gt:0',
            'max_price' => 'required|gt:0',
        ]);

        $users = '';
        $status = 422;
        $message = 'Unprocessable Entity';
        $userId = (int)$request->userId;
        $userServiceType = $request->selectedType;

        $body = [
            ['key' => 'date_from', 'value' => date("Y-m-d", strtotime($request->dateFrom))],
            ['key' => 'date_to', 'value' => date("Y-m-d", strtotime($request->dateTo))],
            ['key' => 'location', 'value' => $request->location],
            ['key' => 'no_of_people', 'value' => $request->no_of_people],
            ['key' => 'price_range', 'value' => $request->min_price .' - '.$request->max_price],
        ];
        $callToActions = [
            ['key' => 'accept', 'value' => '/'],
            ['key' => 'reject', 'value' => '/']
        ];

        if (Auth::check()) {
            if ($userId == 0) {
                $request->validate([
                    'guideForm.gender' => 'required',
                    'guideForm.selectedActivities' => 'required',

                ], [
                    'guideForm.gender.required' => 'Please, Select Host Gender.',
                    'guideForm.selectedActivities.required' => 'Please, Select Interest.'
                ]);
                $users = User::getAllUserByTypeName($userServiceType, $request['guideForm']['gender']);
            } elseif ($userId) {
                $users = User::whereId($userId)->get();
            }
            $status = 404;
            $message = 'Users Not Found.';
            if ($users) {
                foreach ($users as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'sender_user' => Auth::id(),
                        'message' => $request->description,
                        'body' => json_encode($body),
                        'type' => 'guide:quote',
                        'seen' => 0,
                        'actions' => json_encode($callToActions),
                        'active' => true
                    ]);
                }
                $status = 200;
                $message = 'Your Quote Successfully Submitted.';
            }
        } else {
            $status = 422;
            $message = 'Please, Login or sign up then try again.';
        }
        return response()->json(['message' => $message], $status);
    }
}
