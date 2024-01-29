@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-widgets.static-widget :title="'Конкакты'" :value="$contact_count" :icon="'bx bx-user'" :route="route('contacts.customers')"/>
    </div>
    <div class="col-md-3">
        <x-widgets.static-widget :title="'Товары'" :value="$product_count" :icon="'bx bx-box'" :route="route('products.index')"/>
    </div>
</div>
@endsection
