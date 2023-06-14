<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id','sender_id', 'receiver_id','model_id', 'message', 'body', 'type', 'actions', 'seen', 'status', 'active'];


    /**
     * @Description Related to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @Author Khuram Qadeer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->hasOne(User::class , 'id','sender_id');
    }

    /**
     * @Description Get All Notification Detail by notification id
     *
     * @param $id
     * @return array
     *
     * @Author Khuram Qadeer.
     */
    public static function getById($id)
    {
        $res = [];
        $notification = self::find($id);
        if ($notification) {
            $res['notification'] = $notification;
            $res['user'] = User::find($notification->user_id);
            if ($notification->type == 'host:book'
                || $notification->type == 'photographer:book'
                || $notification->type == 'movie_maker:book'
                || $notification->type == 'guide:book') {
                $body = json_decode($notification->body);
                if ($body) {
                    if ($body[0]->key == 'order_id') {
                        $res['order'] = Order::whereId($body[0]->value)->first();
                        $res['order_items'] = OrderItem::getByOrderId($body[0]->value);
                    }
                }
            }
        }
        return $res;
    }

}
