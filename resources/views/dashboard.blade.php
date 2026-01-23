<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">

                    <p>{{ __("You're logged in!") }}</p>

                    <a href="{{ route('attendance.index') }}"
   style="display:inline-block;padding:10px 16px;background:#000;color:#fff;border-radius:6px;text-decoration:none;">
    勤怠打刻へ
</a>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
