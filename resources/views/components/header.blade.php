<header>
    <nav>
        <a href="{{ route('attendance.index') ?? '/attendance' }}">勤怠</a>
        <a href="/attendance/list">勤怠一覧</a>
        <a href="/stamp_correction_request/list">申請</a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    </nav>
    <hr>
</header>
