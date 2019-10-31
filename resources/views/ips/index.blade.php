<!-- /resources/views/hosts/index.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
	<li><a href="{!! url('/'); !!}">Home</a></li>
	<li class="active">IP</li>
	</ul>

	<h2>IP</h2>
	<h4>Please make a selection of one of the following ip</h4>

	@if ( !$ips->count() )
		No ip found in the database!<br><br>
	@else
		<table class="table section-table dialog table-striped" border="1">

		<tr class="info">
			<td class="header">IP name</td>
            <td class="header">Hosts fot this IP</td>
			@if (Auth::check())
				 <td class="header" style="width: 190px;">Options</td>
			@endif
		</tr>

		@foreach( $ips as $ip )
			<tr>
				<td>{{ $ip->ip_name }}</td>
                <td>hosts...</td>
				<td>
					@if (Auth::check())
						{!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('ips.destroy', $ip->id), 'onsubmit' => 'return confirm(\'Are you sure to delete this hosts?\')')) !!}
                        {!! link_to_route('hosts.create', 'Host add', array('id' => $ip->id), array('class' => 'btn btn-info btn-xs')) !!}
						{!! link_to_route('ips.edit', 'Edit', array($ip->id), array('class' => 'btn btn-info btn-xs')) !!}
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
		<a href="{{ route('ips.create') }}">Create ip</a>
		</p>
	@endif

@endsection
