@extends('layout')

@section('title', 'Home')

@section('content')
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">Recent Commits</h1>

    @if($commits->isEmpty())
        <p class="text-lg text-gray-600">No commits available.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 py-6">
            @foreach($commits as $commit)
            <div class="relative bg-white p-6 rounded-lg shadow-lg resize-card overflow-hidden">
                <div class="absolute inset-0 z-10 border-r-4 border-gray-300 cursor-ew-resize"></div>
                <div class="relative z-20">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-code-branch fa-2x text-blue-500 mr-3"></i>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $commit->branch_name }}</h2>
                    </div>
                    <p class="text-gray-500 text-sm">Created at: {{ $commit->created_at->format('Y-m-d') }}</p>

                    <div class="mt-4">
                        <strong class="text-gray-700">Commit Message:</strong>
                        <p class="text-gray-800 mt-1">{{ $commit->commit_message }}</p>
                    </div>

                    <div class="mt-4">
                        <strong class="text-gray-700">File Paths:</strong>
                        <ul class="file-path-list mt-2">
                            @foreach(json_decode($commit->file_path, true) as $file)
                                <li class="text-gray-800 flex items-center whitespace-nowrap overflow-hidden relative group">
                                    <i class="fas fa-file-alt mr-2 text-gray-500"></i>
                                    <span class="truncate">{{ $file }}</span>
                                    <!-- <div class="abc absolute left-0 top-full mt-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded p-2 max-w-xs">
                                        {{ $file }}
                                    </div> -->
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endsection

@section('styles')
<style>
    .file-path-list {
        list-style: none; 
        padding-left: 0;
    }
</style>
@endsection
