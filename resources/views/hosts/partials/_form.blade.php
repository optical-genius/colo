<!-- /resources/views/hosts/partials/_form.blade.php -->
<div class="form-horizontal">

	<div class="form-group">
		{!! Form::label('host_name', 'Host name:', array('class' => 'col-sm-3 control-label')) !!}
		<div class="col-sm-6">
			{!! Form::text('host_name', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('host_definition', 'Host definition:', array('class' => 'col-sm-3 control-label')) !!}
		<div class="col-sm-6">
			{!! Form::textarea('host_definition', null, ['class' => 'form-control', 'rows' => '4']) !!}
		</div>
	</div>
	
	<div class="form-group">
	@if (empty($host))
		{!! Form::label('relation_to_object', 'Link to object:', array('class' => 'col-sm-3 control-label')) !!}
		<div class="col-sm-6">
		<select name="object_id" class="form-control">
		<option value="0">select host</option>
		@foreach($hosts as $host)
			<option value="{{ $host->id }}">{{ $host->host_name }}</option>
		@endforeach
		</select>
		</div>
	@endif
	</div>

	<div class="form-group" style="float:left; margin-top: 10px;">
		{!! Form::submit($submit_text, ['class' => 'btn btn-primary', 'name' => 'create']) !!}
	</div>

</div>
