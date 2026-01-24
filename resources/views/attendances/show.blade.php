
<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-xl font-bold">勤怠詳細</h1>

        <div class="mt-4 bg-white shadow rounded-lg p-4">
    <p>日付：{{ $attendance->date->format('Y-m-d') }}</p>
    <p>出勤：{{ $attendance->clock_in_at ? $attendance->clock_in_at->format('H:i') : '-' }}</p>
    <p>退勤：{{ $attendance->clock_out_at ? $attendance->clock_out_at->format('H:i') : '-' }}</p>
    <p>休憩合計：{{ $attendance->breakMinutesText() }}</p>
    <p>勤務合計：{{ $attendance->workMinutesText() }}</p>
</div>


        <div class="mt-6">
            <h2 class="font-bold mb-2">休憩履歴</h2>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 text-left">開始</th>
                            <th class="p-3 text-left">終了</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendance->breaks as $break)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $break->break_start_at ? \Carbon\Carbon::parse($break->break_start_at)->format('H:i') : '-' }}
                                </td>
                                <td class="p-3">
                                    {{ $break->break_end_at ? \Carbon\Carbon::parse($break->break_end_at)->format('H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="p-6 text-center text-gray-500">
                                    休憩履歴はありません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ url('/attendances') }}" class="text-blue-600 hover:underline">
                ← 一覧に戻る
            </a>
        </div>
    </div>
</x-app-layout>

