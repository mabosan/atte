<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
            Atte
            </a>
          <form class="form" action="/logout" method="post">
            @csrf
            <nav>
            <ul class="header-nav">
            @if (Auth::check())
            <li class="header-nav__item">
              <a class="header-nav__link" href="/">ホーム</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/attendance">日付一覧</a>
            </li>
            <li class="header-nav__item">
              <button class="header-nav__button">ログアウト</button>
            </li>
            @endif
            </ul>
            </nav>
          </form>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__inner">
            <a class="footer__logo" href="/">
            Atte,inc.
            </a>
        </div>
    </footer>
</body>

</html>