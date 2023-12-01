@if (Auth::check())
    {{-- タスクリストページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('tasks.index') }}">Task</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- タスクリストページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('tasks.index') }}">Task</a></li>
    {{-- ユーザ登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">Signup</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
@endif