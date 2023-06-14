<?php


namespace App\Tripscon\Services\Quote;


use App\Notification;
use App\Tripscon\Interfaces\iQuote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Host implements iQuote
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
            'description' => 'required'
        ]);
        $users = '';
        $status = 422;
        $message = 'Unprocessable Entity';
        $userId = (int)$request->userId;
        $userServiceType = $request->selectedType;
        $selectedServices = $request['hostOptions']['selectServices'];

        $body = [
            ['key' => 'date_from', 'value' => date("Y-m-d", strtotime($request->dateFrom))],
            ['key' => 'date_to', 'value' => date("Y-m-d", strtotime($request->dateTo))],
            ['key' => 'location', 'value' => $request->location],
            ['key' => 'no_of_people', 'value' => $request->no_of_people],
        ];

        if ($selectedServices) {
            $request->validate([
                'hostOptions.selectServices.*.min_price' => 'required|gt:0',
                'hostOptions.selectServices.*.max_price' => 'required|gt:0',
            ],[
                'hostOptions.selectServices.*.min_price.required'=>'Minimum price field is required.',
                'hostOptions.selectServices.*.max_price.required'=>'Maximum price field is required.',
            ]);
            foreach ($selectedServices as $selectedService) {
                $key = strtolower($selectedService['name'] . '_price_range');
                $value = $selectedService['min_price'] . ' - ' . $selectedService['max_price'];
                array_push($body, ['key' => $key, 'value' => $value]);
            }
        }

        $callToActions = [
            ['key' => 'accept', 'value' => '/'],
            ['key' => 'reject', 'value' => '/']
        ];

        if (Auth::check()) {
            if ($userId == 0) {
                $request->validate([
                    'hostOptions.gender' => 'required',
                ], [
                    'hostOptions.gender.required' => 'Please, Select Host Gender.'
                ]);
                $users = User::getAllUserByTypeName($userServiceType, $request['hostOptions']['gender']);
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
                        'type' => 'host:quote',
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
