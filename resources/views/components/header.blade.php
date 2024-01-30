<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <div class="dropdown open">
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class='bx bx-down-arrow-circle'></i> Покупки
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="btn btn-success btn-sm m-1" href="{{ route('purchases.create') }}">
                                    <i class='bx bx-down-arrow-circle'></i> Продукты
                                </a>
                                <a class="btn btn-success btn-sm m-1" href="{{ route('rolls.create') }}">
                                    <i class='bx bx-down-arrow-circle'></i> Рулоны
                                </a>
                            </div>
                        </div>

                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm m-1" href="{{ route('sales.create') }}">
                            <i class='bx bx-up-arrow-circle'></i> Продажи
                        </a>
                    </li>
                </ul>
            </div>
            @auth
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/assets/images/avatar.png" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->fullname }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->roles?->first()?->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <h6 class="dropdown-header">
                        <?php $user_balance = Auth::user()->balance; ?>
                        Баланс: <br><span class="{{ $user_balance < 0 ? 'text-danger' : 'text-success' }}">{{ nf(Auth::user()->balance) }} сум</span>
                        </h6>

                    </li>

                    <li><a class="dropdown-item" href="{{ route('users.my-profile') }}"><i class="bx bx-user"></i><span>Profile</span></a></li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class='bx bx-log-out-circle'></i><span>Выход</span></a></li>
                </ul>
            </div>
            @endauth
        </nav>
    </div>
</header>
