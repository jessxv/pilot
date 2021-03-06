@extends('layouts.app')

@section('content')
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h2>View Contract</h2>
				<hr />
			</div>
			<div class = "panel-body">
				<h3>Contract Information</h3>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="control-label col-sm-4" for="contactNumber">Contract #:</label>
						<label class="control-label col-sm-5" for="address" style = "text-align: left;">{{ $contract->id }}</label>
					</div>
					<div class="form-group">        
						<label class="control-label col-sm-4" for="contactNumber">Date Effective:</label>
						<label class="control-label col-sm-5" for="address" style = "text-align: left;">{{ $contract->dateEffective }}</label>
					</div>
					<div class="form-group">        
						<label class="control-label col-sm-4" for="contactNumber">Date Expiration:</label>
						<label class="control-label col-sm-5" for="address" style = "text-align: left;">{{ $contract->dateExpiration }}, ({{ Carbon\Carbon::parse($contract->dateExpiration)->diffForHumans() }})</label>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<h3>Contract Rates</h3>
				<table class = "table table-striped table-responsive">
					<thead>
						<tr>
							<td>
								<h4>From</h4>
							</td>
							<td>
								<h4>To</h4>
							</td>
							<td>
								<h4>Amount</h4>
							</td>
						</tr>
					</thead>
					@forelse($contract_details as $contract_detail)
					<tr>
						<td>
							{{ $contract_detail->from }}
						</td>
						<td>
							{{ $contract_detail->to }}
						</td>
						<td>
							{{ $contract_detail->amount }}
						</td>

					</tr>
					@empty
					<tr>
						<td colspan="3">
							<h5 style="text-align: center;">No records available.</h5>
						</td>
					</tr>
					@endforelse
				</table>
			</div>
		</div>
	</div>
</div>

<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<h3>Contract Details</h3>
				@if($contract->specificDetails == null)
				<h5 style="text-align: center;">No specified details</h5>
				@else
				<p>{{ $contract->specificDetails }}</p>

				@endif
			</div>
		</div>
	</div>
</div>

@endsection
@push('styles')
<style>
.contracts
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush