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

        <div class="buttons">
            @switch($status)

                @case('勤務外')
                    <form method="POST" action="/attendance/clock-in">
                        @csrf
                        <button class="btn primary">出勤</button>
                    </form>
                    @break

                @case('出勤中')
                    <form method="POST" action="/attendance/clock-out">
                        @csrf
                        <button class="btn primary">退勤</button>
                    </form>

                    <form method="POST" action="/attendance/break-start">
                        @csrf
                        <button class="btn secondary">休憩入</button>
                    </form>
                    @break

                @case('休憩中')
                    <form method="POST" action="/attendance/break-end">
                        @csrf
                        <button class="btn primary">休憩戻</button>
                    </form>
                    @break

                @case('退勤済')
                    <p class="done-message">お疲れさまでした。</p>
                    @break

            @endswitch
        </div>

    </div>
</main>

</body>
</html>

