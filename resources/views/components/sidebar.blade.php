<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Cardon</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="/">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Главная</div>
            </a>
        </li>
        <li>
            <a href="{{ route('requests.index') }}">
                <div class="parent-icon"><i class='bx bx-list-ul'></i>
                </div>
                <div class="menu-title">Заявки</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='lni lni-users'></i>
                </div>
                <div class="menu-title">Контакты</div>
            </a>
            <ul>
                <li><a href="{{ route('contacts.customers') }}"><i class="lni lni-users"></i> Клиенты</a>
                <li><a href="{{ route('contacts.suppliers') }}"><i class="lni lni-users"></i> Поставщики</a>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='lni lni-dropbox-original'></i>
                </div>
                <div class="menu-title">Склад</div>
            </a>
            <ul>
                <li><a href="{{ route('products.index') }}"><i class="lni lni-bricks"></i>Сырье</a>
                <li><a href="{{ route('rolls.index') }}"><i class="lni lni-paperclip"></i>Рулоны</a>
                <li><a href="{{ route('cardons.index') }}"><i class="lni lni-dropbox-original"></i>Каровки</a>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-minus-circle'></i>
                </div>
                <div class="menu-title">Расходы</div>
            </a>
            <ul>
                <li><a href="{{ route('expenses.create') }}"><i class="bx bx-plus"></i> Добавить расход</a>
                <li><a href="{{ route('expenses.index') }}"><i class="bx bx-list-plus"></i> Список расходов</a>
                <li><a href="{{ route('expense-categories.index') }}"><i class="bx bx-list-plus"></i> Расходные категории</a>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-down-arrow-circle'></i>
                </div>
                <div class="menu-title">Покупки</div>
            </a>
            <ul>
                <li><a href="{{ route('purchases.index') }}"><i class="bx bx-list-plus"></i> Список покупок</a>
                <li><a href="{{ route('purchases.create') }}"><i class="bx bx-plus"></i> Добавить покупку</a>
                <li><a href="{{ route('rolls.create') }}"><i class="bx bx-plus"></i> Добавить рулон</a>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-up-arrow-circle'></i>
                </div>
                {{-- manufactures --}}
                <div class="menu-title">Производство</div>
            </a>
            <ul>
                <li><a href="{{ route('manufactures.index') }}"><i class="bx bx-list-plus"></i> Список производств</a>
                <li><a href="{{ route('manufactures.create') }}"><i class="bx bx-plus"></i> Добавить производство</a>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-up-arrow-circle'></i>
                </div>
                <div class="menu-title">Продажи</div>
            </a>
            <ul>
                <li><a href="{{ route('sales.index') }}"><i class="bx bx-list-plus"></i> Список продаж</a>
                <li><a href="{{ route('sales.create') }}"><i class="bx bx-plus"></i> Добавить продажу</a>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-chart'></i>
                </div>
                <div class="menu-title">Отчеты</div>
            </a>
            <ul>
                <li><a href="{{ route('reports.opiu') }}"><i class="bx bx-chart"></i> ОПиУ и Вал.прибыль</a></li>
                <li><a href="{{ route('reports.odds') }}"><i class="bx bx-chart"></i> ОДДС</a></li>
                <li><a href="{{ route('reports.daxod') }}"><i class="bx bx-chart"></i> Доходы</a></li>
                <li><a href="{{ route('reports.expense') }}"><i class="bx bx-chart"></i> Расходы</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Администрирование</div>
            </a>
            <ul>
                <li><a href="{{ route('users.index') }}"><i class="bx bx-user"></i> Пользователи</a>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
