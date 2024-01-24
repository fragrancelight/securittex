@extends('admin.master')
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('sidebar')
@include('p2p::layouts.sidebar',['menu'=>'gift_card', 'sub_menu'=>'orders'])
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li class="active-item">{{__('Order History')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <!-- User Management -->
    <div class="user-management wallet-transaction-area">
        <div class="row no-gutters">
            <div class="col-12 col-lg-2">
                <ul class="nav wallet-transaction user-management-nav mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id=all_order" data-toggle="pill" href="#all_order_tab"
                            role="tab" aria-controls="all_order_tab" aria-selected="true">
                            {{__('All Orders')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="active_order" data-toggle="pill" href="#active_order_tab"
                            role="tab" aria-controls="active_order_tab" aria-selected="true">
                            {{__('Escrow Orders')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="deactive_order" data-toggle="pill"
                            href="#deactive_order_tab" role="tab" aria-controls="deactive_order_tab"
                            aria-selected="true">
                            {{__('Payment Done Orders')}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-10">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="all_order_tab" role="tabpanel"
                            aria-labelledby=all_order">
                        <div class="table-area">
                            <div class="table-responsive">
                                <table id="all_table" class="table table-borderless custom-table display text-left"
                                        width="100%">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Buyer')}}</th>
                                        <th class="all">{{__('Seller')}}</th>
                                        <th class="all">{{__('Price')}}</th>
                                        <th class="all">{{__('Amount')}}</th>
                                        <th class="all">{{__('Status')}}</th>
                                        <th class="all">{{__('Created At')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="active_order_tab" role="tabpanel"
                            aria-labelledby="active_order">
                        <div class="table-area">
                            <div class="table-responsive">
                                <table id="active_table"
                                        class="table table-borderless custom-table display text-left" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Buyer')}}</th>
                                        <th class="all">{{__('Seller')}}</th>
                                        <th class="all">{{__('Price')}}</th>
                                        <th class="all">{{__('Amount')}}</th>
                                        <th class="all">{{__('Status')}}</th>
                                        <th class="all">{{__('Created At')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="deactive_order_tab" role="tabpanel"
                            aria-labelledby="deactive_order">
                        <div class="table-area">
                            <div class="table-responsive">
                                <table id="deactive_table"
                                        class="table table-borderless custom-table display text-left" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Buyer')}}</th>
                                        <th class="all">{{__('Seller')}}</th>
                                        <th class="all">{{__('Price')}}</th>
                                        <th class="all">{{__('Amount')}}</th>
                                        <th class="all">{{__('Status')}}</th>
                                        <th class="all">{{__('Created At')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
@endsection

@section('script')
    <script>
        (function($) {
            "use strict";

            function renderHistoryTable(url,table){
                $(table).DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 25,
                    responsive: true,
                    ajax: url,
                    // order: [7, 'desc'],
                    autoWidth: false,
                    language: {
                        paginate: {
                            next: 'Next &#8250;',
                            previous: '&#8249; Previous'
                        }
                    },
                    columns: [
                        {"data": "buyer"},
                        {"data": "seller"},
                        {"data": "price"},
                        {"data": "amount"},
                        {"data": "status"},
                        {"data": "created_at"},
                    ]
                });
            }
            renderHistoryTable('{{route('getGiftCardOrderHistory')}}/?status='+'all','#all_table');
        })(jQuery);
    </script>
@endsection
