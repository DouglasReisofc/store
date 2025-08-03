@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card h-100">
                    <div class="card-header p-4">
                        <div class="card-title"><h4>{{__($pageTitle)}}</h4></div>
                    </div>
                    <div class="card-body  ">
                        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="text-center mt-2">@lang('You have requested') <b class="text--base">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                        <b class="text--base">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                    </p>
                                    <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                    <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                                    <br>
                                </div>

                                @if($method->gateway_parameter)

                                    @foreach(json_decode($method->gateway_parameter) as $k => $v)

                                        @if($v->type == "text")
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="form--label"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <input type="text" class="form-control form--control" name="{{$k}}" value="{{old($k)}}">
                                                </div>
                                            </div>
                                        @elseif($v->type == "textarea")
                                                <div class="col-md-12 mb-4">
                                                    <div class="form-group">
                                                        <label class="form--label"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <textarea name="{{$k}}" class="form-control form--control" rows="3">{{old($k)}}</textarea>
                                                    </div>
                                                </div>
                                        @elseif($v->type == "file")
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="form--label"><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <br>

                                                    <div class="fileinput fileinput-new " data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail withdraw-thumbnail" data-trigger="fileinput">
                                                            <img src="{{ asset(getImage('/')) }}" alt="@lang('Image')">
                                                        </div>

                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>

                                                        <div class="img-input-div">
                                                            <span class="btn btn-info btn-file">
                                                                <span class="fileinput-new "> @lang('Select') {{__($v->field_level)}}</span>
                                                                <span class="fileinput-exists"> @lang('Change')</span>
                                                                <input type="file" name="{{$k}}" accept="image/*" >
                                                            </span>
                                                            <a href="#" class="btn btn-danger fileinput-exists"
                                                            data-dismiss="fileinput"> @lang('Remove')</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="cmn--btn w-100 justify-content-center">@lang('Pay Now')</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
<style>
    .fileinput .thumbnail {
        width: 100%;
        max-width: 300px;
    }
    .fileinput .thumbnail img {
        width: 100%;
    }
</style>
@endpush

@push('script-lib')
<script src="{{asset($activeTemplateTrue.'/js/bootstrap-fileinput.js')}}"></script>
@endpush

@push('style-lib')
<link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">
@endpush

@push('script')
<script>

    (function($){

        "use strict";

            $('.withdraw-thumbnail').hide();

            $('.clickBtn').on('click', function() {

                var classNmae = $('.fileinput').attr('class');

                if(classNmae != 'fileinput fileinput-exists'){
                    $('.withdraw-thumbnail').hide();
                }else{
                    $('.withdraw-thumbnail').show();
                }

            });

    })(jQuery);

</script>
@endpush
