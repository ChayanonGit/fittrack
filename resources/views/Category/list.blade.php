@extends('layouts.main')

@section('header')
	<link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
@endsection

@section('content')
	<h2>Category</h2>
	<a href="{{ route('category.create') }}" class="new-class-btn">+ New Category</a>

	<div class="cg-data-list">
		<table>
			<thead>
				<tr>
					<th>Image</th>
					<th>Code</th>
					<th>Name</th>
					<th>Desc.</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($category as $categorys)
					<tr>
						<td>
							@if ($categorys->img)
								<img src="{{ asset('storage/img_cat/' . $categorys->img) }}" alt="{{ $categorys->name }}" width="100">
							@else
								<div ></div>
							@endif
						</td>
						<td>{{ $categorys->code }}</td>
						<td>{{ $categorys->name }}</td>
						<td>{{ Str::limit($categorys->description ?? '', 100) }}</td>
						<td>
							<a href="{{ route('category.view-product', ['category' => $categorys->code]) }}">Detail</a>
							<a href="{{ route('category.update-form', ['category' => $categorys->code]) }}">Edit</a>
							<a href="{{ route('category.delete', ['category' => $categorys->code]) }}">Delete</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

    
        <div class="category-grid">
            @foreach ($category as $categorys)
                <article class="category-card">
                    <div class="category-media">
                        @if ($categorys->img)
                            <img src="{{ asset('storage/img_cat/' . $categorys->img) }}" alt="{{ $categorys->name }}">
                        @else
                            <div class="category-placeholder"></div>
                        @endif
                    </div>
                    <div class="cg-data-list">


                        <div class="category-meta">
                            <h3 class="category-name">{{ $categorys->code }}</h3>
                            <h3 class="category-name ">{{ $categorys->name }}</h3>
                            <p class="category-desc">
                                {{ Str::limit($categorys->description ?? '', 100) }}</p>
                        </div>

                        {{-- updated actions: view / edit / delete --}}
                        <div class="category-actions">
                            <a href="{{ route('category.view-product', ['category' => $categorys->code]) }}"
                                class="btn-view">Detail</a>

                            {{-- Edit --}}
                            <a href="{{ route('category.update-form', ['category' => $categorys->code]) }}"
                                class="btn-edit">Edit</a>

                            {{-- Delete (real DELETE request) --}}


                            <a href="{{ route('category.delete', ['category' => $categorys->code]) }}" class="btn-delete"
                                data-name="{{ $categorys->name }}">
                                Delete
                            </a>
                        </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
