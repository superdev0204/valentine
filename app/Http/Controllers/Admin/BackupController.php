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
        $files = Storage::disk('local_backups')->files();
        return view('admin.backups.index', compact('files'));
    }

    public function download($file)
    {
        return Storage::disk('local_backups')->download($file);
    }

    public function delete($file)
    {
        Storage::disk('local')->delete($file);
        return back()->with('status', 'Backup deleted successfully!');
    }
}
