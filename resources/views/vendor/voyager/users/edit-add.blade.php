@extends('voyager::master')

@section('page_title', (isset($dataTypeContent->id) ? 'Edycja' : 'Dodawanie').' '. __('użytkownika'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ (isset($dataTypeContent->id) ? 'Edycja' : 'Dodawanie').' '. __('użytkownika') }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered panel-primary">
                    {{-- <div class="panel"> --}}
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
                            <h3 class="panel-title"><i class="icon voyager-person"></i> {{ __('Dane użytkownika') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="first_name">{{ __('Imię') }}</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{ __('Imię') }}"
                                           value="{{ old('first_name', $dataTypeContent->first_name ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">{{ __('Nazwisko') }}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{ __('Nazwisko') }}"
                                               value="{{ old('last_name', $dataTypeContent->last_name ?? '') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pesel_number">{{ __('Numer PESEL') }}</label>
                                <input type="text" class="form-control" id="pesel_number" name="pesel_number" placeholder="{{ __('Numer PESEL') }}"
                                       value="{{ old('pesel_number', $dataTypeContent->pesel_number ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="birth_date">{{ __('Data urodzenia') }}</label>
                                <input type="date" class="form-control" name="birth_date" id="birth_date"
                                       placeholder="{{ __('Wybierz datę urodzenia') }}"
                                       value="@if(isset($dataTypeContent->birth_date)){{ \Carbon\Carbon::parse(old('birth_date', $dataTypeContent->birth_date))->format('Y-m-d') }}@else{{old('birth_date')}}@endif">

                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Adres e-mail') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Adres e-mail') }}"
                                       value="{{ old('email', $dataTypeContent->email ?? '') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="street">{{ __('Ulica') }}</label>
                                    <input type="text" class="form-control" id="street" name="street" placeholder="{{ __('Ulica') }}"
                                           value="{{ old('street', $dataTypeContent->street ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="street_number">{{ __('Numer domu/mieszkania') }}</label>
                                    <input type="text" class="form-control" id="street_number" name="street_number" placeholder="{{ __('Numer domu/mieszkania') }}"
                                           value="{{ old('street_number', $dataTypeContent->street_number ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="city">{{ __('Miejscowość') }}</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="{{ __('Miejscowość') }}"
                                           value="{{ old('city', $dataTypeContent->city ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="zip">{{ __('Kod pocztowy') }}</label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="{{ __('Kod pocztowy') }}"
                                           value="{{ old('zip', $dataTypeContent->zip ?? '') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="voivodeship_id">{{ __('Województwo') }}</label>
                                <select class="form-control select2" name="voivodeship_id" id="voivodeship_id">
                                    @foreach(\App\Models\Voivodeship::all() as $voivodeship)
                                        <option value="{{ $voivodeship->id }}" @if(isset($dataTypeContent->voivodeship_id) && $dataTypeContent->voivodeship_id == $voivodeship->id) selected="selected"@endif>{{ $voivodeship->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-params"></i> {{ __('Dane systemowe') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                    $row     = $dataTypeRows->where('field', 'status')->first();
                                    $options = $row->details;
                                @endphp
                                @include('voyager::formfields.select_dropdown')
                            </div>
                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">{{ __('Rola użytkownika') }}</label>
                                    @php
                                        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                        $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                                <div class="form-group">
                                    <label for="additional_roles">{{ __('Dodatkowe role') }}</label>
                                    @php
                                        $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                            @endcan
                            @php
                                if (isset($dataTypeContent->locale)) {
                                    $selected_locale = $dataTypeContent->locale;
                                } else {
                                    $selected_locale = config('app.locale', 'en');
                                }

                            @endphp
                            <div class="form-group">
                                <label for="locale">{{ __('Język panelu') }}</label>
                                <select class="form-control select2" id="locale" name="locale">
                                    @foreach (Voyager::getLocales() as $locale)
                                        <option value="{{ $locale }}"
                                            {{ ($locale == $selected_locale ? 'selected' : '') }}>{{ $locale }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon voyager-polaroid"></i> {{ __('Zdjęcie profilowe') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
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
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop
