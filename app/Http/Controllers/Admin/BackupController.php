<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Storage;

class BackupController extends Controller
{
    public function create()
    {
        Artisan::call('backup:run');
        return back()->with('status', 'Backup created and uploaded to Google Drive!');
    }

    public function index()
    {
        $files = Storage::disk('google')->files();
        return view('admin.backups.index', compact('files'));
    }

    public function download($file)
    {
        $content = Storage::disk('google')->get($file);
        return response($content)
            ->header('Content-Type', 'application/zip')
            ->header('Content-Disposition', 'attachment; filename="' . basename($file) . '"');
    }

    public function delete($file)
    {
        Storage::disk('google')->delete($file);
        return back()->with('status', 'Backup deleted from Google Drive!');
    }
}
