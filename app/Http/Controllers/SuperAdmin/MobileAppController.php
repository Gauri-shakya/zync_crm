<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileAppController extends Controller
{
    public function index()
    {
        $apps = MobileApp::latest()->get();
        return view('superadmin.mobile_apps.index', compact('apps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required|string|max:255',
            'apk_file' => 'required|file|mimes:apk,zip,bin|max:102400', // max 100MB
        ]);

        if ($request->hasFile('apk_file')) {
            $file = $request->file('apk_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('apps', $fileName, 'public');

            // Deactivate all previous versions
            MobileApp::where('is_active', true)->update(['is_active' => false]);

            MobileApp::create([
                'version' => $request->version,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'is_active' => true,
            ]);

            return back()->with('success', 'Mobile App uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload Mobile App.');
    }

    public function download()
{
    $app = MobileApp::where('is_active', true)->latest()->first();

    if ($app && Storage::disk('public')->exists($app->file_path)) {
        
        $headers = [
            'Content-Type' => 'application/vnd.android.package-archive',
        ];

        return Storage::disk('public')->download(
            $app->file_path,
            pathinfo($app->file_name, PATHINFO_FILENAME) . '.apk',
            $headers
        );
    }

    return back()->with('error', 'App file not found.');
}
}
