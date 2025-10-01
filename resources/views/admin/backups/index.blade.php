@extends('layouts.app')

@section('title', 'Manage Backups')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Available Backups</h2>
    
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($files as $file)
                <tr>
                    <td>{{ basename($file) }}</td>
                    <td>
                        <a href="{{ route('admin.backups.download', $file) }}" class="btn btn-sm btn-success">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <form action="{{ route('admin.backups.delete', $file) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">No backups available</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
