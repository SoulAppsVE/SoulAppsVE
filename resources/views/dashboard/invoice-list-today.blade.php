@extends('app')

@section('contentheader')
	{{trans('core.invoice_list')}} ({{trans('core.today')}})
@stop

@section('breadcrumb')
	{{trans('core.invoice_list')}}
@stop

@section('main-content')
    <div class="panel-heading" >
        <span style="padding: 10px;">
        
        </span>

        @if(count(Request::input()))
        <span class="pull-right">   
            <a class="btn btn-alt btn-default btn-xs" href="{{ action('HomeController@todayInvoice') }}">
                <i class="fa fa-eraser"></i> 
                {{ trans('core.clear') }}
            </a>

            <a class="btn btn-alt btn-primary btn-xs" id="searchButton">
                <i class="fa fa-search"></i> 
                {{ trans('core.modify_search') }}
            </a>
        </span>
        @else
            <a class="btn btn-alt botom btn-xs pull-right" id="searchButton" style="border-radius: 0px !important;" >
                <i class="fa fa-search"></i>
                {{ trans('core.search') }}
            </a>
        @endif

        <input type="button" class="btn btn-alt bg-purple btn-xs" id="summaryBtn" value="Mostrar resumen">
    </div>

	<div class="panel-body" id="todaySellTable">
		<table class="table table-bordered table-striped">
			<thead style="background-color:#1b2f4c ">
				<td class="text-center font-white">{{trans('core.time')}}</td>
				<td class="text-center font-white">N° Orden de Compra</td>
                <td class="text-center font-white">{{trans('core.client')}}</td>
                <td class="text-center font-white">{{trans('core.items')}}</td>
                <td class="text-center font-white">{{trans('core.total_amount')}}</td>
                <td class="text-center font-white">{{trans('core.paid')}}</td>
                <td class="text-center font-white">{{trans('core.actions')}}</td>
			</thead>

			<tbody>
				@foreach($invoices as $invoice)
					<tr>
						<td class="text-center">
                            {{ carbonDate($invoice->date, 'time') }}
                        </td>

                        <td class="text-center">#{{$invoice->reference_no}}</td>

                        <td class="text-center">
                        	<a 
                                href="{{route('client.details', $invoice->client)}}" 
                                title="{{trans('core.client_details')}}"
                                style="color: green; text-decoration: underline;" 
                            >
                        		{{$invoice->client->name}}
                        	</a>
                        </td>

                        <td>
                            <ol>
                                @foreach($invoice->sells as $sell)
                                    <li>{{$sell->product->name}}</li>
                                @endforeach
                            </ol>
                        </td>
                        
                        <td class="text-center">
                        	{{settings('currency_code')}} 
                        	{{bangla_digit($invoice->net_total)}} 
                        </td>

                        <td class="text-center">
                            {{settings('currency_code')}}
                        	{{bangla_digit($invoice->paid)}}
                        </td>
                        
                        <td class="text-center">   
                        	<a target="_BLINK" href="{{route('sell.invoice', $invoice)}}" class="btn btn-alt btn-warning btn-xs">
                        		<i class="fa fa-print"></i>
                        		Orden de Compra
                        	</a>
                        	<a href="{{route('sells.details', $invoice)}}" class="btn btn-alt btn-purple btn-xs" target="_BLINK">
                        		{{trans('core.details')}}
                        	</a>		                           
                        </td>
                    </tr>
				@endforeach
			</tbody>
		</table>
        <!--Pagination-->
        <div class="pull-right">
            {{ $invoices->links() }}
        </div>
        <!--Ends-->
	</div>

    <div class="panel-body" id="sellDetailsTable" style="display: none;">
        <center>
            <h3 style="padding: 10px;">Resumen de ventas de hoy</h3>    
        </center>
        
        <table style="width: 100%; font-weight: bold;" class="table table-bordered" >
            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                    <b>{{trans('core.total')}} :</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($total)}} 
                   
                </td>
            </tr>

            <tr style="background-color: #F8F9F9;border: 2px solid #ddd; ">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                    <b>{{trans('core.total_tax')}} :</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($total_vat)}}
                </td>
            </tr>

            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                    <b>{{trans('core.net_total')}} :</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($net_total)}}
                </td>
            </tr>

            <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                    <b>{{trans('core.total_cost_price')}} :</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($total_cost_price)}}
                   
                </td>
            </tr>

            <tr style="background-color: #F8F9F9;border: 2px solid #ddd; ">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                   <b>{{trans('core.total_profit')}}</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($profit)}}
                </td>
            </tr>

             <tr style="background-color: #F8F9F9; border: 1px solid #ddd;">
                <td @if(!rtlLocale()) style="text-align: right;" @endif>
                    <b>{{trans('core.total_received')}} :</b>
                </td>
                <td @if(rtlLocale()) style="text-align: right;" @endif>
                    {{settings('currency_code')}}
                    {{twoPlaceDecimal($payments->sum('amount'))}}

                    <br>
                    ({{trans('core.cash')}}: {{settings('currency_code')}} {{$total_cash_payment}} || {{trans('core.card')}}: {{settings('currency_code')}} {{$total_card_payment}} || {{trans('core.cheque')}}: {{settings('currency_code')}} {{$total_cheque_payment}})
                </td>
            </tr>
        </table> 
    </div>

    <div class="panel-footer">  
        <span style="padding: 10px;">
        
        </span>

    	<a class="btn btn-border btn-alt border-black font-black btn-xs pull-right" href="{{route('home')}}">
            <i class="fa fa-backward"></i> {{trans('core.back')}}
        </a>
    </div>

    <!-- Sell search modal -->
    <div class="modal fade" id="searchModal">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['class' => 'form-horizontal']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> {{ trans('core.search').' '.trans('core.sell') }}</h4>
                </div>

                <div class="modal-body">                  
                    <div class="form-group">
                        {!! Form::label('Invoice No', trans('core.invoice_no'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('invoice_no', Request::get('invoice_no'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('Customer', trans('core.customer'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('customer', $customers, Request::get('customer'), ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'placeholder' => 'Please select a customer']) !!}
                        </div>
                    </div>                                 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('core.close')}}</button>
                    {!! Form::submit('Search', ['class' => 'btn btn-primary', 'data-disable-with' => trans('core.searching')]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- search modal ends -->
		
@stop

@section('js')
    @parent
    <script>
        $(function() {
            $('#searchButton').click(function(event) {
                event.preventDefault();
                $('#searchModal').modal('show')
            });
        })

        $(document).ready(function () {
            $('#summaryBtn').click(function () {
                $("#todaySellTable").toggle()
                $("#sellDetailsTable").toggle()
                if($(this).val() == "Show Summary"){
                    $(this).val("Show Sale List")
                }else{
                    $(this).val("Show Summary")
                }
            })
        })
    </script>
@stop