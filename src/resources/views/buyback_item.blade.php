@extends('web::layouts.grids.12')

@section('title', trans('buyback::global.contract_browser_title'))
@section('page_header', trans('buyback::global.contract_page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('buyback::global.admin_title') }}</h3>
                </div>
                <form action="{{ route('buyback.item.market.add') }}" method="post" id="admin-market-config" name="admin-market-config">
                    <div class="card-body">
                        {{ csrf_field() }}
                        <p>{{ trans('buyback::global.admin_description') }}</p>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="admin_price_cache_time">{{ trans('buyback::global.admin_item_select_label') }}</label>
                            <div class="col-md-6">
                                <select class="groupsearch form-control input-xs" name="admin-market-typeId" id="admin-market-typeId"></select>
                                <p class="form-text text-muted mb-0">
                                    {{ trans('buyback::global.admin_item_select_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="admin-market-operation"><i class="fas fa-arrow-down"></i>/<i class="fas fa-arrow-up"></i>{{ trans('buyback::global.admin_item_jita_label') }}</label>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="admin-market-operation" id="admin-market-operation" value="0" checked>
                                        <label class="form-check-label" for="admin-market-operation"><i class="fas fa-arrow-down"></i>{{ trans('buyback::global.admin_group_table_jita') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="admin-market-operation" id="admin-market-operation-2" value="1">
                                        <label class="form-check-label" for="admin-market-operation-2"><i class="fas fa-arrow-up"></i>{{ trans('buyback::global.admin_group_table_jita') }}</label>
                                    </div>
                                </div>
                                <p class="form-text text-muted mb-0">
                                    {{ trans('buyback::global.admin_item_jita_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="admin-market-price">{{ trans('buyback::global.admin_item_price_label') }}</label>
                            <div class="col-md-6">
                                <input name="admin-market-price" id="admin-market-price" type="number" class="form-control w-50" min="0" max="99999999999" value="0">
                                <p class="form-text text-muted mb-0">
                                    {{ trans('buyback::global.admin_item_price_description') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="admin-market-percentage">{{ trans('buyback::global.admin_item_percentage_label') }}</label>
                            <div class="col-md-6">
                                <input name="admin-market-percentage" id="admin-market-percentage" type="number" class="form-control w-25" min="1" max="100" value="1" maxlength="2">
                                <p class="form-text text-muted mb-0">
                                    {{ trans('buyback::global.admin_item_percentage_description') }}
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
                                    Add Item
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('buyback::global.admin_group_title') }}</h3>
                </div>
                <div class="card-body">
                    <table id="items" class="table .table-sm">
                        <thead>
                        <th>{{ trans('buyback::global.admin_group_table_item_name') }}</th>
                        <th class="text-center"><i class="fas fa-arrow-down"></i>/<i class="fas fa-arrow-up">{{ trans('buyback::global.admin_group_table_jita') }}</th>
                        <th class="text-center">{{ trans('buyback::global.admin_group_table_percentage') }}</th>
                        <th class="text-center">{{ trans('buyback::global.admin_group_table_price') }}</th>
                        <th>{{ trans('buyback::global.admin_group_table_market_name') }}</th>
                        <th class="text-center">{{ trans('buyback::global.admin_group_table_actions') }}</th>
                        </thead>
                        <tbody>
                        @if (count($marketConfigs) > 0)
                            @foreach($marketConfigs as $key => $config)
                                <tr>
                                    <form action="{{ route('buyback.item.market.remove', ['typeId' => $config->typeId]) }}" method="get" id="admin-market-config-remove" name="admin-market-config-remove">
                                        {{ csrf_field() }}
                                    <td class="align-middle">{{ $config->typeName}}</td>
                                    <td class="text-center align-middle">{!! $config->marketOperationType == 0 ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' !!}</td>
                                    <td class="text-center align-middle">{{ ($config->price <= 0) ? $config->percentage . " %" : "-" }}</td>
                                    <td class="text-center align-middle">{{ ($config->price > 0) ? number_format($config->price,0,',', '.') . " ISK" : "-"}}</td>
                                    <td class="align-middle">{{ $config->groupName }}</td>
                                    <td class="text-center mb-4 mt-4 align-middle"><button class="btn btn-danger btn-xs form-control" id="submit" type="submit"><i class="fas fa-trash-alt"></i>{{ trans('buyback::global.admin_group_table_button') }}</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <br/>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script>
        $('.groupsearch').select2({
            placeholder: '{{ trans('buyback::global.admin_select_placeholder') }}',
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

        $(document).ready( function () {
            $('#items').DataTable({
                columnDefs: [
                    { "width": 160, "targets": 4 }
                ],
                fixedColumn: true
            });
        });
    </script>
@endpush
