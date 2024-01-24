@extends('admin.master')
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('sidebar')
@include('p2p::layouts.sidebar',['menu'=>'payment_method'])
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li class="active-item">{{__('Payment Method')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="user-management">
        <form action="{{ route('paymentMethodCreateProcess') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($uid ?? false)
                <input type="hidden" value="{{ $uid }}" name="uid" />
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Method Name") }}</label>
                            <input name="name" class="form-control" value="{{ isset($payment->name) ? $payment->name : old('name') }}" type="text" placeholder="{{ __("Payment method name") }}" />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Choose Payment Type") }}</label>
                            <div class="cp-select-area">
                                <select name="payment_type" class="form-control">
                                    <option @if(isset($payment->payment_type) && $payment->payment_type == PAYMENT_METHOD_BANK) selected @endif value="{{PAYMENT_METHOD_BANK}}">{{__("Bank Payment")}}</option>
                                    <option @if(isset($payment->payment_type) && $payment->payment_type == PAYMENT_METHOD_MOBILE) selected @endif value="{{PAYMENT_METHOD_MOBILE}}">{{__("Mobile Acount Payment")}}</option>
                                    <option @if(isset($payment->payment_type) && $payment->payment_type == PAYMENT_METHOD_CARD) selected @endif value="{{PAYMENT_METHOD_CARD}}">{{__("Card Payment")}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Select Country") }}</label>
                            <div class="cp-select-area">
                                <select name="country[]" id="selectpicker_country" class="selectpicker" data-width="100%" multiple data-live-search="true" data-actions-box="true">
                                    @if($country ?? false)
                                        @foreach($country as $country)
                                            <option value="{{ $country->key }}">{{ $country->value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Activation Status") }}</label>
                            <div class="cp-select-area">
                                <select name="status" class="form-control">
                                    <option @if(isset($payment['status']) && $payment->status == STATUS_ACTIVE) selected @endif value="{{STATUS_ACTIVE}}">{{__("ACTIVE")}}</option>
                                    <option @if(isset($payment['status']) && $payment->status == STATUS_REJECTED) selected @endif value="{{STATUS_REJECTED}}">{{__("INACTIVE")}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Short Note (Optional)") }}</label>
                            <textarea name="note" class="form-control" value="{{ isset($payment->note) ? $payment->note : old('note') }}" placeholder="{{ __("Note") }}" />{{ $payment->note ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="control-label">{{ __("Payment logo") }}</label>
                            <input data-default-file="{{ $payment->logo ?? '' }}" type="file" name="logo" class="form-control dropify" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-12 mt-20">
                        <button class="button-primary theme-btn">{{__('Update')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')

    <script>
        (function($) {
            var selectedCountrys = {!! ($payment->country ?? '[]') !!};
            $('#selectpicker_country').selectpicker('val', selectedCountrys);
        })(jQuery);
    </script>

@endsection
