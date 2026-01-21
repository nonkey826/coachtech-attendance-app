<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤怠打刻</title>
</head>
<body>
    <h1>勤怠打刻画面</h1>

    <p>現在の状態：{{ $status }}</p>

    @if ($attendance)
        <p>出勤時刻：{{ $attendance->clock_in_at ?? '-' }}</p>
        <p>退勤時刻：{{ $attendance->clock_out_at ?? '-' }}</p>
    @endif

    @if ($status === '勤務外')
    <form method="POST" action="/attendance/clock-in">
        @csrf
        <button type="submit">出勤</button>
    </form>
@endif


</body>
</html>
