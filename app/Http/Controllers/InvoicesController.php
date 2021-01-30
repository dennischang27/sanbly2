<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Taxes;
use App\Invoices;
use App\InvoiceItems;
use App\InvoiceTaxes;
use App\Customers;
use App\Products;
use App\Web;
use App\PaymentModes;
use App\InvoicePayments;
use DB;
use PDF;
use Mail;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoices $invoices)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$invoices = Invoices::where('user_id', '=', auth()->user()->id)->get();
				return view('invoices.index', ['invoices' => $invoices]);
			}else{ 
				return redirect()->route('invoices.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$invoices = Invoices::where(['id' => $id])->where('user_id', '=', auth()->user()->id)->first();
				$invoiceItems = InvoiceItems::where(['invoice_id' => $id])->get();
				$InvoiceTaxes = InvoiceTaxes::where(['invoice_id' => $id])->orderBy('id', 'DESC')->get();
				$InvoicePayments = InvoicePayments::where(['invoice_id' => $id])->first();
				$sum = InvoicePayments::where('invoice_id', $id)->sum('amount');
				$payment_date = date('m/d/Y');
				$payment_modes = PaymentModes::where(['user_id' => auth()->user()->id])->get();
				return view('invoices.view', ['invoices' => $invoices, 'invoiceItems' => $invoiceItems, 'InvoiceTaxes' => $InvoiceTaxes, 'InvoicePayments' => $InvoicePayments, 'payment_date' => $payment_date, 'payment_modes' => $payment_modes, 'sum' => $sum]);
			}else{ 
				return redirect()->route('invoices.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if(auth()->user() && auth()->user()->hasRole('admin') || auth()->user() && auth()->user()->hasRole('owner')){
			$invoices =  Invoices::where('user_id', '=', auth()->user()->id)->latest('updated_at')->first();
			$customers = Customers::where(['user_id' => auth()->user()->id])->get();
			$products = Products::where(['user_id' => auth()->user()->id])->get();
			$taxes = Taxes::where(['user_id' => auth()->user()->id])->get();
			$invoice_id = Invoices::select('invoice_id')->orderBy('invoice_id', 'DESC')->limit(1)->get();
			
			if($invoices){
				$invoice_id = $invoice_id[0]->invoice_id + 1;
				$invoices->invoice_id = $invoice_id;
				$date_issue = date('m/d/Y');
				$date_due = date('m/d/Y',strtotime('+30 days',strtotime($date_issue)));
				return view('invoices.create', ['invoices' => $invoices, 'date_issue' => $date_issue, 'date_due' => $date_due, 'customers' => $customers, 'products' => $products, 'taxes' => $taxes]);
			} else {
				$invoice_id = 1001;
				$date_issue = date('m/d/Y');
				$date_due = date('m/d/Y',strtotime('+30 days',strtotime($date_issue)));
				return view('invoices.create', ['invoices' => $invoices, 'invoice_id' => $invoice_id, 'date_issue' => $date_issue, 'date_due' => $date_due, 'customers' => $customers, 'products' => $products, 'taxes' => $taxes]);
			}
            
        }else if(auth()->guest()){
            return redirect()->route('front');
        }else return redirect()->route('invoices.index')->withStatus(__('No Access'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if($request->items){
			$arrItems = $request->items;
			$length = count($arrItems);
			
			if($length > 0){
				$invoice_id = $request->invoice_id;
				$invoices = new Invoices;
				$invoices->invoice_id = $invoice_id;
				$invoices->date_issue = date("Y-m-d", strtotime($request->date_issue));
				$invoices->date_due = date("Y-m-d", strtotime($request->date_due));
				$invoices->customer_id = $request->customer_id;
				$invoices->customer_name = strip_tags($request->customer_name);
				$invoices->address = strip_tags($request->address);
				$invoices->city = strip_tags($request->city);
				$invoices->state = strip_tags($request->state);
				$invoices->zipcode = $request->zipcode;
				$invoices->country = strip_tags($request->country);
				$invoices->payment_terms = strip_tags($request->payment_term);
				$invoices->client_notes = strip_tags($request->client_note);
				$invoices->subtotal = $request->subtotal;
				$invoices->invoice_total = $request->invoicetotal;
				$invoices->user_id = auth()->user()->id;
				$invoices->company_id = auth()->user()->company->id;
				$invoices->save();
		
				if($length == 1){
					if($arrItems[0]['product_id']){
						$invoiceItem = new InvoiceItems;
						$invoiceItem->product_id = $arrItems[0]['product_id'];
						$invoiceItem->product_name = $arrItems[0]['product_name'];
						$invoiceItem->quantity = $arrItems[0]['quantity'];
						$invoiceItem->tax_id = $arrItems[0]['tax_id'];
						$invoiceItem->tax_name = $arrItems[0]['tax_name'];
						$invoiceItem->price = $arrItems[0]['price'];
						$invoiceItem->tax_percentage = $arrItems[0]['tax_percentage'];
						$invoiceItem->tax_amount = $arrItems[0]['tax_amount'];
						$invoiceItem->invoice_id = $invoices->id;
						$invoiceItem->user_id = auth()->user()->id;
						$invoiceItem->company_id = auth()->user()->company->id;
						$invoiceItem->save();
					}
				} else {
					foreach($arrItems as $item) {
						$invoiceItem = new InvoiceItems;
						$invoiceItem->product_id = $item['product_id'];
						$invoiceItem->product_name = $item['product_name'];
						$invoiceItem->quantity = $item['quantity'];
						$invoiceItem->tax_id = $item['tax_id'];
						$invoiceItem->tax_name = $item['tax_name'];
						$invoiceItem->price = $item['price'];
						$invoiceItem->tax_percentage = $item['tax_percentage'];
						$invoiceItem->tax_amount = $item['tax_amount'];
						$invoiceItem->invoice_id = $invoices->id;
						$invoiceItem->user_id = auth()->user()->id;
						$invoiceItem->company_id = auth()->user()->company->id;
						$invoiceItem->save();
					}
				}
				
				$arrTaxes = $request->taxes;
				
				$taxesLength = 0;
				
				if($arrTaxes){
					$taxesLength = count($arrTaxes);
				}
				
				if($taxesLength == 1){
					if($arrTaxes[0]['tax_name']){
						$invoiceTaxes = new InvoiceTaxes;
						$invoiceTaxes->tax_name = $arrTaxes[0]['tax_name'];
						$invoiceTaxes->tax_percentage = $arrTaxes[0]['tax_percentage'];
						$invoiceTaxes->tax_amount = $arrTaxes[0]['tax_amount'];
						$invoiceTaxes->invoice_id = $invoices->id;
						$invoiceTaxes->user_id = auth()->user()->id;
						$invoiceTaxes->company_id = auth()->user()->company->id;
						$invoiceTaxes->save();
					}
				} elseif ($taxesLength > 1) {
					foreach($arrTaxes as $item) {
						$invoiceTaxes = new InvoiceTaxes;
						$invoiceTaxes->tax_name = $item['tax_name'];
						$invoiceTaxes->tax_percentage = $item['tax_percentage'];
						$invoiceTaxes->tax_amount = $item['tax_amount'];
						$invoiceTaxes->invoice_id = $invoices->id;
						$invoiceTaxes->user_id = auth()->user()->id;
						$invoiceTaxes->company_id = auth()->user()->company->id;
						$invoiceTaxes->save();
					}
				}
			}
		}
		
        return 'invoice successfully added!';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner')){
				$invoices =  Invoices::where(['id' => $id])->where('user_id', '=', auth()->user()->id)->first();
				$invoiceItems =  InvoiceItems::where(['invoice_id' => $id])->get();
				$invoiceTaxes = InvoiceTaxes::where(['invoice_id' => $id])->orderBy('id', 'DESC')->get();
				$customers = Customers::where(['user_id' => auth()->user()->id])->get();
				$products = Products::where(['user_id' => auth()->user()->id])->get();
				$taxes = Taxes::where(['user_id' => auth()->user()->id])->get();
				return view('invoices.edit', ['invoices' => $invoices, 'invoiceItems' => $invoiceItems, 'invoiceTaxes' => $invoiceTaxes, 'customers' => $customers, 'products' => $products, 'taxes' => $taxes]);
			}else{ 
				return redirect()->route('invoices.index')->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices $invoices, InvoiceItems $invoiceItems, InvoiceTaxes $invoiceTaxes)
    {	
		if($request->items){
			$arrItems = $request->items;
			$length = count($arrItems);
			
			if($length > 0){
				$invoice_id = $request->invoice_id;
		
				$invoices = Invoices::where(['id' => $request->invoice_id])->where('user_id', '=', auth()->user()->id)->first();
				//$invoices->invoice_id = $invoice_id;
				$invoices->date_issue = date("Y-m-d", strtotime($request->date_issue));
				$invoices->date_due = date("Y-m-d", strtotime($request->date_due));
				$invoices->customer_id = $request->customer_id;
				$invoices->customer_name = strip_tags($request->customer_name);
				$invoices->address = strip_tags($request->address);
				$invoices->city = strip_tags($request->city);
				$invoices->state = strip_tags($request->state);
				$invoices->zipcode = $request->zipcode;
				$invoices->country = strip_tags($request->country);
				$invoices->payment_terms = strip_tags($request->payment_term);
				$invoices->client_notes = strip_tags($request->client_note);
				$invoices->subtotal = $request->subtotal;
				$invoices->invoice_total = $request->invoicetotal;
				$invoices->user_id = auth()->user()->id;
				$invoices->company_id = auth()->user()->company->id;
				$invoices->save();
				
				$deletedRows = InvoiceItems::where('invoice_id', $request->invoice_id)->delete();
		
				if($length == 1){
					if($arrItems[0]['product_id']){
						$invoiceItem = new InvoiceItems;
						$invoiceItem->product_id = $arrItems[0]['product_id'];
						$invoiceItem->product_name = $arrItems[0]['product_name'];
						$invoiceItem->quantity = $arrItems[0]['quantity'];
						$invoiceItem->tax_id = $arrItems[0]['tax_id'];
						$invoiceItem->tax_name = $arrItems[0]['tax_name'];
						$invoiceItem->price = $arrItems[0]['price'];
						$invoiceItem->tax_percentage = $arrItems[0]['tax_percentage'];
						$invoiceItem->tax_amount = $arrItems[0]['tax_amount'];
						$invoiceItem->invoice_id = $invoices->id;
						$invoiceItem->user_id = auth()->user()->id;
						$invoiceItem->company_id = auth()->user()->company->id;
						$invoiceItem->save();
					}
				} else {
					foreach($arrItems as $item) {
						$invoiceItem = new InvoiceItems;
						$invoiceItem->product_id = $item['product_id'];
						$invoiceItem->product_name = $item['product_name'];
						$invoiceItem->quantity = $item['quantity'];
						$invoiceItem->tax_id = $item['tax_id'];
						$invoiceItem->tax_name = $item['tax_name'];
						$invoiceItem->price = $item['price'];
						$invoiceItem->tax_percentage = $item['tax_percentage'];
						$invoiceItem->tax_amount = $item['tax_amount'];
						$invoiceItem->invoice_id = $invoice_id;
						$invoiceItem->user_id = auth()->user()->id;
						$invoiceItem->company_id = auth()->user()->company->id;
						$invoiceItem->save();
					}
				}
				
				$deletedTaxesRows = InvoiceTaxes::where('invoice_id', $request->invoice_id)->delete();
				$arrTaxes = $request->taxes;
				$taxesLength = 0;
				
				if($arrTaxes){
					$taxesLength = count($arrTaxes);
				}
				
				if($taxesLength == 1){
					if($arrTaxes[0]['tax_name']){
						$invoiceTaxes = new InvoiceTaxes;
						$invoiceTaxes->tax_name = $arrTaxes[0]['tax_name'];
						$invoiceTaxes->tax_percentage = $arrTaxes[0]['tax_percentage'];
						$invoiceTaxes->tax_amount = $arrTaxes[0]['tax_amount'];
						$invoiceTaxes->invoice_id = $invoices->id;
						$invoiceTaxes->user_id = auth()->user()->id;
						$invoiceTaxes->company_id = auth()->user()->company->id;
						$invoiceTaxes->save();
					}
				} elseif ($taxesLength > 1) {
					foreach($arrTaxes as $item) {
						$invoiceTaxes = new InvoiceTaxes;
						$invoiceTaxes->tax_name = $item['tax_name'];
						$invoiceTaxes->tax_percentage = $item['tax_percentage'];
						$invoiceTaxes->tax_amount = $item['tax_amount'];
						$invoiceTaxes->invoice_id = $invoices->id;
						$invoiceTaxes->user_id = auth()->user()->id;
						$invoiceTaxes->company_id = auth()->user()->company->id;
						$invoiceTaxes->save();
					}
				}
			}
		}
		
        return 'invoice successfully updated!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice_id)
    {
		//$data =  Invoices::where('id', '=', $invoice_id)->latest('updated_at')->first();
		$deletedRows = InvoiceItems::where('invoice_id', $invoice_id)->delete();
		$deletedTaxesRows = InvoiceTaxes::where('invoice_id', $invoice_id)->delete();
		$invoices = Invoices::where('id', $invoice_id)->delete();
        return redirect()->route('invoices.index')->withStatus(__('Invoice successfully deleted!'));
    }
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		if($request->items){
			// remove submission data
			$deletedRows = InvoiceItems::whereIn('invoice_id', $request->items)->delete();
			$deletedTaxesRows = InvoiceTaxes::whereIn('invoice_id', $request->items)->delete();
			$invoices = Invoices::whereIn('id', $request->items)->delete(); 
			return 'Invoices successfully deleted!';
		} else {
			return "no data selected";
		}
	}
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function address(Request $request)
    {
		// get customer data
		$address = Customers::where('id', $request->customerid)->get(); 
		return $address;
	}
	
	/**
     * Delete all selected data from submission.
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
		$request->validate([
			'amount'  => 'required',
			'payment_date'  => 'required',
			'payment_mode'  => 'required',
        ]);
		
		if (!isset($request->do_not_send_invoice)) {
			$do_not_send_invoice = 0;
		} else {
			$do_not_send_invoice = 1;
		}
		
		$page = "/".$request->page."/".$request->invoice_id;
		$sum = InvoicePayments::where('invoice_id', $request->invoice_id)->sum('amount');
		$paid_amount = (float)$request->amount;
		$invoice_amount = (float)$request->invoice_amount;
		$total_paid_amount = $sum + $paid_amount;
		
		if($total_paid_amount >= $invoice_amount){
			$status = "paid";
		} else {
			$status = "partially paid";
		}
		
		if(auth()->user()){
			if(auth()->user()->hasRole('admin') || auth()->user() && auth()->user()->hasRole('owner')){
				// Update Status
				$invoices = Invoices::where(['id' => $request->invoice_id])->first();
				$invoices->status = $status;
				$invoices->user_id = auth()->user()->id;
				$invoices->company_id = auth()->user()->company->id;
				$invoices->save();
		
				// Add Invoice Payment
				$invoicePayment = new InvoicePayments;
				$invoicePayment->amount = $request->amount;
				$invoicePayment->payment_date = date("Y-m-d", strtotime($request->payment_date));
				$invoicePayment->payment_mode_id = $request->payment_mode;
				$invoicePayment->payment_mode_name = $request->payment_mode_name;
				$invoicePayment->transaction_id = $request->transaction_id;
				$invoicePayment->note = $request->note;
				$invoicePayment->do_not_send_invoice = $do_not_send_invoice;
				$invoicePayment->invoice_id = $request->invoice_id;
				$invoicePayment->company_id = auth()->user()->company->id;
				$invoicePayment->user_id = auth()->user()->id;
				$invoicePayment->save();
				
				return redirect($page);
			} else {
				return redirect($page)->withStatus(__('No Access'));
			}
		} else {
			return redirect()->route('login');
		}
	}
	
	public function printPDF(Request $request)
    {
		$invoice_id = $request->invoice_id;
		$invoices = Invoices::where(['id' => $invoice_id])->first();
		$invoiceItems = InvoiceItems::where(['invoice_id' => $invoice_id])->get();
        
        // This  $data array will be passed to our PDF blade
        $data = [
			'title' => 'Invoice',
			'invoice_id' => $invoices->invoice_id,
			'date_issue' => date("d-m-Y", strtotime($invoices->date_issue)),
			'date_due' => date("d-m-Y", strtotime($invoices->date_due)),
			'customer_name' => $invoices->customer_name,
			'address' => $invoices->address,
			'city' => $invoices->city,
			'state' => $invoices->state,
			'zipcode' => $invoices->zipcode,
			'country' => $invoices->country,
			'subtotal' => $invoices->subtotal,
			'invoice_total' => $invoices->invoice_total,
			'invoiceItems' => $invoiceItems,
        ];

        $pdf = PDF::loadView('invoices/pdf', $data);  
        return $pdf->download('invoice.pdf');
    }
	
	public function show()
    {
		$data["email"] = "dennis@sorable.com";
        $data["title"] = "From ItSolutionStuff.com";
        $data["body"] = "This is Demo";
 
        $files = [
            public_path('files/invoice.pdf'),
        ];
  
        Mail::send('invoices.myTestMail', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
            foreach ($files as $file){
                $message->attach($file);
            }
        });
 
        dd('Mail sent successfully');
	}
}
