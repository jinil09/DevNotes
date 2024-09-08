@extends('layout')

@section('title', isset($commit) ? 'Edit Commit' : 'Add Commit')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-extrabold mb-8 text-gray-800">{{ isset($commit) ? 'Edit Commit' : 'Add Commit' }}</h1>

    <form action="{{ route('commits.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf

        @if (isset($commit))
            <input type="hidden" name="id" value="{{ $commit->id }}">
        @endif

        <div class="mb-4">
            <label for="branch_name" class="block text-sm font-medium text-gray-700">Branch Name:</label>
            <input type="text" id="branch_name" name="branch_name" value="{{ old('branch_name', $commit->branch_name ?? '') }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>

        <div class="mb-4">
            <label for="commit_message" class="block text-sm font-medium text-gray-700">Commit Message:</label>
            <textarea id="commit_message" name="commit_message" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50" rows="1">{{ old('commit_message', $commit->commit_message ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="file_path" class="block text-sm font-medium text-gray-700">File Paths:</label>
            <textarea id="file_path" name="file_path" required rows="5"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('file_path', isset($commit) ? implode("\n", json_decode($commit->file_path, true)) : '') }}</textarea>
            <p class="mt-1 text-sm text-red-600">Enter each file path on a new line.</p>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
            <input type="date" id="date" name="date" value="{{ old('date', $commit->date ?? '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            {{ isset($commit) ? 'Update Commit' : 'Add Commit' }}
        </button>
    </form>
</div>
@endsection
