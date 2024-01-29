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
									<th>Поставщик</th>
									<th>Сумма</th>
									<th>Дата</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td>{{ $transaction->contact->fullname }}</td>
                                            <td>{{ nf($transaction->total) }}</td>
                                            <td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
											<td>
												<form action="" method="post">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-sm btn-danger">
														<i class="bx bx-trash"></i>
													</button>
												</form>
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
