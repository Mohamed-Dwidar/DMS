@extends('layoutmodule::'.Auth::getDefaultDriver().'.main')

@section('title')
استعراض الأقسام الفرغية
@endsection

@push('styles')

@endpush
@section('content')

<div class="content-header">
    <div class="content-header-left mb-2 breadcrumb-new col">
        <h3>
            <i class="icon-grid"></i>
            استعراض الأقسام


            <a class="btn btn-success add-new-btn" href="{{route('invoices.add')}}" role="button">قسم
                جديد</a>
        </h3>


    </div>
</div>

@include('layoutmodule::'.Auth::getDefaultDriver().'.flash')


<div class="content-body">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card">


                <div class="card-body mt-2">
                    <div class="table-responsive">
                        <div class="cats-tree">
                            <ul>
                                <li> <a href="{{route('invoices')}}"> الأقسام الرئيسية </a> /</li>
                                @if ($parent_invoice->getParentsNames() !== $parent_invoice->name)

                                @foreach ($parent_invoice->getParentsNames()->reverse() as $item)
                                <li> <a href="{{route('getSubInvoices',$item->id)}}"> {{$item->name }} </a> /</li>
                                @endforeach

                                @endif

                                @if($parent_invoice)
                                <b>{{$parent_invoice->name}}</b>
                                @else
                            </ul>
                            ---
                            @endif
                        </div>

                        <table id="sellers_table" class="table table-bordered table-striped">
                            <thead>
                                <tr class="head">
                                    <th>القسم </th>
                                    <th>الأقسام الفرعية</th>
                                    {{-- <th>&nbsp;</th> --}}
                                    <th>المنتجات</th>
                                    <th>فعال</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if(!empty($sub_invoices))
                                @foreach ($sub_invoices as $invoice)
                                <tr>
                                    <td>{{$invoice->name}} </td>

                                    <td>
                                        <!-- <a href="">{{$invoice->children->count()}}</a> -->

                                        @if($invoice->children->count() != 0)
                                        <a class="btn-sm btn-success action"
                                            href="{{route('getSubInvoices',$invoice->id)}}" role="button px-2">
                                            <i class="fa fa-eye"></i>
                                            {{$invoice->children->count()}}
                                        </a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ $invoice->productNumber }}</td>
                                    <td>
                                        <label class="switch" id="switch">
                                            <input class="switch__input" type="checkbox" data-id="{{$invoice->id}}"
                                                {{$invoice->is_active ==1 ? 'checked' : ''}}/>
                                            <i class="switch__icon"></i>
                                            <!-- Image loader -->
                                            <div id='loader'>
                                                <img src='{{asset("assets/images/reload.gif")}}'>
                                            </div>
                                            <!-- Image loader -->
                                        </label>

                                    </td>

                                    <td class="action">
                                        <a class="btn-sm btn-warning action"
                                            href="{{route('invoices.edit',$invoice->id)}}"><i
                                                class="fa fa-edit"></i></a>&nbsp;
                                        <a class="btn-sm btn-danger action"
                                            href="{{ route('invoices.delete',[$invoice->id])}}"
                                            onclick="return confirm('Are you sure you want to delete this element?')"><i
                                                class="fa fa-trash"></i></a>&nbsp;
                                    </td>



                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





@endsection

@push('scripts')

<script>
    $('.switch__input').on('change', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var invoice_id = $(this).data('id');  
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
             url: '/admin/invoices/changeInvoiceActivity/'+invoice_id,
            data: {
                'is_active': status,
                'invoice_id': invoice_id
            },
            success:function(data) {
                
            },
            beforeSend:  () => {
                $(this).parent().find('#loader').show();
                $(this).parent().find('.switch__input').hide();
            },
            complete:  () => {
                $(this).parent().find('#loader').hide();
                $(this).parent().show();
            },
        });
        
    });

    $(document).ajaxComplete(function(){
    // Hide image container
    //$("#loader").hide();
    });
</script>

@endpush




