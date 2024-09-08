@extends('layout')

@section('title', 'Commit-List')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-extrabold mb-6 text-gray-800">All Commits</h1>

        @if($commits->count() > 0)
            <div class="mb-4 flex items-center">
                <input type="text" id="search" placeholder="Search by branch name..." 
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50" />
                <button id="exportCsv" class="ml-2 bg-blue-500 text-white p-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <i class="fas fa-file-csv"></i>
                </button>
            </div>
        @endif

        <p id="noResultsMessage" class="text-lg text-gray-600 hidden">No Commits Found</p>

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
            <div id="commit-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($commits as $commit)
                <div class="relative bg-white p-6 rounded-lg shadow-lg resize-card overflow-hidden commit-card" data-branch-name="{{ strtolower($commit->branch_name) }}">
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
                            <button id="copy-all-paths" class="copy-all-paths-btn ml-2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-copy"></i>
                                <span class="sr-only">Copy All Paths</span>
                            </button>
                            <ul class="file-path-list mt-2">
                                @foreach(json_decode($commit->file_path, true) as $file)
                                    <li class="text-gray-800 flex items-center whitespace-nowrap overflow-hidden relative group">
                                        <i class="fas fa-file-alt mr-2 text-gray-500"></i>
                                        <span class="truncate">{{ $file }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-6 flex space-x-4">
                            <button class="qa-btn px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">QA</button>
                            <button class="hotfix-btn px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300">HotFix</button>
                            <a href="{{ route('commits.editCommit', $commit->id) }}" 
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 focus:outline-none focus:ring focus:ring-yellow-300">
                                Update
                            </a>
                        </div>
                        <p class="message-success text-green-500 mt-2 hidden">Copied to clipboard!</p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('styles')
<style>
    .file-path-list {
        list-style: none; 
        padding-left: 0;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Real-time search functionality
        const searchInput = document.getElementById('search');
        const commitCards = document.querySelectorAll('.commit-card');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            commitCards.forEach(card => {
                const branchName = card.getAttribute('data-branch-name');
                if (branchName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            if (resultsFound) {
                noResultsMessage.classList.add('hidden');
            } else {
                noResultsMessage.classList.remove('hidden');
            }
        });

        document.querySelectorAll('.qa-btn, .hotfix-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.commit-card');
                const branchName = card.querySelector('h2').innerText;
                const commitMessage = card.querySelector('p.text-gray-800.mt-1').innerText;
                const formattedMessage = `Task Assigned:\n\nBranch: teamosb/${branchName}\n\n${commitMessage}`;

                navigator.clipboard.writeText(formattedMessage).then(() => {
                    button.innerText = 'Copied';
                    button.classList.add('bg-green-500', 'hover:bg-green-600');

                    setTimeout(() => {
                        button.innerText = 'QA';
                        button.classList.remove('bg-green-500', 'hover:bg-green-600');
                    }, 2000);
                });
            });
        });

        document.querySelectorAll('.hotfix-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.commit-card');
                const branchName = card.querySelector('h2').innerText;
                const commitMessage = card.querySelector('p.text-gray-800.mt-1').innerText;
                const filePaths = Array.from(card.querySelectorAll('.file-path-list li')).map(li => li.innerText).join('\n');

                const formattedMessage = `Hotfix\n\nBranch: teamosb/${branchName}\n\n${commitMessage}\n\n${filePaths}`;

                navigator.clipboard.writeText(formattedMessage).then(() => {
                    button.innerText = 'Copied';
                    button.classList.add('bg-green-500', 'hover:bg-green-600');

                    setTimeout(() => {
                        button.innerText = 'HotFix';
                        button.classList.remove('bg-green-500', 'hover:bg-green-600');
                    }, 2000);
                });
            });
        });

        document.querySelectorAll('.copy-all-paths-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.commit-card');
                // const branchName = card.querySelector('h2').innerText;
                // const commitMessage = card.querySelector('p.text-gray-800.mt-1').innerText;
                const filePaths = Array.from(card.querySelectorAll('.file-path-list li')).map(li => li.innerText).join('\n');

                navigator.clipboard.writeText(filePaths).then(() => {
                    button.innerHTML = '<i class="fas fa-check"></i><span class="sr-only">Copied</span>';
                    button.classList.add('text-green-500');

                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy"></i><span class="sr-only">Copy All Paths</span>';
                        button.classList.remove('text-green-500');
                    }, 2000);
                });
            });
        });
        

        document.getElementById('exportCsv').addEventListener('click', () => {
            const commits = Array.from(document.querySelectorAll('.commit-card')).map(card => {
                const branchName = card.querySelector('h2').innerText;
                const commitMessage = card.querySelector('p.text-gray-800.mt-1').innerText;
                const filePaths = Array.from(card.querySelectorAll('.file-path-list li')).map(li => li.innerText).join('\n');
                return {
                    branchName,
                    commitMessage,
                    filePaths
                };
            });

            // const csvRows = [
            //     ['Branch Name', 'Commit Message', 'File Paths'],
            //     ...commits.map(c => [
            //         c.branchName,
            //         c.commitMessage,
            //         c.filePaths.replace(/\n/g, ' ')
            //     ])
            // ];

            const textContent = commits.map(c => 
                `[${c.branchName}]\n\n${c.commitMessage}\n\n${c.filePaths}\n=======================================================\n\n`
            ).join('');

            // const csvContent = csvRows.map(row => row.join(',')).join('\n');
            const blob = new Blob([textContent], { type: 'text/plain;charset=utf-8;' });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'commits.txt';
            link.click();
        });
    });
</script>
@endsection
