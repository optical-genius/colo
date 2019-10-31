<!-- /resources/views/hosts/edit.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
		<li><a href="{!! url('/'); !!}">Home</a></li>
		<li><a href="{!! url('/ips/'); !!}">IP</a></li>
		<li class="active">{{ $ip->ip_name }}</li>
	</ul>

	<h2>Edit IP</h2>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif

	{!! Form::model($ip, ['method' => 'PATCH', 'route' => ['ips.update', $ip->id]]) !!}
	@include('ips/partials/_form', ['submit_text' => 'Edit IP', 'propose_text' => 'Propose IP'])
	{!! Form::close() !!}
@endsection
