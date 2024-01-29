@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Сырье продукции'">
		<a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-plus"></i>
			Добавить
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
			<div class="card">
				<div class="card-body">
					@livewire('press.index')
				</div>
			</div>
		</div>
	</div>

@endsection
