@extends('voyager::master')

@section('page_title', __('Wyświetlanie operacji'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('Wyświetlanie operacji') }}

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                {{ __('voyager::generic.edit') }}
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
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
                    <!-- ### NADAWCA I ODBIORCA PRZELEWU ### -->
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="fullname">{{ __('Imię i nazwisko') }}</label>
                            <input type="text" class="form-control" id="fullname" readonly
                                @if(isset($dataTypeContent->fromClientBankAccount))
                                    value="{{ $dataTypeContent->fromClientBankAccount->user->FullName }}">
                                @elseif(isset($dataTypeContent->toClientBankAccount))
                                    value="{{ $dataTypeContent->toClientBankAccount->user->FullName }}">
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="pesel_number">{{ __('PESEL') }}</label>
                            <input type="text" class="form-control" id="pesel_number" readonly
                                @if(isset($dataTypeContent->fromClientBankAccount))
                                    value="{{ $dataTypeContent->fromClientBankAccount->user->pesel_number }}">
                                @elseif(isset($dataTypeContent->toClientBankAccount))
                                    value="{{ $dataTypeContent->toClientBankAccount->user->pesel_number }}">
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="FullAddress">{{ __('Adres zamieszkania') }}</label>
                            <input type="text" class="form-control" id="FullAddress" readonly
                                @if(isset($dataTypeContent->fromClientBankAccount))
                                    value="{{ $dataTypeContent->fromClientBankAccount->user->FullAddress }}">
                                @elseif(isset($dataTypeContent->toClientBankAccount))
                                    value="{{ $dataTypeContent->toClientBankAccount->user->FullAddress }}">
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Adres e-mail') }}</label>
                            <input type="text" class="form-control" id="email" readonly
                                @if(isset($dataTypeContent->fromClientBankAccount))
                                    value="{{ $dataTypeContent->fromClientBankAccount->user->email }}">
                                @elseif(isset($dataTypeContent->toClientBankAccount))
                                    value="{{ $dataTypeContent->toClientBankAccount->user->email }}">
                                @endif
                        </div>
                    </div>
                </div>
                <div class="panel">
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
                                            <input type="text" class="form-control" id="sender_name" value="{{ $dataTypeContent->transaction->sender_name ?? '' }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="sender_address">{{ __('Adres nadawcy') }}</label>
                                            <input type="text" class="form-control" id="sender_address" value="{{ $dataTypeContent->transaction->sender_address ?? '' }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="sender_iban">{{ __('Numer rachunku nadawcy') }}</label>
                                            <input type="text" class="form-control" id="sender_iban"  value="{{ $dataTypeContent->transaction->sender_iban ?? '' }}" readonly>
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
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>
@stop
