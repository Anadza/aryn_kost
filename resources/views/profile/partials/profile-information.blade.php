<div class = "w-full bg-white dark:bg-gray-800 p-6 rounded-2xl flex flex-col items-center text-center shadow-sm">
    <div class = "w-24 h-24 bg-[#1E4363] bg-opacity-10 text-[#1E4363] rounded-full flex items-center justify-center text-4xl mb-4">
        👤
    </div>
    <p class = "text-gray-600 text-lg text-gray-900 dark:text-gray-100 text-center ">
        {{ $user->name }}
    </p>
    <p class = "text-gray-600 text-sm text-gray-900 dark:text-gray-100 text-center ">
        {{ $user->email }}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-danger-button :href="route('logout')"
            onclick="event.preventDefault();
            this.closest('form').submit();" class="w-full justify-center mt-32">
            {{ __('Log Out') }}
        </x-danger-button>
    </form>
</div>
