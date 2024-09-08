<nav class="bg-gray-800 p-4">
    <div class="container mx-auto">
        <div class="flex justify-between">
            <div>
                <a href="/" class="text-white text-lg font-bold">Home</a>
                @auth
                    <a href="/commits" class="ml-4 text-gray-300">Commits</a>
                    <a href="/add-commit" class="ml-4 text-gray-300">Add Commit</a>
                @endauth
            </div>
            <div>
                @guest
                    <a href="/login" class="ml-4 text-gray-300">Login</a>
                    <a href="/register" class="ml-4 text-gray-300">Register</a>
                @else
                    <span class="text-gray-300">Welcome, {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ml-4 text-gray-300">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
