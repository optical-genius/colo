<!-- /resources/views/hosts/index.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
	<li><a href="{!! url('/'); !!}">Home</a></li>
	<li class="active">Hosts</li>
	</ul>

	<h2>Hosts</h2>
	<h4>Please make a selection of one of the following hosts</h4>

	@if ( !$hosts->count() )
		No hosts found in the database!<br><br>
	@else
		<table class="table section-table dialog table-striped" border="1">

		<tr class="info">
			<td class="header">Host name</td>
			<td class="header">Host definition</td>
			@if (Auth::check())
				 <td class="header" style="width: 190px;">Options</td>
			@endif
		</tr>

		@foreach( $hosts as $host )
			<tr>
				<td>{{ $host->host_name }}</td>
				<td>{{ $host->host_definition }}</td>
				<td>
					@if (Auth::check())
						{!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('hosts.destroy', $host->id), 'onsubmit' => 'return confirm(\'Are you sure to delete this hosts?\')')) !!}
						{!! link_to_route('hosts.edit', 'Edit', array($host->id), array('class' => 'btn btn-info btn-xs')) !!}
						{!! Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'style' => 'margin-left:3px;')) !!}
						{!! Form::close() !!}
					@endcan
				</td>
			</tr>
		@endforeach

		</table>
	@endif

	@if (Auth::check())
		<p>
		<a href="{{ route('hosts.create') }}">Create host</a>
		</p>
	@endif

@endsection
