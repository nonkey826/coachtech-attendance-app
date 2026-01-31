<x-app-layout>
    <div class="py-10 bg-gray-100 min-h-screen">

        {{-- ✅ タイトル（棒つき） --}}
        <h1 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-3">
            <span class="w-1 h-6 bg-gray-800 inline-block"></span>
            勤怠修正申請
        </h1>

        {{-- ✅ form開始 --}}
        <form method="POST" action="{{ route('attendances.update', $attendance) }}">
            @csrf
            @method('PATCH')

            {{-- 中央カード --}}
            <div class="bg-white shadow rounded-lg overflow-hidden max-w-2xl mx-auto">

                <table class="w-full text-sm">
                    <tbody>
                        {{-- 名前 --}}
                        <tr class="border-t">
                            <th class="w-52 bg-gray-50 p-4 text-left text-gray-600 font-medium">
                                名前
                            </th>
                            <td class="p-4 font-semibold">
                                {{ Auth::user()->name }}
                            </td>
                        </tr>

                        {{-- 日付 --}}
                        <tr class="border-t">
                            <th class="bg-gray-50 p-4 text-left text-gray-600 font-medium">
                                日付
                            </th>
                            <td class="p-4">
                                {{ $attendance->date->format('Y-m-d') }}
                            </td>
                        </tr>

                        {{-- 出勤・退勤 --}}
                        <tr class="border-t">
                            <th class="bg-gray-50 p-4 text-left text-gray-600 font-medium">
                                出勤・退勤（申請）
                            </th>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-6">
                                    <input
                                        type="time"
                                        name="clock_in_at"
                                        value="{{ old('clock_in_at', optional($attendance->clock_in_at)->format('H:i')) }}"
                                        class="border border-gray-200 rounded px-3 py-2 w-32 text-center"
                                    >

                                    <span class="text-gray-500 font-bold w-6 text-center">〜</span>

                                    <input
                                        type="time"
                                        name="clock_out_at"
                                        value="{{ old('clock_out_at', optional($attendance->clock_out_at)->format('H:i')) }}"
                                        class="border border-gray-200 rounded px-3 py-2 w-32 text-center"
                                    >
                                </div>

                                @error('clock_in_at')
                                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                @enderror
                                @error('clock_out_at')
                                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 修正理由（必須） --}}
                        <tr class="border-t">
                            <th class="bg-gray-50 p-4 text-left text-gray-600 font-medium">
                                修正理由（必須）
                            </th>
                            <td class="p-4">
                                <div class="flex justify-center">
                                    <textarea
                                        name="reason"
                                        class="border border-gray-200 rounded px-4 py-2 w-[320px]"
                                        rows="3"
                                        required
                                        placeholder="例：電車遅延のため"
                                    >{{ old('reason') }}</textarea>
                                </div>

                                @error('reason')
                                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- ✅ ボタン（外・右下・黒固定） --}}
            <div class="w-[560px] mx-auto mt-6 flex justify-end">
                <button type="submit"
                    style="
                        background:#000 !important;
                        color:#fff !important;
                        font-weight:bold !important;
                        padding:10px 52px !important;
                        border-radius:4px !important;
                        display:inline-block !important;
                        box-shadow:0 2px 6px rgba(0,0,0,0.2) !important;
                        opacity:1 !important;
                        filter:none !important;
                    ">
                    申請を送信
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
