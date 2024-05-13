<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand mx-5" href="{{ route('dashboard') }}">Dashboard</a>

    <div id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
            </li>

            <li class="nav-item active {{ Route::currentRouteName() == 'transaction.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('transaction.index') }}">All Transaction</a>
            </li>

            <li class="nav-item {{ Route::currentRouteName() == 'transaction.deposit' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('transaction.deposit') }}">Deposit</a>
            </li>

            <li class="nav-item {{ Route::currentRouteName() == 'transaction.withdraw' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('transaction.withdraw') }}">Withdraw</a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    Log Out
                </a>
            </form>
            </li>
        </ul>
    </div>
</nav>
