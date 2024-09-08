<nav class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-4 shadow-lg">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <!-- Left Section -->
            <div class="flex items-center space-x-6">
                <a href="/" 
                    class="text-lg font-bold hover:text-blue-400 transition-colors duration-300 ease-in-out {{ Request::is('/') ? 'text-blue-400' : 'text-white' }}">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                @auth
                    <a href="/commits" 
                       class="hover:text-blue-400 transition-colors duration-300 ease-in-out {{ Request::is('commits') ? 'text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-code-branch mr-2"></i>Commits
                    </a>
                    <a href="/add-commit" 
                       class="hover:text-blue-400 transition-colors duration-300 ease-in-out {{ Request::is('add-commit') ? 'text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-plus mr-2"></i>Add Commit
                    </a>
                @endauth
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-6">
                @guest
                    <a href="/login" 
                       class="hover:text-blue-400 transition-colors duration-300 ease-in-out {{ Request::is('login') ? 'text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="/register" 
                       class="hover:text-blue-400 transition-colors duration-300 ease-in-out {{ Request::is('register') ? 'text-blue-400' : 'text-gray-300' }}">
                        <i class="fas fa-user-plus mr-2"></i>Register
                    </a>
                @else
                    <div class="relative group">
                        <span class="cursor-pointer hover:text-blue-400 transition-colors duration-300 ease-in-out text-gray-300">
                            <i class="fas fa-user mr-2"></i>Welcome, {{ auth()->user()->name }}
                        </span>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-gray-700 text-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:translate-y-2 transform transition-all duration-300 ease-in-out z-10">
                            <a href="/profile" class="block px-4 py-2 hover:bg-gray-600">Profile</a>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-600">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
