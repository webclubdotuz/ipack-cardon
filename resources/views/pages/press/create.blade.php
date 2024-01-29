@extends('layouts.main')
@push('css')

	<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
	<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet"/>
@endpush
@section('content')
	<x-breadcrumb :title="'Добавить пресс'">
		<a href="{{ route('press.index') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-list-ul"></i>
			Список прессов
		</a>
	</x-breadcrumb>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					@livewire('press.create')
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					@livewire('press.index')
				</div>
			</div>
		</div>
	</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
@endpush
