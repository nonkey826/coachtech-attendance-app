<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤怠打刻</title>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>
<body>

@include('components.header')

<main class="main">
    <div class="card">

        <p class="status-label">{{ $status }}</p>

        <p class="date">{{ now()->format('Y年n月j日（D）') }}</p>
        <p class="time">{{ now()->format('H:i') }}</p>

        @switch($status)

            @case('勤務外')
                <div class="buttons">
                    <form method="POST" action="/attendance/clock-in">
                        @csrf
                        <button class="btn primary">出勤</button>
                    </form>
                </div>
                @break

            @case('出勤中')
                <div class="buttons">
                    <form method="POST" action="/attendance/clock-out">
                        @csrf
                        <button class="btn primary">退勤</button>
                    </form>

                    <form method="POST" action="/attendance/break-start">
                        @csrf
                        <button class="btn secondary">休憩入</button>
                    </form>
                </div>
                @break

            @case('休憩中')
                <div class="buttons">
                    <form method="POST" action="/attendance/break-end">
                        @csrf
                        <button class="btn primary">休憩戻</button>
                    </form>

                    {{-- ✅ 休憩中も退勤できるなら追加（おすすめ） --}}
                    <form method="POST" action="/attendance/clock-out">
                        @csrf
                        <button class="btn secondary">退勤</button>
                    </form>
                </div>
                @break

            @case('退勤済')
                <p class="done-message">✅ お疲れさまでした。</p>
                @break

        @endswitch

    </div>
</main>

</body>
</html>
