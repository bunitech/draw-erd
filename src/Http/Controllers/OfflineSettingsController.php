<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OfflineSettingsController extends Controller
{

    public function storeApiKey (Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);

        $apiKey = $request->api_key;

        // Path to your .env file
        $envPath = base_path('.env');

        if (file_exists($envPath) && is_writable($envPath)) {
            // Update or append the API_KEY variable
            $keyExists = preg_match('/^DRAW_ERD_API_KEY=/m', file_get_contents($envPath));
            if ($keyExists) {
                file_put_contents($envPath, preg_replace(
                    '/^DRAW_ERD_API_KEY=.*/m',
                    "DRAW_ERD_API_KEY={$apiKey}",
                    file_get_contents($envPath)
                ));
            } else {
                file_put_contents($envPath, PHP_EOL . "DRAW_ERD_API_KEY={$apiKey}", FILE_APPEND);
            }

            // Optionally reload config
            Artisan::call('config:clear');

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Unable to write to .env'], 500);
    }

    public function storeProjectKey (Request $request)
    {
        $request->validate([
            'project_key' => 'required|string',
        ]);

        $projectKey = $request->project_key;

        // Path to your .env file
        $envPath = base_path('.env');

        if (file_exists($envPath) && is_writable($envPath)) {
            // Update or append the PROJECT_KEY variable
            $keyExists = preg_match('/^DRAW_ERD_PROJECT_KEY=/m', file_get_contents($envPath));
            if ($keyExists) {
                file_put_contents($envPath, preg_replace(
                    '/^DRAW_ERD_PROJECT_KEY=.*/m',
                    "DRAW_ERD_PROJECT_KEY={$projectKey}",
                    file_get_contents($envPath)
                ));
            } else {
                file_put_contents($envPath, PHP_EOL . "DRAW_ERD_PROJECT_KEY={$projectKey}", FILE_APPEND);
            }

            // Optionally reload config
            Artisan::call('config:clear');

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Unable to write to .env'], 500);
    }
}
