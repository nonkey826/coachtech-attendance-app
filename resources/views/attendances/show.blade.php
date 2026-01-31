@php
    $breaks = $attendance->breaks->take(2)->values();
    $break1 = $breaks->get(0);
    $break2 = $breaks->get(1);
@endphp

<x-app-layout>
    <div class="p-6 bg-gray-100 min-h-screen">

        {{-- タイトル（左に棒） --}}
        <h1 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-3">
            <span class="w-1 h-6 bg-gray-800 inline-block"></span>
            勤怠詳細
        </h1>

        {{-- ✅ 修正申請中カード --}}
        @if($pendingRequest)
            <div class="max-w-2xl mx-auto mb-4 p-4 rounded bg-yellow-50 border border-yellow-200">
                <p class="font-bold text-yellow-800">修正申請中（承認待ち）</p>

                <div class="text-sm text-gray-700 mt-2">
                    <p>
                        出勤：{{ optional($pendingRequest->requested_clock_in_at)->format('H:i') ?? '-' }}
                        ／ 退勤：{{ optional($pendingRequest->requested_clock_out_at)->format('H:i') ?? '-' }}
                    </p>
                    <p class="mt-1">
                        理由：{{ $pendingRequest->reason }}
                    </p>
                </div>
            </div>
        @endif

        {{-- 中央カード（見本っぽい幅） --}}
        <div class="bg-white rounded-lg shadow-md mx-auto w-[560px] overflow-hidden">

            @php
                // ✅ show画面は「閲覧専用」感を強める
                $timeInputClass = "w-[90px] text-center border border-gray-200 rounded px-2 py-1 text-sm bg-gray-50 cursor-not-allowed";
                $rowLabelClass = "w-[160px] px-6 py-4 text-sm text-gray-600 flex items-center justify-start";
                $rowBodyClass  = "flex-1 px-6 py-4";
            @endphp

            {{-- 名前 --}}
            <div class="flex">
                <div class="{{ $rowLabelClass }}">名前</div>
                <div class="{{ $rowBodyClass }} text-sm font-semibold text-gray-900 flex items-center justify-center">
                    {{ Auth::user()->name }}
                </div>
            </div>

            {{-- 日付 --}}
            <div class="flex border-t">
                <div class="{{ $rowLabelClass }}">日付</div>
                <div class="{{ $rowBodyClass }} text-sm text-gray-900 flex items-center justify-center gap-16">
                    <span>{{ $attendance->date->format('Y年') }}</span>
                    <span>{{ $attendance->date->format('n月j日') }}</span>
                </div>
            </div>

            {{-- 出勤・退勤 --}}
            <div class="flex border-t">
                <div class="{{ $rowLabelClass }}">出勤・退勤</div>
                <div class="{{ $rowBodyClass }} flex items-center justify-center gap-8">
                    <input
                        type="time"
                        value="{{ $attendance->clock_in_at ? $attendance->clock_in_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                    <span class="text-gray-600 font-bold">〜</span>
                    <input
                        type="time"
                        value="{{ $attendance->clock_out_at ? $attendance->clock_out_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                </div>
            </div>

            {{-- 休憩 --}}
            <div class="flex border-t">
                <div class="{{ $rowLabelClass }}">休憩</div>
                <div class="{{ $rowBodyClass }} flex items-center justify-center gap-8">
                    <input
                        type="time"
                        value="{{ $break1?->break_start_at ? $break1->break_start_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                    <span class="text-gray-600 font-bold">〜</span>
                    <input
                        type="time"
                        value="{{ $break1?->break_end_at ? $break1->break_end_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                </div>
            </div>

            {{-- 休憩2 --}}
            <div class="flex border-t">
                <div class="{{ $rowLabelClass }}">休憩2</div>
                <div class="{{ $rowBodyClass }} flex items-center justify-center gap-8">
                    <input
                        type="time"
                        value="{{ $break2?->break_start_at ? $break2->break_start_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                    <span class="text-gray-600 font-bold">〜</span>
                    <input
                        type="time"
                        value="{{ $break2?->break_end_at ? $break2->break_end_at->format('H:i') : '' }}"
                        class="{{ $timeInputClass }}"
                        readonly
                    />
                </div>
            </div>

            {{-- 備考（入力欄位置を揃える） --}}
            <div class="flex border-t border-b">
                <div class="{{ $rowLabelClass }}">備考</div>
                <div class="{{ $rowBodyClass }} flex items-center justify-center">
                    <div class="flex items-center gap-8">
                        {{-- 左inputの分 --}}
                        <div class="w-[90px]"></div>

                        {{-- 〜 の分 --}}
                        <div class="w-[10px]"></div>

                        {{-- 右inputの位置に textarea --}}
                        <textarea
                            class="w-[220px] border border-gray-200 rounded px-3 py-2 text-sm resize-none bg-gray-50 cursor-not-allowed"
                            rows="3"
                            readonly
                        >{{ $attendance->note ?? '' }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- 修正ボタン（外・右下・絶対黒） --}}
        <div class="w-[560px] mx-auto mt-6 flex justify-end">
            @if($pendingRequest)
                <span
                    style="
                        background:#9ca3af !important;
                        color:#fff !important;
                        font-weight:bold !important;
                        padding:10px 52px !important;
                        border-radius:4px !important;
                        box-shadow:0 2px 6px rgba(0,0,0,0.2) !important;
                        display:inline-block !important;
                        opacity:1 !important;
                        filter:none !important;
                        cursor:not-allowed !important;
                    "
                >
                    修正申請済み
                </span>
            @else
                <a href="{{ route('attendances.edit', $attendance) }}"
                   style="
                        background:#000 !important;
                        color:#fff !important;
                        font-weight:bold !important;
                        padding:10px 52px !important;
                        border-radius:4px !important;
                        border:none !important;
                        cursor:pointer !important;
                        box-shadow:0 2px 6px rgba(0,0,0,0.2) !important;
                        display:inline-block !important;
                        opacity:1 !important;
                        filter:none !important;
                    ">
                    修正
                </a>
            @endif
        </div>

    </div>
</x-app-layout>
