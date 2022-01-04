<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $fillable = [
       	'text',
       	'user_id',
       	'user_name',
       	'game_id'
   ];
   public function getPaginateByLimit(int $limit_count = 10)
   {
	   // updated_atで降順に並べたあと、limitで件数制限をかける
	   return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
   }
   public function isLikedBy($user): bool {
      return Like::where('user_id', $user->id)->where('post_id', $this->id)->first() !==null;
   }
}
