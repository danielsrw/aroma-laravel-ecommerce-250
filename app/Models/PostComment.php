<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'comment', 'replied_comment', 'parent_id', 'status'];

    public function user_info(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public static function getAllComments(){
        return PostComment::with('user_info')->paginate(10);
    }

    public static function getAllUserComments(){
        return PostComment::where('user_id', auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function replies(){
        return $this->hasMany(PostComment::class, 'parent_id')->where('status', 'active');
    }
}
