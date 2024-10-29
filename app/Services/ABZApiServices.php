<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Session;

class ABZApiServices
{
    public function getToken(): bool
    {
        $response = $this->prepareRequest()->get('{+domain}/api/token');
        if ($response->successful()) {
            $result = $response->object();
            session()->put('abz_token', $result->token);
            return true;
        }
        return false;
    }

    public function registerUser(array $data): object
    {
        $session = Session::get('abz_token');
        $path = $data['photo']->store('uploads', 'public');
        $data['photo'] = config('app.url') . '/storage/' . $path;
        $response = $this->prepareRequest()
            ->withHeaders([
                'token' => $session
            ])
            ->acceptJson()
            ->post('{+domain}/api/users', $data);
        $filePath = storage_path('app/public/' . $path); // Full path to the saved file
        unlink($filePath);

        if ($response->successful()) {
            return $response->object();
        }

        $errorData = $response->object(); // Get error details as array
        return literal(
            success: false,
            message: $errorData->message ?? 'An error occurred',
            errors: $errorData->data ?? []
        );
    }

    public function getUsers(int $count, int $page)
    {
        $response = $this->prepareRequest()
            ->get('{+domain}/api/users', [
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
            ->get('{+domain}/api/users/' . $id);
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
            ->get('{+domain}/api/positions');
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
