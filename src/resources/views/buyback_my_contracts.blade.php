@extends('web::layouts.grids.8-4')

@section('title', trans('buyback::global.character_contract_browser_title'))
@section('page_header', trans('buyback::global.character_contract_page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-body">
            <span>{{ trans('buyback::global.my_contract_introduction') }}</span>
        </div>
    </div>
    <h5>{{ trans('buyback::global.my_contracts_open_title') }}</h5>
    @if($openContracts->isEmpty())
        <p>{{ trans('buyback::global.my_contracts_open_error') }}</p>
    @endif
    <div id="accordion-open">
        @foreach($openContracts as $contract)
            <div class="card">
                <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse_{{ $contract->contractId }}"
                     aria-expanded="true" aria-controls="collapse_{{ $contract->contractId }} id="heading_{{ $contract->contractId }}">
                    <h5 class="mb-0">
                        <div class="row">
                            <div class="col-md-10 align-left">
                                <i class="nav-icon fas fa-eye align-middle"></i>
                                <button class="btn">
                                    <h3 class="card-title"><b>{{ $contract->contractId }}</b>
                                        | {{ date("d.m.Y", $contract->created_at->timestamp) }}
                                        ( {{ count(json_decode($contract->contractData, true)["parsed"]) }} Items )</h3>
                                </button>
                            </div>
                            <div class="ml-auto align-centered">
                                <form class="ml-2" action="{{ route('buyback.contracts.delete', ['contractId' => $contract->contractId]) }}" method="get" id="contract-remove" name="contract-remove">
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </h5>
                </div>
                <div id="collapse_{{ $contract->contractId }}" class="collapse" aria-labelledby="heading_{{ $contract->contractId }}" data-parent="#accordion-open">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                            @foreach(json_decode($contract->contractData)->parsed as $item )
                                <tr>
                                    <td><img src="https://images.evetech.net/types/{{ $item->typeId }}/icon?size=32"/>
                                        <b>{{ $item->typeQuantity }} x {{ $item->typeName }}</b>
                                        ( {!! $item->marketConfig->marketOperationType == 0 ? '-' : '+' !!}{{$item->marketConfig->percentage }}% )
                                    </td>
                                    <td class="isk-td"><span class="isk-info">{{ number_format($item->typeSum,0,',', '.') }}</span> ISK</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="align-centered"><b>Summary</b></td>
                                <td class="align-centered isk-td"><b><span class="isk-info">+
                                            {{ number_format(H4zz4rdDev\Seat\SeatBuyback\Helpers\PriceCalculationHelper::calculateFinalPrice(
                                                json_decode($contract->contractData, true)["parsed"]),0,',', '.') }}</span> ISK</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <h5>{{ trans('buyback::global.my_contracts_closed_title') }}</h5>
    @if($closedContracts->isEmpty())
        <p>{{ trans('buyback::global.my_contracts_closed_error') }}</p>
    @endif
    <div id="accordion-closed">
        @foreach($closedContracts as $contract)
            <div class="card">
                <div class="card-header border-secondary bg-success" data-toggle="collapse" data-target="#collapse_{{ $contract->contractId }}"
                     aria-expanded="true" aria-controls="collapse_{{ $contract->contractId }} id="heading_{{ $contract->contractId }}">
                    <h5 class="mb-0">
                        <div class="row">
                            <div class="col-md-10 align-left">
                                <i class="nav-icon fas fa-eye align-middle mt-2"></i>
                                <button class="btn">
                                    <h3 class="card-title"><del><b>{{ $contract->contractId }}</b>
                                        | {{ date("d.m.Y", $contract->created_at->timestamp) }}
                                            ( {{ count(json_decode($contract->contractData, true)["parsed"]) }} Items )</del>
                                        - <b> Finished: {{ date("d.m.Y", $contract->updated_at->timestamp) }}</b></h3>
                                </button>
                            </div>
                        </div>
                    </h5>
                </div>
                <div id="collapse_{{ $contract->contractId }}" class="collapse" aria-labelledby="heading_{{ $contract->contractId }}" data-parent="#accordion-closed">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                            @foreach(json_decode($contract->contractData)->parsed as $item )
                                <tr>
                                    <td><img src="https://images.evetech.net/types/{{ $item->typeId }}/icon?size=32"/>
                                        <b>{{ $item->typeQuantity }} x {{ $item->typeName }}</b>
                                        ( {!! $item->marketConfig->marketOperationType == 0 ? '-' : '+' !!}{{$item->marketConfig->percentage }}% )
                                    </td>
                                    <td class="isk-td"><span class="isk-info">{{ number_format($item->typeSum,0,',', '.') }}</span> {{ trans('buyback::global.currency') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="align-centered"><b>Summary</b></td>
                                <td class="align-centered isk-td"><b><span class="isk-info">+
                                            {{ number_format(H4zz4rdDev\Seat\SeatBuyback\Helpers\PriceCalculationHelper::calculateFinalPrice(
                                                json_decode($contract->contractData, true)["parsed"]),0,',', '.') }}</span> {{ trans('buyback::global.currency') }}</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop