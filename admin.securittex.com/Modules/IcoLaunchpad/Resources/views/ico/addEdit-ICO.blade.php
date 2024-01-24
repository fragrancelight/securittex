@extends('admin.master')
@section('title', isset($title) ? $title :  __('ICO Add'))
@section('style')
@endsection
@section('sidebar')
@include('icolaunchpad::layouts.sidebar',['menu'=>'ico_list'])
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-8">
                <ul>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    @if (isset($item) && $item->approved_status == STATUS_PENDING )
                        <a href="#accepted_ICO_Token" data-toggle="modal" class="add-btn theme-btn">{{__('Accept')}}</a>
                        <a href="#modification_ICO_Token" data-toggle="modal" class="add-btn theme-btn">{{__('Modification')}}</a>
                        <a href="#reject_ICO_Token" data-toggle="modal" class="add-btn theme-btn">{{__('Reject')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    @php($user = auth()->user())
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <div class="profile-info-form">
                    <div class="card-body">
                        <form action="{{route('storeUpdateICO')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if(isset($item))
                                <input type="hidden" name="id" value="{{$item->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="form_id">{{__('ICO Submit Form ID')}}</label>
                                        <input type="text" name="form_id" class="form-control" id="form_id" placeholder="{{__('ICO Submit Form ID')}}"
                                               @if(isset($item)) value="{{$item->form_id}}" @else value="{{old('form_id')}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="network">{{__('Network')}}</label>
                                        <select name="network" id="choose_network" class="form-control">
                                            <option value="">{{__('Select')}}</option>
                                            @foreach(api_settings() as $key => $value)
                                                @if (in_array($key,[ERC20_TOKEN,BEP20_TOKEN,TRC20_TOKEN]))
                                                    <option value="{{$key}}"
                                                    @if (isset($item))
                                                        {{$item->network == $key? 'selected':''}}
                                                    @else
                                                        {{old('network') == $key? 'selected':''}}
                                                    @endif>{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="chain_id">{{__('Base Coin')}}</label>
                                        <input class="form-control" type="text" id="base_coin_id" name="base_coin"
                                        @if(isset($item)) value="{{$item->base_coin}}" @else value="{{old('base_coin')}}" @endif readonly>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="chain_link">{{__('Chain Link')}}</label>
                                        <input type="text" name="chain_link" class="form-control" id="chain_link" placeholder="{{__('Chain Link')}}"
                                               @if(isset($item)) value="{{$item->chain_link}}" @else value="{{old('chain_link')}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="contract_address">{{__('Contract Address')}}</label>
                                        <input type="text" name="contract_address" class="form-control" id="contract_address" placeholder="{{__('Contract Address')}}"
                                               @if(isset($item)) value="{{$item->contract_address}}" @else value="{{old('contract_address')}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="wallet_address">{{__('Wallet Address')}}</label>
                                        <input type="text" name="wallet_address" class="form-control" id="wallet_address" placeholder="{{__('Wallet Address')}}"
                                               @if(isset($item)) value="{{$item->wallet_address}}" @else value="{{old('wallet_address')}}" @endif>
                                    </div>
                                </div>
                                @if (isset($item) && $user->id == $item->user_id)
                                    <div class="col-md-6 mt-20">
                                        <div class="form-group">
                                            <label for="wallet_private_key">{{__('Wallet Private Key')}}</label>
                                            <input type="password" name="wallet_private_key" class="form-control" id="wallet_private_key" placeholder="{{__('Wallet Private Key')}}"
                                                @if(isset($item)) value="{{decrypt($item->wallet_private_key)}}" @else value="{{old('wallet_private_key')}}" @endif>
                                        </div>
                                    </div>
                                @elseif(!isset($item))
                                    <div class="col-md-6 mt-20">
                                        <div class="form-group">
                                            <label for="wallet_private_key">{{__('Wallet Private Key')}}</label>
                                            <input type="password" name="wallet_private_key" class="form-control" id="wallet_private_key" placeholder="{{__('Wallet Private Key')}}"
                                                @if(isset($item)) value="{{$item->wallet_private_key}}" @else value="{{old('wallet_private_key')}}" @endif>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="#">{{__('Gas Limit')}}</label>
                                        <input type="text" name="gas_limit" class="form-control"
                                               @if(isset($item->gas_limit)) value="{{$item->gas_limit}}" @else value="73000" @endif>
                                    </div>
                                </div>


                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="coin_type">{{__('Coin Type')}}</label>
                                        <input type="text" name="coin_type" class="form-control" id="coin_type" placeholder="{{__('Coin Type')}}"
                                               @if(isset($item)) value="{{$item->coin_type}}" @else value="{{old('coin_type')}}" @endif readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="token_name">{{__('Token Name')}}</label>
                                        <input type="text" name="token_name" class="form-control" id="token_name" placeholder="{{__('Token Name')}}"
                                               @if(isset($item)) value="{{$item->token_name}}" @else value="{{old('token_name')}}" @endif readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="chain_id">{{__('Chain Id')}}</label>
                                        <input type="text" name="chain_id" class="form-control" id="chain_id" placeholder="{{__('Chain Id')}}"
                                               @if(isset($item)) value="{{$item->chain_id}}" @else value="{{old('chain_id')}}" @endif readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="decimal">{{__('Decimal')}}</label>
                                        <input type="text" name="decimal" class="form-control" id="decimal"
                                        @if(isset($item)) value="{{$item->decimal}}" @else value="{{old('decimal')}}" @endif readonly>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-group">
                                        <label for="website_link">{{__('Website Link')}} {{__('Optional')}}</label>
                                        <input type="text" name="website_link" class="form-control"
                                        @if(isset($item)) value="{{$item->website_link}}" @else value="{{old('website_link')}}" @endif>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-20">
                                            <div class="form-group">
                                                <label for="details_rule">{{__('Details Rule')}}  {{__('Optional')}}</label>
                                                <textarea name="details_rule" rows="4" class="form-control" >@if(isset($item)) {{$item->details_rule}} @else {{old('website_link')}} @endif</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-20">
                                            <div class="single-uplode">
                                                <label for="">{{__('Icon')}}</label>
                                                <div class="form-group buy_coin_address_input ">
                                                    <div id="file-upload" class="section-p">
                                                        <input type="file" name="image" value=""
                                                               id="file" ref="file" class="dropify"
                                                               @if(isset($item))  data-default-file="{{ $item->image_path}}" @endif />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (isset($item) && $user->id == $item->user_id)
                                    <div class="col-md-12">
                                        <button class="button-primary theme-btn">@if(isset($item)) {{__('Update')}} @else {{__('Save')}} @endif</button>
                                    </div>
                                @elseif(!isset($item))
                                    <div class="col-md-12">
                                        <button class="button-primary theme-btn">@if(isset($item)) {{__('Update')}} @else {{__('Save')}} @endif</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($item))
        <div id="accepted_ICO_Token" class="modal fade delete" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Accepted')}} </h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('acceptedICOToken')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>{{__('Are You sure? Want to accept it.')}}</p>
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <label for="">{{__('Message')}}:</label>
                            <textarea class="form-control" name="message" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                            <button class="btn btn-danger" type="submit">{{ __('Confirm')}}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div id="modification_ICO_Token" class="modal fade delete" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Modification')}} </h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('modificationICOToken')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>{{__('Are You sure? Need this token modification')}}</p>
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <label for="">{{__('Message')}}:</label>
                            <textarea class="form-control" name="message" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                            <button class="btn btn-danger" type="submit">{{ __('Confirm')}}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div id="reject_ICO_Token" class="modal fade delete" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Reject')}} </h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('rejectedICOToken')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>{{__('Are You sure? Want to reject it.')}}</p>
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <label for="">{{__('Message')}}:</label>
                            <textarea class="form-control" name="message" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                            <button class="btn btn-danger" type="submit">{{ __('Confirm')}}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
   <script>
     (function($) {
            "use strict";
            $('#choose_network').on('change',function(){
                var chooseNetworkValue = $('#choose_network').val();
                if(chooseNetworkValue == {{ERC20_TOKEN}})
                {
                    $('#base_coin_id').val('ETH');

                }else if(chooseNetworkValue == {{BEP20_TOKEN}})
                {
                    $('#base_coin_id').val('BNB');
                }

            });

            $('#contract_address').focusin(function(){
                var chainLink = $('#chain_link').val();

                if(chainLink =='')
                {
                    VanillaToasts.create({
                        text: '{{__("Please, Provide Chain Link First!")}}',
                        type: 'warning',
                        timeout: 4000
                    });

                    $('#chain_link').focus();
                    $('#contract_address').val('');
                }
            });
            $('#contract_address').focusout(function(){
                var chainLink = $('#chain_link').val();

                var contactAddress = $('#contract_address').val();
                if(chainLink !=null && contactAddress != null)
                {
                    console.log('id');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getAddressDettailsApi') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'contract_address': contactAddress,
                            'chain_link':chainLink
                        },
                        success: function (data) {

                            if(data.success == true)
                            {
                                VanillaToasts.create({
                                    text: '{{__("your address is valid")}}',
                                    type: 'success',
                                    timeout: 4000
                                });
                                $('#coin_type').val(data.data.symbol);
                                $('#token_name').val(data.data.name);
                                $('#chain_id').val(data.data.chain_id);
                                $('#decimal').val(data.data.token_decimal);
                                console.log(data.data.name);
                            }else{
                                VanillaToasts.create({
                                    text: data.message,
                                    type: 'warning',
                                    timeout: 4000
                                });

                            }
                        }
                    });
                }

            });
        })(jQuery);
   </script>
@endsection
