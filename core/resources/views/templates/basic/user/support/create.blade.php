@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="message__chatbox bg--section">

        <div class="message__chatbox__body">
            <form class="message__chatbox__form row" action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                @csrf
                <div class="form--group col-sm-6">
                    <label for="name" class="form--label">@lang('Name')</label>
                    <input type="text" name="name" id="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form--control" readonly>
                </div>
                <div class="form--group col-sm-6">
                    <label for="email" class="form--label">@lang('Email address')</label>
                    <input type="email" name="email" id="" value="{{@$user->email}}" class="form-control form--control" readonly>
                </div>
                <div class="form--group col-sm-6">
                    <label for="subject" class="form--label">@lang('Subject')</label>
                    <input type="text" name="subject" id="subject" value="{{old('subject')}}" class="form-control form--control">
                </div>
                <div class="form--group col-sm-6">
                    <label for="subject" class="form--label">@lang('Priority')</label>
                    <div class="select-item">
                        <select name="priority" id="select" class="form--control select-bar m-0">
                            <option value="3">@lang('High')</option>
                            <option value="2">@lang('Medium')</option>
                            <option value="1">@lang('Low')</option>
                        </select>
                    </div>
                </div>
                <div class="form--group col-sm-12">
                    <label for="inputMessage" class="form--label">@lang('Message')</label>
                    <textarea name="message" id="inputMessage" rows="6" class="form-control form--control">{{old('message')}}</textarea>
                </div>
                <div class="form--group col-sm-12">
                    <div class="d-flex">
                        <div class="left-group col p-0">
                            <label for="file" class="form--label">@lang('Attachments')</label>
                            <input type="file" class="overflow-hidden form-control form--control mb-2" name="attachments[]" id="inputAttachments">
                            <span class="info fs--14">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </span>
                        </div>
                        <div class="add-area">
                            <label class="form--label d-block">&nbsp;</label>
                            <button class="cmn--btn btn--sm bg--primary form--control ms-2 ms-md-4 addFile" type="button"><i class="las la-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div id="fileUploadsContainer"></div>

                <div class="form--group col-sm-12 mt-2 mb-0">
                    <button type="submit" class="cmn--btn btn--lg">@lang('Create Ticket')</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="form--group col-sm-12">
                    <div class="d-flex">
                        <div class="left-group col p-0">
                            <input type="file" class="overflow-hidden form-control form--control mb-2" name="attachments[]" id="inputAttachments">
                        </div>
                        <div class="add-area">
                            <button class="cmn--btn btn--sm bg-danger form--control ms-2 ms-md-4 remove-btn" type="button"><i class="las la-times"></i></button>
                        </div>
                    </div>
                </div>`
                )
            });

            $(document).on('click','.remove-btn',function(){
                $(this).closest('.form--group').remove();
            });
        })(jQuery);
    </script>
@endpush
