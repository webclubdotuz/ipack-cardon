@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/printjs/print.min.css') }}">
@endpush

@section('content')
	<x-breadcrumb :title="'Продажи'">
		<a href="#" class="btn btn-sm btn-primary btn-print">
			<i class="bx bx-printer"></i>
            Печать
		</a>
		<a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-plus"></i>
			Добавить
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
			<div class="card">
				<div class="card-body">
                    @livewire('sale.index')
				</div>
			</div>
		</div>
	</div>

@endsection

@push('js')

<script src="{{ asset('assets/plugins/printjs/print.min.js') }}"></script>
<script>

    $(document).ready(function() {
        // print
        $('.btn-print').click(function() {
            printJS({ printable: 'sales_table', type: 'html', targetStyles: ['*'] });
        })
    });
</script>
@endpush
