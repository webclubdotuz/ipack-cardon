@extends('layouts.main')
@push('css')
    <!--plugins-->
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
    <x-breadcrumb :title="$user->fullname">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-list-ul"></i>
            Список
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><b>ФИО</b></td>
                        <td>{{ $user->fullname }}</td>
                        <td><b>Телефон</b></td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td><b>Логин</b></td>
                        <td>{{ $user->username }}</td>
                        <td><b>Роль</b></td>
                        <td>{{ $user->roles->implode('name', ', ') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <b>Попупки баланс</b> {{ nf($user->balance) }} сум <br>
                            <b>Зарплата баланс</b> {{ nf($user->salary_balance) }} сум <button class="btn btn-sm btn-primary" onclick="openSalary({{$user->id}})">Выплатить</button> <br>
                            <b>Пресс баланс</b> {{ nf($user->press_balance) }} сум <br>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            @include('components.alert')
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-tab.nav>
                        <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'" />
                        <x-tab.li :id="'press'" :title="'Пресс'" :icon="'bx bx-layer'" />
                        <x-tab.li :id="'sales'" :title="'Продажи'" :icon="'bx bx-cart'" />
                        <x-tab.li :id="'sales_salary'" :title="'Продажи зарплаты'" :icon="'bx bx-money'" />
                        {{-- <x-tab.li :id="'press_salary'" :title="'Пресс зарплаты'" :icon="'bx bx-money'" /> --}}
                        <x-tab.li :id="'expenses'" :title="'Расходы'" :icon="'bx bx-money'" />
                        <x-tab.li :id="'salary'" :title="'Зарплаты расходы'" :icon="'bx bx-money'" />
                    </x-tab.nav>

                    <div class="tab-content py-3">
                        <x-tab.content :id="'purchases'" :active="true">
                            @livewire('user.purchase', ['user' => $user])
                        </x-tab.content>
                        {{-- <x-tab.content :id="'press'">
                            @livewire('user.press', ['user' => $user])
                        </x-tab.content> --}}
                        <x-tab.content :id="'sales'">
                            @livewire('user.sale', ['user' => $user])
                        </x-tab.content>
                        <x-tab.content :id="'sales_salary'">
                            @livewire('user.sale-salary', ['user' => $user])
                        </x-tab.content>
                        {{-- <x-tab.content :id="'press_salary'">
                            @livewire('user.pres-user', ['user' => $user])
                        </x-tab.content> --}}
                        <x-tab.content :id="'expenses'">
                            @livewire('user.expense', ['user' => $user])
                        </x-tab.content>
                        <x-tab.content :id="'salary'">
                            @livewire('user.salary', ['user' => $user])
                        </x-tab.content>
                    </div>
                </div>
            </div>
        </div>

        @livewire('transaction.payment')
        @livewire('transaction.change-status')
        @livewire('transaction.show')
        @livewire('salary.create')
    </div>
@endsection

@push('js')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>

    <script>
        function openSalary(id) {
            Livewire.dispatch('openModalSalary', {
                user_id: id
            });
        }
    </script>
@endpush
