@extends('users.main')

@section('header')
<style>
	/* toolbar spacing + remove bullets */
	.user-toolbar { 
		display:flex; 
		gap:12px; 
		align-items:center; 
		margin: 16px auto 10px; 
		padding:0; 
		list-style:none; 
		max-width:900px; 
	}
	.user-toolbar li { list-style:none; }
	
	/* Back button matches theme */
	.btn-back {
		display:inline-flex; 
		align-items:center; 
		gap:8px;
		padding: 10px 18px; 
		border-radius: 28px;
		background: #edd8c5;
		color: #73513d;
		font-weight:700;
		text-decoration:none;
		box-shadow: 0 8px 22px rgba(115,81,61,0.06);
		border: none;
		transition: transform .12s ease, box-shadow .12s ease;
	}
	.btn-back:hover { 
		transform: translateY(-3px); 
		box-shadow: 0 14px 34px rgba(115,81,61,0.08); 
	}
	.btn-back .arrow { font-weight:900; }
	
	/* Update button */
	.user-toolbar .btn-cta { padding:10px 18px; }
	
	/* Delete button */
	.user-toolbar .btn-danger {
		background:#fff; 
		border:1px solid rgba(255,77,77,0.18); 
		color:#c0392b; 
		border-radius:12px; 
		padding:10px 16px; 
		font-weight:800;
		cursor:pointer;
		transition: transform .12s ease, box-shadow .12s ease;
	}
	.user-toolbar .btn-danger:hover { 
		transform: translateY(-2px); 
		box-shadow:0 12px 24px rgba(192,57,43,.08); 
	}
	
	/* User card */
	.user-detail-card {
		max-width:900px;
		margin:0 auto;
		background:#fff;
		border-radius:14px;
		box-shadow:0 18px 40px rgba(16,24,40,0.06);
		padding:22px;
	}
	
	/* Avatar + header */
	.user-header {
		display:flex;
		align-items:center;
		gap:16px;
		flex-wrap:wrap;
		padding-bottom:16px;
		border-bottom:1px solid rgba(186,162,146,0.18);
		margin-bottom:16px;
	}
	.user-avatar {
		width:80px;
		height:80px;
		border-radius:50%;
		background:linear-gradient(180deg,#efd9c5,#e6c8ad);
		color:#6b4a35;
		display:flex;
		align-items:center;
		justify-content:center;
		font-weight:800;
		font-size:1.6rem;
		box-shadow:0 10px 22px rgba(16,24,40,0.06);
	}
	.user-info h2 {
		margin:0;
		color:#7a5a42;
		text-transform:none;
	}
	.user-badges {
		display:flex;
		gap:10px;
		align-items:center;
		flex-wrap:wrap;
		margin-top:6px;
	}
	
	/* Detail table */
	.user-detail-table {
		width:100%;
		border-collapse:collapse;
	}
	.user-detail-table tbody tr {
		border-bottom:1px solid rgba(186,162,146,0.10);
	}
	.user-detail-table tbody tr:last-child {
		border-bottom:none;
	}
	.user-detail-table td {
		padding:12px 8px;
		vertical-align:top;
	}
	.user-detail-table td:first-child {
		font-weight:700;
		color:#9c7a56;
		width:180px;
		text-transform:uppercase;
		letter-spacing:.04em;
	}
	.user-detail-table td:last-child {
		color:#6f5846;
	}
</style>

<nav>
	<form action="{{ route('users.delete', ['user' => $users->email]) }}" method="post" id="app-form-delete">
		@csrf
	</form>

	<ul class="user-toolbar">
		<li>
			<a href="{{ session()->get('bookmarks.users.view' ,route('users.list')) }}" class="btn-back">
				<span class="arrow">&larr;</span> Back
			</a>
		</li>

		<li>
			<a href="{{ route('users.update-form', ['user' => $users->email]) }}" class="btn-cta">Update</a>
		</li>

		@can('delete', $users)
		<li>
			<button type="submit" form="app-form-delete" class="btn-danger">Delete</button>
		</li>
		@endcan
	</ul>
</nav>
@endsection

@section('content')
<div class="user-detail-card">
	<div class="user-header">
		<div class="user-avatar">
			{{ strtoupper(mb_substr($users->name ?: $users->email, 0, 1)) }}
		</div>
		<div class="user-info">
			<h2 class="no-uppercase">{{ $users->name }}</h2>
			<div class="user-badges">
				<span class="app-cl-code">{{ $users->email }}</span>
				<span class="app-cl-code">{{ strtoupper($users->role) }}</span>
			</div>
		</div>
	</div>

	<table class="user-detail-table">
		<tbody>
			<tr>
				<td>Email</td>
				<td><span class="no-uppercase">{{ $users->email }}</span></td>
			</tr>
			<tr>
				<td>Name</td>
				<td class="no-uppercase">{{ $users->name }}</td>
			</tr>
			<tr>
				<td>Role</td>
				<td><span class="no-uppercase">{{ strtoupper($users->role) }}</span></td>
			</tr>
		</tbody>
	</table>
</div>

<pre></pre>
@endsection