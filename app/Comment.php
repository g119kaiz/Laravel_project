<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   protected $fillable = [
       	'text',
       	'post_id',
       	'parent_id',
       	'user_id',
       	'user_name'
   ];
   public function isLikedBy($user): bool {
      return Like::where('user_id', $user->id)->where('reply_id', $this->id)->first() !==null;
   }
}