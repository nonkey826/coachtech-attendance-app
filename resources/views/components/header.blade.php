<header class="header">
    <div class="logo">COACHTECH</div>

    <nav class="nav">
        @auth
            <a href="{{ route('attendance.index') }}">勤怠</a>
            <a href="{{ route('dashboard') }}">ダッシュボード</a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn">ログアウト</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">会員登録</a>
        @endguest
    </nav>
</header>
