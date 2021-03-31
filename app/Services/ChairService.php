<?php

namespace App\Services;

use App\Models\Chair;
use Illuminate\Support\Arr;

class ChairService
{
	public function storeChair($request)
	{
		validate($request->all(),[
			'chair_name' => 'required|string',
			'chair_slug' => 'required|string|alpha_dash',
			'body' => 'required|json'
		]);

		$name = $request->input('chair_name');
		$chair_slug = strtolower($request->input('chair_slug'));
		$body = json_decode($request->input('body'), true);

		$existed = Chair::where('chair_slug',$chair_slug)->first();

		$diff = collect($existed->body)->diffAssoc($body);

		if($existed->chair_name != $name || $diff->isNotEmpty() || $existed == null){
			$chair = new Chair;
			$chair->chair_name = $name;
			$chair->chair_slug = $chair_slug;
			$chair->body = $body;
			$chair->save();
			if($existed) $existed->delete();
		}else{
			$chair = $existed;
		}

		return ['status' => 'ok', 'code' => 200, 'data' => $chair, 'message' => 'data_saved'];
	}

	public function getChair($request)
	{
		$request->merge([
			'chair_slug' => $request->route('name'),
			'body_key' => $request->route('key'),
		]);

		if($request->route('name') == 'get-all-records'){
			return ['status' => 'ok', 'code' => 200, 'data' => Chair::all(), 'message' => 'sent'];
		}

		validate($request->all(),[
			'chair_slug' => 'required|string|exists:chairs,chair_slug',
			'body_key' => 'string|nullable',
			'timestamp' => 'numeric',
		]);

		$timestamp = empty($request->input('timestamp')) ? false : date('Y-m-d H:i:s',$request->input('timestamp'));

		$chair = Chair::where('chair_slug',$request->input('chair_slug'))->when($timestamp,function($query) use($timestamp){
			return $query->withTrashed()->where('created_at','<=',$timestamp);
		})->first();

		if(!$chair) return ['status' => 'error', 'code' => 400, 'message' => 'not_found'];

		if($request->input('body_key') == 'get-all-records'){
			$data = $chair->body;
		}else{
			$data = Arr::get($chair->body,$request->input('body_key'));
		}

		return ['status' => 'ok', 'code' => 200, 'data' => $data, 'message' => 'sent'];
	}
}
