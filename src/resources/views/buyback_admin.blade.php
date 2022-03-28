@extends('web::layouts.grids.6-6')

@section('title', trans('buyback::global.admin_browser_title'))
@section('page_header', trans('buyback::global.admin_page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('left')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Group Config</h3>
        </div>
        <form action="{{ route('buyback.admin-update') }}" method="post" id="admin-update" name="admin-update">
            <div class="card-body">
                <p>Fill out the form below and press the add button to generate a new group config entry</p>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group pt-1">
                            <select class="groupsearch form-control input-xs" name="groupsearch"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group text-center mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                <label class="form-check-label" for="inlineRadio1"><i class="fas fa-arrow-down"></i></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2"><i class="fas fa-arrow-up"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input id="admin_price_cache_time" name="admin_price_cache_time" type="text" class=" form-control" placeholder="%" maxlength="3">
                    </div>
                    <div class="col">
                        <button id="submit" type="submit" class="btn btn-info ml-2 form-control input-sm">
                            <i class="fas fa-check"></i>
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Group Overview</h3>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="border rounded-left shadow-sm p-2 mb-2 bg-white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row pl-3">
                                <div class="col-md-* bg-info rounded-circle p-3 mr-3 align-middle text-center text-bold percentage-info">22%</div>
                                <div class="col-md-* text-center my-auto mr-3"><i class="fas fa-arrow-down"></i></div>
                                <div class="col-md-8 my-auto"><b>Asteroid Blood Raiders BattleCruiser</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-left shadow-sm p-2 mb-2 bg-white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row pl-3">
                                <div class="col-md-* bg-info rounded-circle p-3 mr-3 align-middle text-center text-bold percentage-info">5%</div>
                                <div class="col-md-* text-center my-auto mr-3"><i class="fas fa-arrow-down"></i></div>
                                <div class="col-md-8 my-auto"><b>Rare Moon Asteroids</b></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="border rounded-left shadow-sm p-2 mb-2 bg-white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row pl-3">
                                <div class="col-md-* bg-info rounded-circle p-3 mr-3 align-middle text-center text-bold percentage-info">9%</div>
                                <div class="col-md-* text-center my-auto mr-3"><i class="fas fa-arrow-down"></i></div>
                                <div class="col-md-8 my-auto"><b>Shield Resistance Shift Hardener Blueprint</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-left shadow-sm p-2 mb-2 bg-white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row pl-3">
                                <div class="col-md-* bg-info rounded-circle p-3 mr-3 align-middle text-center text-bold percentage-info">7%</div>
                                <div class="col-md-* text-center my-auto mr-3"><i class="fas fa-arrow-down"></i></div>
                                <div class="col-md-8 my-auto"><b>Exceptional Moon Asteroids</b></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

@stop

@section('right')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buyback Plugin Settings</h3>
        </div>
        <form action="{{ route('buyback.admin-update') }}" method="post" id="admin-update" name="admin-update">
            <div class="card-body">
                {{ csrf_field() }}
                <div class="box-body">
                    <legend>General</legend>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="admin_price_cache_time">Price Cache Time</label>
                    <div class="col-md-6">
                        <input id="admin_price_cache_time" name="admin_price_cache_time" type="number" class="form-control input-md" placeholder="In seconds" value="{{ $settings["admin_price_cache_time"] }}">
                        <p class="form-text text-muted mb-0">
                            Please enter the time in seconds that items prices should be cached.
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="admin_max_allowed_items">Max Items Allowed</label>
                    <div class="col-md-6">
                        <input id="admin_max_allowed_items" name="admin_max_allowed_items" type="number" class="form-control input-md" value="{{ $settings["admin_max_allowed_items"] }}">
                        <p class="form-text text-muted mb-0">
                            Please enter the maximum number of items that are allowed per request
                        </p>
                    </div>
                </div>
                <div class="box-body">
                    <legend>Contract</legend>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="admin_contract_contract_to">Contract to</label>
                    <div class="col-md-6">
                        <input id="admin_contract_contract_to" name="admin_contract_contract_to" type="text" class="form-control input-md" value="{{ $settings["admin_contract_contract_to"] }}">
                        <p class="form-text text-muted mb-0">
                            Enter the name of the character that should be in the "Contract to" field
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="admin_contract_expiration">Expiration</label>
                    <div class="col-md-6">
                        <input id="admin_contract_expiration" name="admin_contract_expiration" type="text" class="form-control input-md" value="{{ $settings["admin_contract_expiration"] }}">
                        <p class="form-text text-muted mb-0">
                            Choose a contract expiration option
                        </p>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label" for="submit"></label>
                    <div class="col-md-4">
                        <button id="submit" type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('javascript')
    <script>

        $('.groupsearch').select2({
            placeholder: 'Select group',
            ajax: {
                url: '/autocomplete',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    </script>
@endpush
