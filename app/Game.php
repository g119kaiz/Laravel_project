<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
   public function getPaginateByLimit(int $limit_count = 10)
   {
	   // updated_atで降順に並べたあと、limitで件数制限をかける
	   return $this->paginate($limit_count);
   }
}