<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversion extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['sender_id', 'receiver_id', 'status', 'active'];

    public static function getBySenderReceiverOrReceiverSender($senderId,$receiverId)
    {
       return self::where([['receiver_id', $receiverId],['sender_id', $senderId]])
            ->orWhere([['receiver_id', $senderId],['sender_id', $receiverId]])->orderBy('created_at', 'asc')->first();
    }

    /**
     * @Description Get All Conversions By User Id
     *
     * @param $userId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAllConversions($userId)
    {
        $conversions = [];
        $allSendersReceivers = self::where('receiver_id', $userId)->orWhere('sender_id', $userId)->orderBy('created_at', 'desc')->get();
        if ($allSendersReceivers) {
            foreach ($allSendersReceivers as $allSendersReceiver) {
                array_push($conversions, [
                    'conversion'=>$allSendersReceiver,
                    'messages' => Message::getByConversionId($allSendersReceiver->id),
                    'sender_user' => User::find($allSendersReceiver->sender_id),
                    'receiver_user' => User::find($allSendersReceiver->receiver_id),
                ]);
            }
        }
        return $conversions;
    }
}
