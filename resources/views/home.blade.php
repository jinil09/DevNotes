@extends('layout')

@section('title', 'Home')

@section('content')
    @auth
        <h1 class="text-3xl font-extrabold mb-6 mt-6 ml-4 text-gray-800">Recent Commits</h1>

        @if($commits->isEmpty())
            <div class="flex items-center justify-center h-full" style="width:auto; height:70vh">
                <p class="text-lg text-gray-600">
                    No commits Data available. 
                    <a href="/add-commit" class="text-blue-500 underline hover:text-blue-600">
                        add commit
                    </a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 py-2">
                @foreach($commits as $commit)
                <div class="relative bg-white p-6 rounded-lg shadow-lg resize-card overflow-hidden hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:-translate-y-1">
                    <div class="absolute inset-0 z-10 border-r-4 border-gray-300 cursor-ew-resize"></div>
                    <div class="relative z-20">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-code-branch fa-2x text-blue-500 mr-3 animate-bounce"></i>
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
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center h-screen bg-white text-gray-900 text-center">
            <h1 class="text-6xl font-extrabold animate-fadeIn mb-6">Welcome to the Commit Center!</h1>
            <p class="text-2xl text-gray-700 mt-4 animate-pulse">No recent commits available. Start making changes now!</p>

            <div class="mt-12">
                <p class="text-3xl font-semibold text-gray-800">Do commits, make messages for:</p>
                <ul class="mt-8 space-y-6 text-lg">
                    <li class="flex items-center animate-fadeInLeft">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <span>Quality Assurance (QA)</span>
                    </li>
                    <li class="flex items-center animate-fadeInRight">
                        <i class="fas fa-wrench text-yellow-400 mr-3"></i>
                        <span>Hotfixes</span>
                    </li>
                </ul>
            </div>

            <div class="mt-16">
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition-transform transform hover:scale-110 duration-300">
                    Login to Get Started
                </a>
            </div>
        </div>

    @endauth
@endsection

@section('styles')
<style>
    /* Super Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 2s ease-in-out;
    }

    .animate-fadeInLeft {
        animation: fadeInLeft 1.5s ease-out;
    }

    .animate-fadeInRight {
        animation: fadeInRight 1.5s ease-out;
    }

    .animate-bounce {
        animation: bounce 1.5s infinite;
    }
</style>
@endsection
