<?php

namespace App\Http\Controllers;

use App\Services\ABZApiServices;
use  Session;
class TokenController extends Controller
{
    private ABZApiServices $abzApiService;

    public function __construct()
    {
        $this->abzApiService = app(ABZApiServices::class);
    }
    public function getToken()
    {
        $this->abzApiService->getToken();

        return redirect()->route('main.page');
    }

    public function delete()
    {
        Session::forget('abz_token');
        return redirect()->route('main.page');
    }
}
