<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Chair extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = ['chair_slug', 'chair_name', 'body', 'status'];
	protected $casts = ['body' => 'array'];
	protected $statuses = [0 => 'inactive', 1 => 'active'];

	public function getStatusAttribute($value)
	{
		return $this->statuses[$value];
	}

	protected function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}
}
