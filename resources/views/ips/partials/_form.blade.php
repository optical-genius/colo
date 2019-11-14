<!-- /resources/views/hosts/partials/_form.blade.php -->
<div class="form-horizontal">

	<div class="form-group">
		{!! Form::label('ip_name', 'IP:', array('class' => 'col-sm-3 control-label')) !!}
		<div class="col-sm-6">
			{!! Form::text('ip_name', null, ['class' => 'form-control']) !!}
		</div>
	</div>


	<div class="form-group" style="float:left; margin-top: 10px;">
		{!! Form::submit($submit_text, ['class' => 'btn btn-primary', 'name' => 'create']) !!}
	</div>

</div>
