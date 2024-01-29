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
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>ID</th>
									<th>Продукт</th>
									<th>Цена</th>
                                    <th>Кол-во</th>
									<th>Сегодня</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ nf($product->price) }}</td>
                                            <td>{{ nf($product->press_quantity) }} шт / {{ nf($product->press_quantity_kg) }} кг</td>

                                            <td>{{ nf(0) }}</td>
                                            <td>
                                                {{ Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) }}

												<a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
													<i class="bx bx-edit"></i>
												</a>

												{{ Form::button('<i class="bx bx-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger']) }}

												{{ Form::close() }}

                                            </td>
                                        </tr>
                                    @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
