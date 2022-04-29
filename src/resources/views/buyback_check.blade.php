@extends('web::layouts.grids.8-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@if(!empty($eve_item_data))
    @section('left')
        <div class="card">
            <div class="card-body">
                <label for="items">{{ trans('buyback::global.step_two_label') }}</label>
                <p>{{ trans('buyback::global.step_two_introduction') }}</p>
                <table class="table">
                    <thead class="thead bg-primary">
                    <th scope="col" class="align-centered" colspan="2">{{ trans('buyback::global.step_two_item_table_title') }}</th>
                    </thead>
                    <tbody>
                    @foreach($eve_item_data["parsed"] as $item)
                        <tr>
                            <td><img src="https://images.evetech.net/types/{{ $item["typeId"] }}/icon?size=32"/>
                                <b>{{ $item["typeQuantity"] }} x {{ $item["typeName"] }}</b>
                                ( {!! $item["marketConfig"]["marketOperationType"] == 0 ? '-' : '+' !!}{{$item["marketConfig"]["percentage"] }}% )
                            </td>
                            <td class="isk-td"><span class="isk-info">+{{ number_format($item["typeSum"],0,',', '.') }}</span> {{ trans('buyback::global.currency') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="align-centered"><b>{{ trans('buyback::global.step_two_summary') }}</b></td>
                        <td class="align-centered isk-td"><b><span class="isk-info">+{{ number_format($finalPrice,0,',', '.') }}</span> {{ trans('buyback::global.currency') }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if(array_key_exists("ignored", $eve_item_data) && count($eve_item_data["ignored"]) > 0)
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-borderless">
                            <thead class="thead">
                            <th class="align-centered bg-red">
                                <span class="ml-2"><i class='fas fa-ban'></i>{{ trans('buyback::global.step_two_ignored_table_title') }}</span>
                            </th>
                            </thead>
                            <tbody>
                            @foreach($eve_item_data["ignored"] as $item)
                                <tr>
                                    <td><img src="https://images.evetech.net/types/{{ $item["ItemId"] }}/icon?size=32">
                                        {{ number_format($item["ItemQuantity"],0,',', '.') }} x {{ $item["ItemName"] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @stop
    @section('right')
        <div class="card">
            <div class="card-body">
                <label for="items">{{ trans('buyback::global.step_three_label') }}</label>
                <p>{{ trans('buyback::global.step_three_introduction') }}</p>
                <form action="{{ route('buyback.contracts.insert') }}" method="post" id="contract-insert" name="contract-insert">
                    {{ csrf_field() }}
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>{{ trans('buyback::global.step_three_contract_type') }}</td>
                            <td><b>Item Exchange</b></td>
                        </tr>
                        <tr>
                            <td>{{ trans('buyback::global.step_three_contract_to') }}*</td>
                            <td><b onClick="SelfCopy(this)" data-container="body" data-toggle="popover" data-placement="top" data-content="Copied!">{{ $contractTo }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ trans('buyback::global.step_three_contract_receive') }}*</td>
                            <td><b onClick="SelfCopy(this)" data-container="body" data-toggle="popover" data-placement="top" data-content="Copied!"><span class="isk-info">{{ number_format($finalPrice,0,',', '.') }}</span></b> <b>{{ trans('buyback::global.currency') }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ trans('buyback::global.step_three_contract_expiration') }}</td>
                            <td><b>{{ $contractExpiration }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ trans('buyback::global.step_three_contract_description') }}*</td>
                            <td><b onClick="SelfCopy(this)" data-container="body" data-toggle="popover" data-placement="top" data-content="Copied!">{{ $contractId }}</b></td>
                            <input type="hidden" value="{{ $contractId }}" name="contractId" id="contractId">
                        </tr>
                        <input type="hidden" value="{{ json_encode($eve_item_data) }}" name="contractData" id="contractId">
                        </tbody>
                    </table>
                    <div>
                        <span><b>{{ trans('buyback::global.step_three_contract_tip_title') }}</b></span>
                        <p>{{ trans('buyback::global.step_three_contract_tip') }}</p>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">{{ trans('buyback::global.step_three_button') }}</button>
                </form>
            </div>
        </div>
    @stop
@endif

@push('javascript')
    <script>
        function SelfCopy(object)
        {
            navigator.clipboard.writeText(object.innerText);

            $(object).popover().click(function () {
                setTimeout(function () {
                    $(object).popover('hide');
                }, 1000);
            });
        }
    </script>
@endpush
