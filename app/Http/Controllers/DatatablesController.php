<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\service_order_type;
use App\VehicleType;
use App\Charge;
use App\Brokerage_status_type;
use App\ContainerType;
use App\ExchangeRate;
use App\ReceiveType;
use App\EmployeeType;
use App\Consignee;
use App\Vehicle;
use App\Billing;
use App\Area;
use App\CdsFee;
use App\IpfFee;
use App\BrokerageFee;
use App\ConsigneeServiceOrderHeader;
use App\BrokerageServiceOrderDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatatablesController extends Controller
{
	public function vt_datatable(){
		$vtypes = VehicleType::select(['id', 'description', 'created_at']);

		return Datatables::of($vtypes)
		->addColumn('action', function ($vtype) {
			return
			'<button value = "'. $vtype->id .'" style="margin-right:10px;" class="btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $vtype->id .'" class="btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{$id}}')
		->make(true);
	}
	public function sot_datatable(){
		$sots = service_order_type::select(['id', 'description', 'created_at']);
		
		return Datatables::of($sots)
		->addColumn('action', function ($sot){
			return
			'<button value = "'. $sot->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $sot->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ch_datatable(){
		$charges = Charge::select(['id', 'description','created_at']);
		
		return Datatables::of($charges)
		->addColumn('action', function ($ch){
			return
			'<button value = "'. $ch->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $ch->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function bst_datatable(){
		$bst = Brokerage_status_type::select(['id', 'description', 'created_at']);
		
		return Datatables::of($bst)
		->addColumn('action', function ($bs){
			return
			'<button value = "'. $bs->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $bs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ct_datatable(){
		$cts = ContainerType::select(['id', 'description', 'created_at']);
		
		return Datatables::of($cts)
		->addColumn('action', function ($ct){
			return
			'<button value = "'. $ct->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $ct->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function er_datatable(){
		$ers = ExchangeRate::select(['id', 'description', 'rate', 'dateEffective', 'created_at']);
		
		return Datatables::of($ers)
		->addColumn('action', function ($er){
			return
			'<button value = "'. $er->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $er->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function rt_datatable(){
		$rts = ReceiveType::select(['id', 'description', 'created_at']);
		
		return Datatables::of($rts)
		->addColumn('action', function ($rt){
			return
			'<button value = "'. $rt->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $rt->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function et_datatable(){
		$ets = EmployeeType::select(['id', 'description', 'created_at']);
		
		return Datatables::of($ets)
		->addColumn('action', function ($et){
			return
			'<button value = "'. $et->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $et->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function consignee_datatable(){
		$consignees = consignee::select(['id', 'firstName', 'middleName','lastName','companyName', 'email', 'contactNumber','created_at']);

		return Datatables::of($consignees)
		
		->editColumn('firstName', '{{ $firstName . " " .$middleName . " ". $lastName }}')
		->removeColumn('middleName')
		->removeColumn('lastName')
		->addColumn('action', function ($consignee){
			return
			'<button value = "'. $consignee->id .'" class = "btn btn-md btn-primary selectConsignee ">Select</button>';
		})
		->editColumn('consigneeType', function($consignee){
			if( $consignee->consigneeType == 0){
				return 'Walk-in';
			}
			else{
				return 'Regular';
			}
		})
		->make(true);
	}
	public function v_datatable(){
		$vs = Vehicle::select(['vehicle_types_id', 'plateNumber', 'model','dateRegistered', 'created_at']);

		return Datatables::of($vs)
		->addColumn('action', function ($v) {
			return
			'<button value = "'. $v->plateNumber .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $v->plateNumber .'" style="width:100;" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->make(true);
	}
	public function so_head_datatable(){
		$so_heads = DB::table('consignee_service_order_headers')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('consignee_service_order_headers.id', 'companyName', 'paymentStatus', 'consignee_service_order_headers.created_at')
		->get();
		return Datatables::of($so_heads)
		->addColumn('action', function ($so_head) {
			return
			'<button value = "'. $so_head->id .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-info selectConsignee">Select</button>';
		})
		->make(true);
	}
	public function sorder_datatable(){
		$sorders = DB::table('consignee_service_order_headers')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->leftjoin('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id','companyName', 'paymentStatus')
		->get();

		return Datatables::of($sorders)
		->addColumn('action', function ($sorder) {
			return
			'<button value = "'. $sorder->id .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-info selectCon">Select</button>';
		})
		->make(true);
	}

	/*select companyName, bd.amount, rc.amount from billings as b left join billing_invoice_details as bd on b.id = bd.billings_id left join billing_invoice_headers as bh on bd.bi_head_id = bh.id left join consignee_service_order_headers as ch on bh.so_head_id = ch.id left join refundable_charges as rc on ch.id = rc.so_head_id left join consignees as c on ch.consignees_id = c.id*/
	public function payment_so_datatable(Request $request){
		$pso_heads = DB::table('billings')
		->leftjoin('billing_invoice_details', 'billings.id', '=', 'billing_invoice_details.billings_id')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->leftjoin('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('billing_invoice_headers.id','description', DB::raw('CONCAT(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100)) as Total'))
		->where('billing_invoice_headers.so_head_id','=',$request->id)
		->get();


		return Datatables::of($pso_heads)
		->make(true);
	}
	public function totbill_datatable(Request $request){
		$totbillamt = DB::table('billing_invoice_details')
		->select('id', DB::raw('CONCAT(SUM(amount-(amount*discount/100)))as Total'))
		->where('bi_head_id', '=', $request->id)
		->get();
		return Datatables::of($totbillamt)
		->addColumn('action', function ($billamt) {
			return
			'<button value = "'. $billamt->id .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-info selectTotBill">Select</button>';
		})
		->make(true);
	}
	public function rc_datatable(Request $request){
		$rc_heads = DB::table('refundable_charges')
		->leftjoin('consignee_service_order_headers', 'refundable_charges.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('consignee_service_order_headers.id','description', DB::raw('CONCAT(refundable_charges.amount) as TotalRC'))
		->where('refundable_charges.so_head_id','=',$request->id)
		->get();


		return Datatables::of($rc_heads)
		->make(true);
	}
	public function totrc_datatable(Request $request){
		$totrc = DB::table('refundable_charges')
		->select('id', DB::raw('CONCAT(SUM(amount))as Total'))
		->where('so_head_id', '=', $request->id)
		->get();
		return Datatables::of($totrc)
		->addColumn('action', function ($rcamt) {
			return
			'<button value = "'. $rcamt->id .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-info selectTotRC">Select</button>';
		})
		->make(true);
	}
	public function bill_datatable(){
		$bills = Billing::select(['id', 'description', 'created_at']);

		return Datatables::of($bills)
		->addColumn('action', function ($bil){
			return
			'<button value = "'. $bil->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $bil->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}
	//select bso.created_at, ch.id, CONCAT(e.firstName,' ', e.lastName) as Employee, companyName, supplier, CONCAT(ct.description,' ', containerNumber) as CONTRS,docking,awb, deposit from brokerage_service_orders as bso left join consignee_service_order_headers as ch on bso.consigneeSODetails_id = ch.id left join employees as e on ch.employees_id = e.id left join container_types as ct on bso.containerType_id = ct.id left join consignees as c on ch.consignees_id = c.id
	public function shipment_datatable(){
		$shipments = DB::table('brokerage_service_orders')
		->leftjoin('consignee_service_order_headers', 'brokerage_service_orders.consigneeSODetails_id','=', 'consignee_service_order_headers.id')
		->leftjoin('employees','consignee_service_order_headers.employees_id','=','employees.id')
		->leftjoin('container_types','brokerage_service_orders.containerType_id', '=','container_types.id')
		->leftjoin('consignees','consignee_service_order_headers.consignees_id','=','consignees.id')
		->select('brokerage_service_orders.created_at','consignee_service_order_headers.id',DB::raw('CONCAT(employees.firstName, employees.lastName) as Employee'), 'companyName', 'supplier', DB::raw('CONCAT(container_types.description,  containerNumber) as CONTRS'), 'docking', 'awb', 'deposit')
		->orderBy('brokerage_service_orders.created_at')
		->groupBy(DB::raw('MONTH(brokerage_service_orders.created_at)'))
		->get();
		return Datatables::of($shipments)
		->make(true);
	}

	public function ar_datatable(){
		$ars = Area::select(['id', 'description', 'created_at']);
		
		return Datatables::of($ars)
		->addColumn('action', function ($ar){
			return
			'<button value = "'. $ar->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $ar->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function bl_datatable(){
		$bills = Billing::select(['id', 'description', 'created_at']);
		
		return Datatables::of($bills)
		->addColumn('action', function ($bill){
			return
			'<button value = "'. $bill->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $bill->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function bf_datatable(){
		$bfs = BrokerageFee::select(['id', 'minimum', 'maximum', 'amount', 'created_at']);
		
		return Datatables::of($bfs)
		->addColumn('action', function ($bf){
			return
			'<button value = "'. $bf->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $bf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function contracts_datatable(){
		$contract_headers = DB::table('contract_headers')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'companyName', 'contract_headers.created_at')
		->whereRaw('NOW() BETWEEN dateEffective AND dateExpiration')
		->get();
		return Datatables::of($contract_headers)
		->addColumn('action', function ($contract_header){
			return
			'<button value = "'. $contract_header->id .'" class = "btn btn-md btn-primary view-contract-details">View</button>' . 
			'<button value = "'. $contract_header->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function employees_datatable(){
		$employees = DB::table('employees')
		->select('employees.id', 'firstName', 'middleName', 'lastName','employees.created_at')
		->where('deleted_at', '=', null)
		->get();
		return Datatables::of($employees)
		->addColumn('action', function ($employee){
			return
			'<a href = "/utilities/employee/' . $employee->id . '/view" class = "btn btn-info btn-md">View</a>' . 
			'<button value = "'. $employee->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $employee->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function emp_role_datatable(Request $request){
		$id = $request->employee_id;
		$employee_roles = DB::table('employee_roles')
		->join('employees', 'employee_id', '=', 'employees.id')
		->join('employee_types', 'employee_type_id', '=', 'employee_types.id')
		->select('employee_roles.id', 'description','employee_roles.created_at')
		->where('employee_id', '=', $id)
		->where('employee_roles.deleted_at', '=', null)
		->get();
		return Datatables::of($employee_roles)
		->addColumn('action', function ($employee_role){
			return
			'<button value = "'. $employee_role->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->make(true);
	}


	public function trucking_so_datatable(Request $request){
		$truckings = DB::table('trucking_service_orders')
		->select('trucking_service_orders.id', 'companyName','deliveryDate', 'destination', 'status')
		->join('consignee_service_order_details', 'so_details_id', '=', 'consignee_service_order_details.id')
		->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->get();

		return Datatables::of($truckings)
		->addColumn('action', function ($trucking){
			return
			'<a href = "/trucking/'. $trucking->id .'/view" class = "btn btn-md btn-info view-service-order">Manage</a>';
		})
		->editColumn('deliveryDate', '{{ Carbon\Carbon::parse($deliveryDate)->diffForHumans() }}')
		->editColumn('status', function($trucking){
			switch ($trucking->status) {
				case 'F':
				return 'Finished';
				break;
				case 'P':
				return 'Pending';
				break;
				case 'C':
				return 'Cancelled';
				break;
				default:
				return 'Unknown';
				break;
			}
		})
		->make(true);
	}

	public function trucking_delivery(Request $request){

	}


	//Utility Deactivate

	public function cds_datatable(){
		$cdss = CdsFee::select(['id',  'fee', 'dateEffective', 'created_at']);
		
		return Datatables::of($cdss)
		->addColumn('action', function ($cds){
			return
			'<button value = "'. $cds->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ipf_datatable(){
		$ipffs = IpfFee::select(['id',  'minimum', 'maximum','amount',   'created_at']);
		
		return Datatables::of($ipffs)
		->addColumn('action', function ($ipf){
			return
			'<button value = "'. $ipf->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $ipf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function cds_deactivated(Request $request){
		$cds;
		if ($request->filter == 0){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($cds)
			->addColumn('action', function ($cds){
				if ($cds->deleted_at == null){
					return
					'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $cds->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($cds)
			->addColumn('action', function ($cds){
				return
				'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($cds)
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($cds){
				return
				'<button value = "'. $cds->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	public function bf_deactivated(Request $request){
		$bfs;
		if ($request->filter == 0){
			$bfs = DB::table('brokerage_fees')
			->select('id', 'minimum', 'maximum', 'amount', 'created_at', 'deleted_at')
			->get();

			return Datatables::of($bfs)
			->addColumn('action', function ($bfs){
				if ($bfs->deleted_at == null){
					return
					'<button value = "'. $bfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $bfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$bfs = DB::table('brokerage_fees')
			->select('id', 'minimum', 'maximum', 'amount', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($bfs)
			->addColumn('action', function ($bfs){
				return
				'<button value = "'. $bfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$bfs = DB::table('brokerage_fees')
			->select('id', 'minimum', 'maximum', 'amount', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($bfs)
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($bfs){
				return
				'<button value = "'. $bfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 



	public function ch_deactivated(Request $request){
		$chs;
		if ($request->filter == 0){
			$chs = DB::table('charges')
			->select('id', 'description','created_at', 'deleted_at')
			->get();

			return Datatables::of($chs)
			->addColumn('action', function ($chs){
				if ($chs->deleted_at == null){
					return
					'<button value = "'. $chs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $chs->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$chs = DB::table('charges')
			->select('id', 'description','created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($chs)
			->addColumn('action', function ($chs){
				return
				'<button value = "'. $chs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$chs = DB::table('charges')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($chs)
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($chs){
				return
				'<button value = "'. $chs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 



	public function ct_deactivated(Request $request){
		$cts;
		if ($request->filter == 0){
			$cts = DB::table('container_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($cts)
			->addColumn('action', function ($cts){
				if ($cts->deleted_at == null){
					return
					'<button value = "'. $cts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $cts->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$cts = DB::table('container_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($cts)
			->addColumn('action', function ($cts){
				return
				'<button value = "'. $cts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$cts = DB::table('container_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($cts)
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($cts){
				return
				'<button value = "'. $cts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	public function bst_deactivated(Request $request){
		$bsts;
		if ($request->filter == 0){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($bsts)
			->addColumn('action', function ($bsts){
				if ($bsts->deleted_at == null){
					return
					'<button value = "'. $bsts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $bsts->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($bsts)
			->addColumn('action', function ($bsts){
				return
				'<button value = "'. $bsts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($bsts)
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($bsts){
				return
				'<button value = "'. $bsts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	public function et_deactivated(Request $request){
		$ets;
		if ($request->filter == 0){
			$ets = DB::table('employee_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($ets)
			->addColumn('action', function ($ets){
				if ($ets->deleted_at == null){
					return
					'<button value = "'. $ets->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ets->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ets = DB::table('employee_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($ets)
			->addColumn('action', function ($ets){
				return
				'<button value = "'. $ets->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ets = DB::table('employee_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($ets)
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($ets){
				return
				'<button value = "'. $ets->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	


	public function er_deactivated(Request $request){
		$ers;
		if ($request->filter == 0){
			$ers = DB::table('exchange_rates')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($ers)
			->addColumn('action', function ($ers){
				if ($ers->deleted_at == null){
					return
					'<button value = "'. $ers->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ers->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ers = DB::table('exchange_rates')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($ers)
			->addColumn('action', function ($ers){
				return
				'<button value = "'. $ers->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ers = DB::table('employee_types')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($ers)
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($ers){
				return
				'<button value = "'. $ers->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 




	public function ipf_deactivated(Request $request){
		$ipfs;
		if ($request->filter == 0){
			$ipfs = DB::table('ipf_fees')
			->select('id',  'minimum', 'maximum','amount', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($ipfs)
			->addColumn('action', function ($ipfs){
				if ($ipfs->deleted_at == null){
					return
					'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ipfs = DB::table('ipf_fees')
			->select('id',  'minimum', 'maximum','amount', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($ipfs)
			->addColumn('action', function ($ipfs){
				return
				'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ipfs = DB::table('ipf_fees')
			->select('id',  'minimum', 'maximum','amount', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($ipfs)
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($ipfs){
				return
				'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 

	public function rt_deactivated(Request $request){
		$rts;
		if ($request->filter == 0){
			$rts = DB::table('receive_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($rts)
			->addColumn('action', function ($rts){
				if ($rts->deleted_at == null){
					return
					'<button value = "'. $rts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $rts->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$rts = DB::table('receive_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($rts)
			->addColumn('action', function ($rts){
				return
				'<button value = "'. $rts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$rts = DB::table('receive_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($rts)
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($rts){
				return
				'<button value = "'. $rts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	public function sot_deactivated(Request $request){
		$sots;
		if ($request->filter == 0){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($sots)
			->addColumn('action', function ($sots){
				if ($sots->deleted_at == null){
					return
					'<button value = "'. $sots->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $sots->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($sots)
			->addColumn('action', function ($sots){
				return
				'<button value = "'. $sots->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($sots)
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($sots){
				return
				'<button value = "'. $sots->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 


	public function vt_deactivated(Request $request){
		$vts;
		if ($request->filter == 0){
			$vts = DB::table('vehicle_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($vts)
			->addColumn('action', function ($vts){
				if ($vts->deleted_at == null){
					return
					'<button value = "'. $vts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $vts->id .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$vts = DB::table('vehicle_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($vts)
			->addColumn('action', function ($vts){
				return
				'<button value = "'. $vts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$vts = DB::table('vehicle_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($vts)
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($vts){
				return
				'<button value = "'. $vts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function 



	public function v_deactivated(Request $request){
		$vs;
		if ($request->filter == 0){
			$vs = DB::table('vehicles')
			->select('vehicle_types_id', 'plateNumber', 'model','dateRegistered', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($vs)
			->addColumn('action', function ($vs){
				if ($vs->deleted_at == null){
					return
					'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-success activate">Activate</button>';	
				}
			})
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('plateNumber', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$vs = DB::table('vehicles')
			->select('vehicle_types_id', 'plateNumber', 'model','dateRegistered', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($vs)
			->addColumn('action', function ($vs){
				return
				'<button value = "'. $vs->plateNumber.'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->editColumn('plateNumber', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$vs = DB::table('vehicles')
			->select('vehicle_types_id', 'plateNumber', 'model','dateRegistered', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();
			
			return Datatables::of($vs)
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}
				
			})
			->addColumn('action', function ($vs){
				return
				'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('plateNumber', '{{ $id }}')
			->make(true);
		}
	}//function 

	public function get_contracts(Request $request)
	{
		$contracts = DB::table('contract_headers')
		->select('id', 'dateEffective', 'dateExpiration')
		->where('consignees_id', '=', $request->consignee_id)
		->get();

		return Datatables::of($contracts)
		->addColumn('status', function ($contract){
			$from = Carbon::parse($contract->dateEffective);
			$to = Carbon::parse($contract->dateExpiration);

			if( Carbon::now()->between($from, $to) == true)
			{
				return 'Active';
			}
			else
			{
				return 'Expired';
			}
		})
		->addColumn('action', function ($contract){
			return
			'<input type = "hidden" value = "' .  $contract->id . '" class = "contract_header_value" />' . 
			'<button value = "" class = "btn btn-md btn-success select-contract-header">Select</button>';
		})
		->editColumn('id', '{{ $id }}')
		->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateEffective)->diffForHumans() }}')
		->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
		->make(true);
	}

}