@extends('web::layouts.grids.8-4')

@section('title', trans('buyback::global.contract_browser_title'))
@section('page_header', trans('buyback::global.contract_page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('left')
    @if($contracts->isEmpty())
        <h5>No contracts found yet!</h5>
    @else
    <div id="accordion">
        @foreach($contracts as $contract)
        <div class="card">
            <div class="card-header border-secondary" data-toggle="collapse" data-target="#collapse_{{ $contract->contractId }}"
                 aria-expanded="true" aria-controls="collapse_{{ $contract->contractId }} id="heading_{{ $contract->contractId }}">
                <h5 class="mb-0">
                    <div class="row">
                        <div class="col-md-8 align-left">
                            <button class="btn">
                                <h3 class="card-title"><b>{{ $contract->contractId }}</b>
                                    | {{ date("d.m.Y", $contract->created_at->timestamp) }}
                                    | <b>{{ $contract->contractIssuer }}</b>
                                    ( {{ count(json_decode($contract->contractData, true)["parsed"]) }} Items )</h3>
                            </button>
                        </div>
                        <div class="ml-auto align-right text-center align-centered">
                            <div class="row">
                                <form action="{{ route('buyback.contracts.succeed', ['contractId' => $contract->contractId]) }}" method="get" id="contract-success" name="contract-success">
                                    <button class="btn btn-success">Finish</button>
                                </form>
                                <form class="ml-2" action="{{ route('buyback.contracts.delete', ['contractId' => $contract->contractId]) }}" method="get" id="contract-remove" name="contract-remove">
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="ml-auto align-centered mt-2">
                            <i class="nav-icon fas fa-plus-square"></i>
                        </div>
                    </div>
                </h5>
            </div>
            <div id="collapse_{{ $contract->contractId }}" class="collapse" aria-labelledby="heading_{{ $contract->contractId }}" data-parent="#accordion">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            @foreach(json_decode($contract->contractData)->parsed as $item )
                                <tr>
                                    <td><img src="https://images.evetech.net/types/{{ $item->typeId }}/icon?size=32"/>
                                        <b>{{ number_format($item->typeQuantity,0,',', '.') }} x {{ $item->typeName }}</b>
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
    @endif
@stop