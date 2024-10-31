<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Session;

class ABZApiServices
{
    public function getToken(): bool
    {
        $response = $this->prepareRequest()->get('{+domain}/api/v1/token');
        if ($response->successful()) {
            $result = $response->object();
            session()->put('abz_token', $result->token);
            return true;
        }
        return false;
    }
    public function getUsers(int $count, int $page)
    {
        $response = $this->prepareRequest()
            ->get('{+domain}/api/v1/users', [
                'count' => $count,
                'page' => $page,
            ]);
        if ($response->successful()) {
            return $response->object();
        }
    }

    public function showUser(int $id)
    {
        $response = $this->prepareRequest()
            ->get('{+domain}/api/v1/users/' . $id);
        if ($response->successful()) {
            return $response->object();
        }

        return literal(
            success: false,
            message: 'User not found',
        );
    }

    public function getPositions()
    {
        $response = $this->prepareRequest()
            ->get('{+domain}/api/v1/positions');
        if ($response->successful()) {
            return $response->object()->positions;
        }
    }

    private function prepareRequest(): PendingRequest
    {
        return Http::withUrlParameters([
            'domain' => config('app.abztestapiurl'),
        ]);
    }
}
