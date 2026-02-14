<x-app-layout>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-lg font-bold text-gray-800 mb-6">申請一覧</h1>

        <div class="mb-6 border-b">
    <div class="flex gap-8 text-sm font-bold text-gray-700">
        <a href="/stamp_correction_request/list?status=pending"
           class="pb-3 border-b-2 border-black">
            承認待ち
        </a>

        <a href="/stamp_correction_request/list?status=approved"
           class="pb-3 text-gray-400">
            承認済み
        </a>
    </div>
</div>


        <div class="bg-white rounded shadow p-4">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b text-gray-600">
                    <th class="py-3 text-left">状態</th>
                    <th class="py-3 text-left">名前</th>
                    <th class="py-3 text-left">対象日時</th>
                    <th class="py-3 text-left">申請理由</th>
                    <th class="py-3 text-left">申請日時</th>
                    <th class="py-3 text-left">詳細</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($requests as $request)

                    @php
                        $statusLabel = match ($request->status) {
                            'pending' => '承認待ち',
                            'approved' => '承認済み',
                            'rejected' => '却下',
                            default => $request->status,
                        };
                    @endphp

                    <tr class="border-b">
                        <td class="py-3">{{ $statusLabel }}</td>

                        <td class="py-3">
    {{ $request->attendance?->user?->name ?? '-' }}
</td>


                        <td class="py-3">
                            @if($request->attendance?->date)
                                {{ \Carbon\Carbon::parse($request->attendance->date)->format('Y/m/d') }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="py-3">
                            {{ $request->reason ?? '-' }}
                        </td>

                        <td class="py-3">
                            {{ $request->created_at?->format('Y/m/d') }}
                        </td>

                        <td class="py-3">
                            @if($request->attendance_id)
                                <a href="/attendance/detail/{{ $request->attendance_id }}"
                                   class="text-blue-600 font-bold">
                                    詳細
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

