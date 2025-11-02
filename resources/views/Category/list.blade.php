@extends('layouts.main')

@section('header')
@endsection

@section('content')
<section class="category-list container">
	{{-- header with add button --}}
	<div class="section-intro" style="padding:6px 0;">
		<div class="intro-left">
			<h2 class="category-list-title">Categories</h2>
		</div>
		<div class="intro-right">
			<a href="{{ route('category.create') }}" class="btn-cta">เพิ่มหมวดหมู่</a>
		</div>
	</div>

	<div class="category-grid">
		@foreach($category as $category)
			<article class="category-card">
				<div class="category-media">
					@if($category->img && file_exists(storage_path('app/public/img_category/' . $category->img)))
						<img src="{{ asset('storage/img_category/' . $category->img) }}" alt="{{ $category->name }}">
					@else
						<div class="category-placeholder"></div>
					@endif
				</div>

				<div class="category-meta">
					<h3 class="category-name">{{ $category->name }}</h3>
					<p class="category-desc">{{ Str::limit($category->description ?? '', 100) }}</p>
				</div>

				{{-- updated actions: view / edit / delete --}}
				<div class="category-actions">
					<a href="{{ route('category.list', $category->id) }}" class="btn-view">View</a>

					{{-- Edit --}}
					<a href="{{ route('category.update-form', ['category' => $category->code]) }}" class="btn-edit">Edit</a>
                    
					{{-- Delete (real DELETE request) --}}
					
                    <a href="{{ route('category.delete', ['category' => $category->code]) }}" class="btn-delete">delete</a>
				</div>
			</article>
		@endforeach
	</div>
</section>
@endsection
