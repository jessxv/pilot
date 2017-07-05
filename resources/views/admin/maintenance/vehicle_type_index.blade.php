@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Vehicle Type</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vtModal" style = "width: 100%;">New Vehicle Type</button>
		</div>
		<br>
		<br>
	</div>
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "vtype_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Description
							</td>
							<td>
								Created at
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>

		</div> 
	</div>

	<section class="content">
		<form role="form" method = "POST">
			{{ csrf_field() }}
			<div class="modal fade" id="vtModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Vehicle Type</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Description *</label>
								<input type = "text" class = "form-control" name = "description" id = "description" required />
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
	<section class="content">
		<form role = "form" method = "POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<div class="modal fade" id="confirm-delete" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Delete record
						</div>
						<div class="modal-body">
							Confirm Deleting
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
	@endsection
	@push('styles')
	<style>
		.class-vehicle-type{
			border-left: 10px solid #2ad4a5;
			background-color:rgba(128,128,128,0.1);
			color: #fff;
		}
		.maintenance
		{
			border-left: 10px solid #2ad4a5;
			background-color:rgba(128,128,128,0.1);
			color: #fff;
		}
	</style>
	@endpush
	@push('scripts')
	<script type="text/javascript">
		var data;
		$(document).ready(function(){
			var vtable = $('#vtype_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route("vt.data") }}',
				columns: [
				{ data: 'id' },
				{ data: 'description' },
				{ data: 'created_at'},
				{ data: 'action', orderable: false, searchable: false }

				]
			});
			$(document).on('click', '.new', function(e){
				resetErrors();
				$('.modal-title').text('New Vehicle Type');
				$('#description').val("");
				$('#vtModal').modal('show');

			});
			$(document).on('click', '.edit',function(e){
				resetErrors();
				var vt_id = $(this).val();
				data = vtable.row($(this).parents()).data();
				$('#description').val(data.description);
				$('.modal-title').text('Edit Vehicle Type');
				$('#vtModal').modal('show');
			});
			$(document).on('click', '.deactivate', function(e){
				var vt_id = $(this).val();
				data = vtable.row($(this).parents()).data();
				$('#confirm-delete').modal('show');
			});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/vehicletype/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			vtable.ajax.reload();
			$('#confirm-delete').modal('hide');

			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"rtl": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": 300,
				"hideDuration": 1000,
				"timeOut": 2000,
				"extendedTimeOut": 1000,
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			toastr["success"]("Record deactivated successfully")
		}
	})
});

// Confirm Save Button
$('#btnSave').on('click', function(e){
	e.preventDefault();
	var title = $('.modal-title').text();
	if(title == "New Vehicle Type")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/vehicletype',
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
			},
			success: function (data)
			{
				if(typeof(data) === "object"){
					vtable.ajax.reload();
					$('#vtModal').modal('hide');
					$('#description').val("");
					$('.modal-title').text('New Vehicle Type');

					//Show success

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Record addded successfully")
				}
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
	        var msg = '<label class="error" for="'+i+'">'+v+'</label>';
	        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
	    });
					
				}
			},
			
		})
	}
	else
	{
		$.ajax({
			type: 'PUT',
			url:  '/admin/vehicletype/' + data.id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
			},
			success: function (data)
			{
				toastr.options = {
					"closeButton": false,
					"debug": false,
					"newestOnTop": false,
					"progressBar": false,
					"rtl": false,
					"positionClass": "toast-bottom-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": 300,
					"hideDuration": 1000,
					"timeOut": 2000,
					"extendedTimeOut": 1000,
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}
				toastr["success"]("Record updated successfully")

				vtable.ajax.reload();
				$('#vtModal').modal('hide');
				$('#description').val("");
				$('.modal-title').text('New Vehicle Type');
			}
		})
	}
});

});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush