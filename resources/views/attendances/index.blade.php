<x-app-layout>
    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-5xl mx-auto px-6">

            <h1 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-3">
    <span class="w-1 h-6 bg-gray-800 inline-block"></span>
    勤怠一覧
</h1>


            {{-- 月移動バー（白い帯） --}}
            <div class="bg-white border rounded-md px-4 py-3 flex items-center justify-between">
                <a href="{{ url('/attendances?month=' . $prevMonth) }}"
                   class="text-sm text-gray-700 hover:underline">
                    ← 前月
                </a>

                <div class="flex items-center gap-2 text-sm font-semibold text-gray-800">
                    <span>📅</span>
                    <span>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('Y年n月') }}</span>
                </div>

                <a href="{{ url('/attendances?month=' . $nextMonth) }}"
                   class="text-sm text-gray-700 hover:underline">
                    翌月 →
                </a>
            </div>

            {{-- テーブル（白い枠） --}}
            <div class="bg-white border rounded-md overflow-hidden mt-3">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-800">
                            <th class="p-3 text-left">日付</th>
                            <th class="p-3 text-left">出勤</th>
                            <th class="p-3 text-left">退勤</th>
                            <th class="p-3 text-left">休憩</th>
                            <th class="p-3 text-left">合計</th>
                            <th class="p-3 text-left">詳細</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse ($attendances as $attendance)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $attendance->date->format('n月j日') }}
                                </td>

                                <td class="p-3">
                                    {{ $attendance->clock_in_at ? $attendance->clock_in_at->format('H時i分') : '-' }}
                                </td>

                                <td class="p-3">
                                    {{ $attendance->clock_out_at ? $attendance->clock_out_at->format('H時i分') : '-' }}
                                </td>

                                <td class="p-3">
                                    {{ $attendance->breakMinutesText() }}
                                </td>

                                <td class="p-3">
                                    {{ $attendance->workMinutesText() }}
                                </td>

                                <td class="p-3">
                                    <a href="{{ route('attendances.show', $attendance) }}"
   class="font-black text-gray-900 hover:opacity-70">
    詳細
</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('Y年n月') }} の勤怠データはありません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 今月合計（右下に配置） --}}
            <div class="mt-3 text-right text-sm text-gray-700">
                今月の総勤務時間：{{ \App\Models\Attendance::minutesToHourText($totalWorkMinutes) }}

            </div>

        </div>
    </div>
</x-app-layout>
