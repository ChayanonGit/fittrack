@extends('shop.main')

@section('header')
@endsection

@section('content')
<section class="class-list-panel container">
	<div class="section-intro">
		<div class="intro-left">
			<h2 class="no-uppercase">Fitness Classes</h2>
			<p class="no-uppercase">เลือกคลาสที่เหมาะกับคุณ</p>
		</div>
	</div>

	<div class="class-cards">
		@foreach($class as $class)
			<article class="class-card">
				<div class="class-media">
					@if($class->img && file_exists(storage_path('app/public/img_class/' . $class->img)))
						<img src="{{ asset('storage/img_class/' . $class->img) }}" alt="{{ $class->name }}">
					@else
						<div class="class-media placeholder"></div>
					@endif
				</div>

				<div class="class-info">
					<h3 class="class-name no-uppercase">{{ $class->name }}</h3>
					<p class="class-desc no-uppercase">{{ $class->description ?? 'ไม่มีคำอธิบาย' }}</p>

					<div class="class-meta">
						<div class="meta-item">
							<span class="meta-label">ระยะเวลา:</span>
							<span class="meta-value">{{ $class->duration ?? '60' }} นาที</span>
						</div>
						<div class="meta-item">
							<span class="meta-label">ราคา:</span>
							<span class="meta-value">฿{{ number_format($class->price ?? 0, 2) }}</span>
						</div>
					</div>

					<div class="class-actions">
						<a href="{{ route('fitnessclass.create') }}" class="btn-cta">ลงทะเบียน</a>
					</div>
				</div>
			</article>
		@endforeach
	</div>
</section>
@endsection
