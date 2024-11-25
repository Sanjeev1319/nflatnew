<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizquestions extends Model
{
  public function quizbank(){
		return $this->belongsTo(Quizbank::class);
	}
}
