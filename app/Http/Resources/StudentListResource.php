<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentListResource extends JsonResource
{

	public static $wraps = false;

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string,
	 *  mixed>
	 */
	public function toArray(Request $request)
	{
		return [
			"id"=> $this->id,
			"uuid"=> $this->uuid,
			"student_name"=> $this->student_name,
			"student_class"=> $this->student_class,
			"student_section"=> $this->student_section,
			"date_of_birth"=> $this->date_of_birth,
			"gender"=> $this->gender,
			"parent_name"=> $this->parent_name,
			"parent_email_id"=> $this->parent_email_id,
			"parent_mobile_number"=> $this->parent_mobile_number,
			"pass"=> base64_decode($this->pass),
		];
	}
}
