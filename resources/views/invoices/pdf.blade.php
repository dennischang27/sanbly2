<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{{ $title }}</title>
		<style>
			body {
				font-family: "IBM Plex Sans", Helvetica, Arial, serif;
				font-size: 1rem;
				font-weight: 400;
				line-height: 1.4;
				color: #727E8C;
				text-align: left;
			}
			.text-primary {
				color: #5A8DEE !important;
			}
			.iconDetails {
				margin-left:2%;
				float:right;
			}
			.container2 {
				width:100%;
				margin-bottom: 30px;
			}
			h4 {
				margin:0px;
			}
			hr {
				border-style: dashed;
				margin-top: 1rem;
				margin-bottom: 1rem;
				border: 0;
				border-top: 1px #DFE3E7;
				box-sizing: content-box;
				height: 0;
				overflow: visible;
			}
			#resp-table {
				width: 100%;
				display: table;
			}
			.resp-table-row{
				display: table-row;
			}
			.table-body-cell{
				display: table-cell;
			}
		</style>
	</head>
	<body>
		<section class="invoice-view-wrapper">
		<div class="col-xl-9 col-md-8 col-12">
		  <div class="card invoice-print-area">
			<div class="card-content">
			  <div class="card-body pb-0 mx-25">
				<!-- header section -->
				<div class="row" style="margin-bottom: 30px;">
				  <div class="col-xl-4 col-md-12">
				      <span class="invoice-number mr-50">Invoice No:</span>
					  <span>{{ $invoice_id }}</span>
					  <span class="mr-3" style="display: block;float: right;">
						  <span class="mr-3">
							<small class="text-muted">Date Issue:</small>
							<span>{{ $date_issue }}</span>
						  </span>
						  <span>
							<small class="text-muted">Date Due:</small>
							<span>{{ $date_due }}</span>
						  </span>
					  </span>
				  </div>
				</div>
				<!-- logo and title -->
				<div class='container2'>
					<div>
						<img src="http://localhost/sanbly2/public/images/pages/workted-logo.png" alt="logo" width="164" height="46" class='iconDetails'>
					</div>	
				</div>
				<div class="row my-3" style="margin-bottom:50px;">
				  <span class="col-6">
					<h4 class="text-primary">Invoice</h4>
					<span></span>
				  </span>
				</div>
				<hr>
				<!-- invoice address and contact -->
				<div id="resp-table" style="margin-bottom:50px;">
					<div class="resp-table-row">
						<div class="table-body-cell" style="width: 50%;">
							<h6 class="invoice-from">Bill From</h6>
						</div>
						<div class="table-body-cell" style="width: 50%;">
							<h6 class="invoice-to">Bill To</h6>
						</div>
					</div>
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>Sorable Sdn. Bhd. (1261555-A)</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $customer_name }}</span>
						</div>
					</div>
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>29-07, Jalan Riong,</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $address }}</span>
						</div>
					</div>
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>Bangsar,</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $city }}</span>
						</div>
					</div>
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>59100 Kuala Lumpur,</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $zipcode }} {{ $state }}</span>
						</div>
					</div>
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>Malaysia</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $country }}</span>
						</div>
					</div>
				</div>
				<hr>
			  </div>
			  <!-- product details table-->
			  <div id="resp-table" style="margin-bottom:30px;">
				 <div class="resp-table-row">
					<div class="table-body-cell" style="width: 60%;">
						<h6 class="invoice-from">Item</h6>
					</div>
					<div class="table-body-cell" style="width: 13%;">
						<h6 class="invoice-to">Qty</h6>
					</div>
					<div class="table-body-cell" style="width: 13%;">
						<h6 class="invoice-to">Tax</h6>
					</div>
					<div class="table-body-cell">
						<h6 class="invoice-to" style="display: block;float:right;">Price</h6>
					</div>
				 </div>
				 @foreach ($invoiceItems as $item)
					<div class="resp-table-row">
						<div class="table-body-cell">
							<span>{{ $item->product_name }}</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $item->quantity }}</span>
						</div>
						<div class="table-body-cell">
							<span>{{ $item->tax_name }}</span>
						</div>
						<div class="table-body-cell">
							<span style="display: block;float:right;">{{ number_format($item->price, 2) }}</span>
						</div>
					 </div>
				@endforeach
			  </div>

			  <!-- invoice subtotal -->
			  <div class="card-body pt-0 mx-25">
				<hr>
				<div id="resp-table" style="margin-top:30px;">
					 <div class="resp-table-row">
						<div class="table-body-cell" style="width: 70%;">
							<span>Thanks for your business.</span>
						</div>
						<div class="table-body-cell">
							<span>Subtotal</span>
						</div>
						<div class="table-body-cell">
							<span style="display: block;float:right;">{{ number_format($subtotal, 2) }}</span>
						</div>
					 </div>
					 <div class="resp-table-row">
						<div class="table-body-cell">
							<span></span>
						</div>
						<div class="table-body-cell">
							<span>Discount</span>
						</div>
						<div class="table-body-cell">
							<span style="display: block;float:right;">- 0.00</span>
						</div>
					 </div>
					 @foreach($invoiceItems as $key=>$item)
						<div class="resp-table-row">
							<div class="table-body-cell">
								<span></span>
							</div>
							<div class="table-body-cell">
								<span>{{ __('Tax') }}{{ $key+1 }}(<span id="percentage{{$key}}">{{ number_format($item->tax_percentage, 2) }}</span>%)</span>
							</div>
							<div class="table-body-cell">
								<span style="display: block;float:right;">{{ number_format($item->tax_amount, 2) }}</span>
							</div>
						 </div>
				     @endforeach
					 <div class="resp-table-row">
						<div class="table-body-cell">
							<span></span>
						</div>
						<div class="table-body-cell">
							<span><hr></span>
						</div>
						<div class="table-body-cell">
							<span><hr></span>
						</div>
					 </div>
					 <div class="resp-table-row">
						<div class="table-body-cell">
							<span></span>
						</div>
						<div class="table-body-cell">
							<span>Invoice Total</span>
						</div>
						<div class="table-body-cell">
							<span style="display: block;float:right;">{{ number_format($invoice_total, 2) }}</span>
						</div>
					 </div>
				</div>
				
			  </div>
			</div>
		  </div>
		</div>
		</section>
	</body>
</html>
