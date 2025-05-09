<nav class="bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex-shrink-0">
        <img src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
             class="h-8 w-auto" alt="Logo">
      </a>

      <!-- Links -->
      <div class="hidden sm:flex space-x-4">
        <a href="{{ url('/') }}"
           class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
          Home
        </a>
        <a href="{{ route('products.index') }}"
           class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
          Productos
        </a>
      </div>

      <!-- Auth Links -->
      <div class="flex items-center space-x-4">
        @guest
          <a href="{{ route('login') }}"
             class="text-sm text-gray-700 hover:underline">
            Login
          </a>
          <a href="{{ route('register') }}"
             class="text-sm text-gray-700 hover:underline">
            Register
          </a>
        @else
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center text-sm text-gray-700 focus:outline-none">
              {{ Auth::user()->name }}
              <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.23 7.21a.75.75 0 011.06-.02L10 10.646l3.71-3.457a.75.75 0 111.04 1.08l-4.25 3.965a.75.75 0 01-1.04 0L5.25 8.27a.75.75 0 01-.02-1.06z"/>
              </svg>
            </button>
            <div x-show="open" @click.outside="open = false"
                 class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg py-1 z-10">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </div>
          </div>
        @endguest
      </div>

      <!-- Mobile menu button -->
      <div class="sm:hidden">
        <button @click="$el.nextElementSibling.classList.toggle('hidden')"
                class="p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden hidden">
      <a href="{{ url('/') }}"
         class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">
        Home
      </a>
      <a href="{{ route('products.index') }}"
         class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">
        Productos
      </a>
      @guest
        <a href="{{ route('login') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">
          Login
        </a>
        <a href="{{ route('register') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">
          Register
        </a>
      @endguest
    </div>
  </div>
</nav>
