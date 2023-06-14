<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'parent_id', 'comment_body', 'commentable_id', 'commentable_type', 'parent_user_id'];

    protected $hidden = [
        'parent_user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_comment_id');
    }

    // public function replies()
    // {
    //     return $this->hasMany(Comment::class,'parent_id');
    // }

    public function reply()
    {
        return $this->hasMany(Comment::class,'parent_id','id');
    }


    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id', 'id')->select('id', 'name', 'email', 'image', 'type');
    }

}