<?php /* 
@extends('layoutmodule::main')

@section('title')
Invoices
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
@endpush


@section('content')

<div class="content-wrapper container-fluid">
    <div class="content-header">
        <div class="content-header-left mb-2 breadcrumb-new col">
            <h3>
                <i class="icon-grid2"></i>
                &nbsp;
                Invoices
            </h3>
            {{-- <a href="invoice.html">Invoices /</a> --}}
        </div>
    </div>

    @include('layoutmodule::flash')

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-5 ">
                            <!-- @if ($parent_invoice->getParentsNames() !== $parent_invoice->name)
                            {{ implode('/',$parent_invoice->getParentsNames()->reverse()->pluck('name')->toArray()) }}
                            @endif
                            @if($parent_invoice)
                            <b> / {{$parent_invoice->name}}</b>
                            @else
                            --- 
                            @endif -->
                            <ul>
                            @if ($parent_invoice->getParentsNames() !== $parent_invoice->name)
                            
                            @foreach ($parent_invoice->getParentsNames()->reverse() as $item)
                            
                            @if ($item->parent_id == 0)
                            
                           <li>{{ $item->name }}</li> 
                            @else
                              <li> / {{ $item->name }} </li>
                            @endif
                         
                            @endforeach
                            
                            @endif

                            / 
                            @if($parent_invoice)
                            <b>{{$parent_invoice->name}}</b>
                            @else
                            </ul>
                            --- 
                            @endif
                            </div> 
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <a class="btn btn-success round btn-min-width mr-1 mb-1"
                                    href="{{route('invoices.add')}}" role="button">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="head">
                                        <th>Invoice  </th>
                                        <th>Sub Invoices</th>
                                        {{-- <th>&nbsp;</th> --}}
                                        <th>Products</th>
                                        <th>Active</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(!empty($sub_invoices))
                                    @foreach ($sub_invoices as $invoice)
                                    <tr>
                                        <td>{{$invoice->name}} </td>
                                       
                                        <td>
                                            <!-- <a href="">{{$invoice->children->count()}}</a> -->  

                                           @if($invoice->children->count() != 0)
                                            <a class="btn-sm btn-warning "
                                                href="{{route('getSubInvoices',$invoice->id)}}"
                                                role="button px-2" >
                                                <i class="fa fa-eye" ></i>
                                                {{$invoice->children->count()}}
                                            </a>
                                            @else
                                              -
                                           @endif 
                                        </td>
                                        <td>{{ $invoice->productNumber }}</td>
                                        <td>
                                            <label class="switch" id="switch">
                                                <input class="switch__input" type="checkbox" data-id="{{$invoice->id}}" 
                                                    {{$invoice->is_active ==1 ? 'checked' : ''}}/>
                                                <i class="switch__icon"></i>
                                                <!-- Image loader -->
                                                <div id='loader'>
                                                    <img src='{{asset("assets/images/reload.gif")}}'>
                                                </div>
                                                <!-- Image loader -->
                                            </label>

                                        </td>
                                        <td class="action">
                                            <a class="btn-sm btn-warning"
                                                href="{{route('invoices.edit',$invoice->id)}}"
                                                role="button">{{__('messages.edit')}}</a>
                                            <a href="{{ route('invoices.delete',[$invoice->id])}}"
                                                onclick="return confirm('Are you sure you want to delete this element?')"
                                                class="btn-sm btn-danger" role="button">Delete</a>
                                        </td>
                                    </tr>
                                   


                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection


@push('scripts')

<script>
    $('.switch__input').on('change', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var invoice_id = $(this).data('id');  
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
             url: '/admin/invoices/changeInvoiceActivity/'+invoice_id,
            data: {
                'is_active': status,
                'invoice_id': invoice_id
            },
            success:function(data) {
                
            },
            beforeSend:  () => {
                $(this).parent().find('#loader').show();
                $(this).parent().find('.switch__input').hide();
            },
            complete:  () => {
                $(this).parent().find('#loader').hide();
                $(this).parent().show();
            },
        });
        
    });

    $(document).ajaxComplete(function(){
    // Hide image container
    //$("#loader").hide();
    });
</script>

@endpush

*/
?>