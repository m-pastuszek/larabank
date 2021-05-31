@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', ($edit ? 'Edycja' : 'Tworzenie') . ' operacji')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ ($edit ? 'Edycja' : 'Tworzenie') . ' operacji' }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="page-content read container-fluid">
    <form class="form-edit-add"
          role="form"
          action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
          method="POST" enctype="multipart/form-data">
        <!-- PUT Method if we are editing -->
        @if($edit)
            {{ method_field("PUT") }}
        @endif
            {{ csrf_field() }}

        <div class="row">
            <div class="col-md-8">
                <div class="panel">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon voyager-receipt"></i> {{ __('Nadawca i odbiorca przelewu') }}</h3>
                        <div class="panel-actions">
                            <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                        </div>
                    </div>
                <div class="panel-body">
                    <div class="row">
                    @if($dataTypeContent->operation_type_id == 1) {{-- Jeśli operacja zewnętrzna --}}
                    <!-- ### NADAWCA I ODBIORCA PRZELEWU ### -->
                        <div class="col-md-6">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="voyager-person"></i><i class="voyager-angle-right"></i><i class="voyager-dollar"></i> Nadawca przelewu
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="sender_name">{{ __('Nazwa nadawcy') }}</label>
                                    <input type="text" class="form-control" id="sender_name" value="{{ $dataTypeContent->transaction->sender_name ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="sender_address">{{ __('Adres nadawcy') }}</label>
                                    <input type="text" class="form-control" id="sender_address" value="{{ $dataTypeContent->transaction->sender_address ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="sender_iban">{{ __('Numer rachunku nadawcy') }}</label>
                                    <input type="text" class="form-control" id="sender_iban"  value="{{ $dataTypeContent->transaction->sender_iban ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="voyager-dollar"></i><i class="voyager-angle-right"></i><i class="voyager-person"></i> Odbiorca przelewu
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="recipient_name">{{ __('Nazwa odbiorcy') }}</label>
                                    <input type="text" class="form-control" id="recipient_name" value="{{ $dataTypeContent->transaction->recipient_name ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="recipient_address">{{ __('Adres odbiorcy') }}</label>
                                    <input type="text" class="form-control" id="recipient_address" value="{{ $dataTypeContent->transaction->recipient_address ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="recipient_iban">{{ __('Numer rachunku odbiorcy') }}</label>
                                    <input type="text" class="form-control" id="recipient_iban" value="{{ $dataTypeContent->transaction->recipient_iban ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                    @elseif($dataTypeContent->operation_type_id == 2) {{-- Jeśli operacja wewnętrzna --}}
                    <!-- ### INFORMACJE O PRZELEWIE ### -->
                        <div class="col-md-6">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="voyager-wallet"></i><i class="voyager-angle-right"></i><i class="voyager-dollar"></i> Z rachunku
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="from_bank_product_name">{{ __('Nazwa rachunku') }}</label>
                                    <input type="text" class="form-control" id="from_bank_product_name" value="{{ $dataTypeContent->fromClientBankAccount->bankProduct->name ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="from_iban">{{ __('Numer rachunku') }}</label>
                                    <input type="text" class="form-control" id="from_iban" value="{{ $dataTypeContent->fromClientBankAccount->FormattedIban ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="voyager-dollar"></i><i class="voyager-angle-right"></i><i class="voyager-wallet"></i> Na rachunek
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="to_bank_product_name">{{ __('Nazwa rachunku') }}</label>
                                    <input type="text" class="form-control" id="to_bank_product_name" value="{{ $dataTypeContent->toClientBankAccount->bankProduct->name ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="to_iban">{{ __('Numer rachunku') }}</label>
                                    <input type="text" class="form-control" id="to_iban" value="{{ $dataTypeContent->toClientBankAccount->FormattedIban ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ### KWOTA OPERACJI ### -->
        <div class="col-md-4">
            <div class="panel panel panel-bordered panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="icon voyager-dollar"></i> {{ __('Informacje o operacji') }}</h3>
                    <div class="panel-actions">
                        <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="operation_type_id">{{ __('Typ operacji') }}</label>
                        <select class="form-control select2" name="operation_type_id" id="operation_type_id" disabled>
                            @foreach(\App\Models\OperationType::all() as $operationType)
                                <option value="{{ $operationType->id }}"@if(isset($dataTypeContent->operation_type_id) && $dataTypeContent->operation_type_id == $operationType->id) selected="selected"@endif>{{ $operationType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="operation_status_id">{{ __('Status operacji') }}</label>
                        <select class="form-control select2" id="operation_status_id" disabled>
                            @foreach(\App\Models\OperationStatus::all() as $operationStatus)
                                <option value="{{ $operationStatus->id }}"@if(isset($dataTypeContent->status_id) && $dataTypeContent->status_id == $operationStatus->id) selected="selected"@endif>{{ $operationStatus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transaction_title">{{ __('Tytuł przelewu') }}</label>
                        <input type="text" class="form-control" id="transaction_title" value="{{ $dataTypeContent->transaction->title ?? '' }}" readonly>
                    </div>
                </div>
            </div>
            <div class="panel panel panel-bordered panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="icon voyager-dollar"></i> {{ __('Kwota operacji') }}</h3>
                    <div class="panel-actions">
                        <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="amount">{{ __('Kwota przelewu') }}</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ $dataTypeContent->transaction->FormattedAmount ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="currency">{{ __('Waluta') }}</label>
                        <input type="text" class="form-control" id="currency" name="currency" value="{{ $dataTypeContent->transaction->currency ?? '' }}" readonly>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</div>




    <div class="page-content container-fluid">
        <form class="form-edit-add"
              role="form"
              action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-receipt"></i> {{ __('Informacje o Kliencie') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                @if($dataTypeContent->operation_type_id == 1) {{-- Jeśli operacja zewnętrzna --}}

                                @elseif($dataTypeContent->operation_type_id == 2) {{-- Jeśli operacja wewnętrzna --}}
                                    @php
                                        $client = \App\Models\User::where('id', $dataTypeContent->from_bank_account_id)->first();
                                    @endphp
                                    <div class="form-group">
                                        <label for="FullName">{{ __('Imię i nazwisko') }}</label>
                                        <input type="text" class="form-control" id="FullName" name="FullName" value="{{ $client->FullName ?? '' }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-receipt"></i> {{ __('Informacje o przelewie') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="operation_type_id">{{ __('Typ operacji') }}</label>
                                <select class="form-control" name="operation_type_id" id="operation_type_id" disabled>
                                    @foreach(\App\Models\OperationType::all() as $operationType)
                                        <option value="{{ $operationType->id }}"@if(isset($dataTypeContent->operation_type_id) && $dataTypeContent->operation_type_id == $operationType->id) selected="selected"@endif>{{ $operationType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">

                                <!-- ### NADAWCA I ODBIORCA PRZELEWU ### -->
                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="voyager-person"></i><i class="voyager-angle-right"></i><i class="voyager-dollar"></i> Nadawca przelewu
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="sender_name">{{ __('Nazwa nadawcy') }}</label>
                                            <input type="text" class="form-control" id="sender_name" name="sender_name" value="{{ $dataTypeContent->transaction->sender_name ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sender_address">{{ __('Adres nadawcy') }}</label>
                                            <input type="text" class="form-control" id="sender_address" name="sender_address" value="{{ $dataTypeContent->transaction->sender_address ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="sender_iban">{{ __('Numer rachunku nadawcy') }}</label>
                                            <input type="text" class="form-control" id="sender_iban" name="sender_iban" readonly value="{{ $dataTypeContent->transaction->sender_iban ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="voyager-dollar"></i><i class="voyager-angle-right"></i><i class="voyager-person"></i> Odbiorca przelewu
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="recipient_name">{{ __('Nazwa odbiorcy') }}</label>
                                            <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ $dataTypeContent->transaction->recipient_name ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient_address">{{ __('Adres odbiorcy') }}</label>
                                            <input type="text" class="form-control" id="recipient_address" name="recipient_address" value="{{ $dataTypeContent->transaction->recipient_address ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient_iban">{{ __('Numer rachunku odbiorcy') }}</label>
                                            <input type="text" class="form-control" id="recipient_iban" name="recipient_iban" readonly value="{{ $dataTypeContent->transaction->recipient_iban ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-dollar"></i> {{ __('Kwota operacji') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="amount">{{ __('Kwota przelewu') }}</label>
                                <input type="text" class="form-control" id="amount" name="amount" value="{{ $dataTypeContent->transaction->FormattedAmount ?? '' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="currency">{{ __('Waluta') }}</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="{{ $dataTypeContent->transaction->currency ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
            <input name="image" id="upload_file" type="file"
                     onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
            {{ csrf_field() }}
        </form>

    </div>


    {{-- <div class="panel-footer">
         @section('submit-buttons')
             <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
         @stop
         @yield('submit-buttons')
     </div>--}}

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
