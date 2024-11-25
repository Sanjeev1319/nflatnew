<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizbank extends Model
{
	public function quizQuestions() {
		return $this->hasMany(Quizquestions::class);
	}
}
