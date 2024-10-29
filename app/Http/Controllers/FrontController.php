<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowMoreRequest;
use App\Services\ABZApiServices;
use Session;

class FrontController extends Controller
{
    private ABZApiServices $abzApiService;
    private int $countPerPage = 6;

    public function __construct()
    {
        $this->abzApiService = app(ABZApiServices::class);
    }
	public function index()
	{
		$abzToken = Session::get('abz_token');
        $errorMessage = Session::get('error_message');
        $users = $this->abzApiService->getUsers(count: $this->countPerPage, page: 1);

        return view('front.main', compact(
            'abzToken',
            'users',
            'errorMessage'
        ));
	}

    public function showMore($page)
    {
        $users = $this->abzApiService->getUsers(count: $this->countPerPage, page: $page);

        return view('_partials.users-list-tr', compact('users'));
    }

    public function getToken()
    {
        $this->abzApiService->getToken();

        return redirect()->route('main.page');
    }
}
