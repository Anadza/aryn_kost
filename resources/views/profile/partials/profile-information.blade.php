<div class = "w-full bg-white dark:bg-gray-800 p-6 rounded-2xl flex flex-col items-center text-center shadow-sm">
    <div class = "w-24 h-24 bg-[#1E4363] bg-opacity-10 text-[#1E4363] rounded-full flex items-center justify-center text-4xl mb-4">
        👤
    </div>
    <p class = "text-gray-600 text-lg text-gray-900 dark:text-gray-100 text-center ">
        {{ $user->name }}
    </p>
    <p class = "text-gray-600 text-sm text-gray-900 dark:text-gray-100 text-center ">
        {{ $user->email }}
    </p>
    <button href = "{{ route('logout') }}" onclick = "event.preventDefault(); this.closest('form').submit();" class = "mt-32 px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300">
        {{ __('Log Out') }}
    </button>
</div>
