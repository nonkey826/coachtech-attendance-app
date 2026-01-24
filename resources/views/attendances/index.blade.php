<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">勤怠一覧</h1>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">日付</th>
                        <th class="p-3 text-left">出勤</th>
                        <th class="p-3 text-left">退勤</th>
                        <th class="p-3 text-left">休憩</th>
                        <th class="p-3 text-left">合計</th>
                        <th class="p-3 text-left">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr class="border-t">
                            <td class="p-3">{{ $attendance->date->format('Y-m-d') }}</td>

                            <td class="p-3">
                                {{ $attendance->clock_in_at ? $attendance->clock_in_at->format('H:i') : '-' }}
                            </td>

                            <td class="p-3">
                                {{ $attendance->clock_out_at ? $attendance->clock_out_at->format('H:i') : '-' }}
                            </td>

                            <td class="p-3">
                                {{ $attendance->breakMinutesText() }}
                            </td>

                            <td class="p-3">{{ $attendance->workMinutesText() }}</td>

                            <td class="p-3">
    <a href="{{ route('attendances.show', $attendance) }}" class="text-blue-600 hover:underline">
        詳細
    </a>
</td>




                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                勤怠データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

