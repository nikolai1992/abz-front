<?php

namespace App\Http\Controllers;

use App\Services\ABZApiServices;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    private $abzApiService;
    public function __construct()
    {
        $this->abzApiService = app(ABZApiServices::class);
    }

	public function create()
	{
        $positions = $this->abzApiService->getPositions();
        $errors = Session::get('errors');
        $errorMessage = Session::get('error_message');

		return view('front.user.create', compact(
            'positions',
            'errors',
            'errorMessage'
        ));
	}

    public function show($id)
    {
        $result = $this->abzApiService->showUser($id);
        if ($result->success === false) {
            return redirect()->route('main.page');
        }
        $user = $result->user;

        return view('front.user.show', compact('user'));
    }
}
