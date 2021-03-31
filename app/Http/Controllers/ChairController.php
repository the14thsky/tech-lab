<?php

namespace App\Http\Controllers;

use App\Services\ChairService;
use Illuminate\Http\Request;

class ChairController extends Controller
{
	protected $chairService;

	public function __construct()
	{
		$this->chairService = new ChairService();
	}

	public function storeChair(Request $request)
	{
		$data = $this->chairService->storeChair($request);
		return response()->json($data,$data['code']);
	}

	public function getChair(Request $request)
	{
		$data = $this->chairService->getChair($request);
		return response()->json($data,$data['code']);
	}
}
