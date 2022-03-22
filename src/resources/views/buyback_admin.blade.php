@extends('web::layouts.grids.6-6')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@section('left')
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

@section('right')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Purchase Settings</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <select class="groupsearch form-control" name="groupsearch"></select>
            </div>
        </div>
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
