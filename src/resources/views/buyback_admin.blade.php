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
        <form action="{{ route('buyback.admin-market') }}" method="post" id="admin-market-config" name="admin-market-config">
            <div class="card-body">
                {{ csrf_field() }}
                <p>Fill out the form below and press the add button to generate a new group config entry</p>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group pt-1">
                            <select class="groupsearch form-control input-xs" name="admin-market-groupId" id="admin-market-groupId"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group text-center mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="admin-market-operation" id="admin-market-operation" value="0" checked>
                                <label class="form-check-label" for="admin-market-operation"><i class="fas fa-arrow-down"></i></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="admin-market-operation" id="admin-market-operation-2" value="1">
                                <label class="form-check-label" for="admin-market-operation-2"><i class="fas fa-arrow-up"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input name="admin-market-percentage" id="admin-market-percentage" type="text" class=" form-control" placeholder="%" maxlength="3">
                    </div>
                    <div class="col">
                        <button id="submit" type="submit" class="btn btn-outline-success ml-2 form-control input-sm">
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
            <table class="table .table-sm">
                <thead>
                    <th colspan="5"></th>
                </thead>
                <thead>
                <th class="text-center">GroupName</th>
                <th class="text-center"><i class="fas fa-arrow-up"></i>/<i class="fas fa-arrow-down"></i> Jita</th>
                <th class="text-center">Percentage</th>
                <th class="text-center">GroupID</th>
                <th class="text-center">Actions</th>
                </thead>
                <tbody>
                @foreach($marketConfigs as $key => $config)
                    <form action="{{ route('buyback.admin-market-remove', ['groupId' => $config->groupId]) }}" method="get" id="admin-market-config-remove" name="admin-market-config-remove">
                        {{ csrf_field() }}
                        <tr>
                            <td class="align-middle">{{ \WipeOutInc\Seat\SeatBuyback\Models\BuybackMarketConfig::getGroupDetails($config->groupId)->groupName }}</td>
                            <td class="text-center align-middle">{!! $config->marketGroupType == 0 ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' !!}</td>
                            <td class="text-center align-middle">{{ $config->percentage }}%</td>
                            <td class="text-center align-middle">{{ $config->groupId }}</td>
                            <td class="text-center mb-4 mt-4 align-middle"><button class="btn btn-outline-danger btn-sm form-control" id="submit" type="submit">Remove</button></td>
                        </tr>
                    </form>
                @endforeach
                </tbody>
            </table>
            <br/>
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
                        <button id="submit" type="submit" class="btn btn-outline-success">
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
