@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
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
                            <h3 class="panel-title">
                                <i class="voyager-receipt"></i> Nadawca i odbiorca przelewu
                                <span class="panel-desc"> Uzupełnij dane dodawanego do systemu przelewu.</span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="row">
                            <!-- ### NADAWCA I ODBIORCA PRZELEWU ### -->
                            <div class="col-md-6">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="voyager-person"></i><i class="voyager-angle-right"></i><i class="voyager-dollar"></i> Nadawca przelewu
                                        <span class="panel-desc"> Dane nadawcy przelewu</span>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group @error('sender_name') has-error @enderror">
                                        <label for="sender_name">{{ __('Nazwa nadawcy') }}</label>
                                        <input type="text" class="form-control @error('sender_name') has-error @enderror" id="sender_name" name="sender_name" value="{{ old('sender_name', $dataTypeContent->sender_name ?? '') }}">
                                        @error('sender_name')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('sender_address') has-error @enderror">
                                        <label for="sender_address">{{ __('Adres nadawcy') }}</label>
                                        <input type="text" class="form-control @error('sender_address') has-error @enderror" id="sender_address" name="sender_address" value="{{ old('sender_address', $dataTypeContent->sender_address ?? '') }}">
                                        @error('sender_address')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('sender_iban') has-error @enderror">
                                        <label for="sender_iban">{{ __('Numer rachunku nadawcy') }}</label>
                                        <br>
                                        <small>{{ __('Wprowadź pełny numer IBAN bez spacji.') }}</small>
                                        <input type="text" class="form-control @error('sender_iban') has-error @enderror" id="sender_iban" name="sender_iban" value="{{ old('sender_iban', $dataTypeContent->sender_iban ?? '') }}">
                                        @error('sender_iban')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="voyager-dollar"></i><i class="voyager-angle-right"></i><i class="voyager-person"></i> Odbiorca przelewu
                                        <span class="panel-desc"> Dane odbiorcy przelewu</span>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group @error('recipient_name') has-error @enderror">
                                        <label for="recipient_name">{{ __('Nazwa odbiorcy') }}</label>
                                        <input type="text" class="form-control @error('recipient_name') has-error @enderror" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $dataTypeContent->recipient_name ?? '') }}">
                                        @error('recipient_name')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('recipient_address') has-error @enderror">
                                        <label for="recipient_address">{{ __('Adres odbiorcy') }}</label>
                                        <input type="text" class="form-control @error('recipient_address') has-error @enderror" id="recipient_address" name="recipient_address" value="{{ old('recipient_address', $dataTypeContent->recipient_address ?? '') }}">
                                        @error('recipient_address')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('recipient_iban') has-error @enderror">
                                        <label for="recipient_iban">{{ __('Numer rachunku odbiorcy') }}</label>
                                        <br>
                                        <small>{{ __('Wprowadź pełny numer IBAN bez spacji.') }}</small>
                                        <input type="text" class="form-control @error('recipient_iban') has-error @enderror" id="recipient_iban" name="recipient_iban" value="{{ old('recipient_iban', $dataTypeContent->recipient_iban ?? '') }}">
                                        @error('recipient_iban')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-dollar"></i> {{ __('Tytuł przelewu') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group @error('title') has-error @enderror">
                                <label for="title">{{ __('Tytuł przelewu') }}</label>
                                <br>
                                <small>{{ __('Wprowadź tytuł przelewu.') }}</small>
                                <input type="text" class="form-control @error('title') has-error @enderror" id="title" name="title" value="{{ old('title', $dataTypeContent->title ?? '') }}">
                                @error('title')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-dollar"></i> {{ __('Kwota przelewu') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group @error('amount') has-error @enderror">
                                <label for="amount">{{ __('Kwota przelewu (zł)') }}</label>
                                <br>
                                <small>{{ __('Wprowadź kwotę przelewu (tylko liczbę).') }}</small>
                                <input type="number" class="form-control @error('amount') has-error @enderror" step="0.01" min="0" id="amount" name="amount" value="{{ old('amount', $dataTypeContent->amount ?? '') }}">
                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('currency') has-error @enderror">
                                <label for="currency">{{ __('Waluta') }}</label>
                                <br>
                                <small>{{ __('W chwili obecnej operujemy tylko w PLN.') }}</small>
                                <input type="text" class="form-control @error('currency') has-error @enderror" id="currency" name="currency" value="{{ old('currency', $dataTypeContent->currency ?? 'PLN') }}">
                                @error('currency')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save">
                {{ __('voyager::generic.save') }}
            </button>
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
