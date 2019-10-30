<!-- /resources/views/hosts/edit.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
		<li><a href="{!! url('/'); !!}">Home</a></li>
		<li><a href="{!! url('/hosts/'); !!}">Hosts</a></li>
		<li class="active">{{ $host->host_name }}</li>
	</ul>

	<h2>Edit Host</h2>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif

	{!! Form::model($host, ['method' => 'PATCH', 'route' => ['hosts.update', $host->id]]) !!}
	@include('hosts/partials/_form', ['submit_text' => 'Edit Host', 'propose_text' => 'Propose Host'])
	{!! Form::close() !!}
@endsection
