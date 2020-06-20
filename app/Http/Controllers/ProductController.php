<?php

namespace CodexShaper\App\Http\Controllers;

use CodexShaper\App\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
	public function __construct()
	{
		// $this->middleware('admin');
	}
	public function index(Request $request) 
	{
		// print_r(Post::all());
		// var_dump($request->page);

		return wp_send_json($request->all());

		// (new Response(
		// 	json_encode($request->all()),
		// 	Response::HTTP_OK,
  //   		['Content-Type' => 'application/json']
  //    		))->send();

		// die();

		// throw new \Exception("Error Processing Request", 1);
		
	}

	public function all(Request $request, $id)
	{
		// return json_encode(['success' => true]);
		// $request = Request::capture();

		var_dump($request->id);
	}

	public function store(Request $request) {
		return wp_send_json($request->all());
	}

	public function update(Request $request) {
		return wp_send_json($request->all());
	}
}