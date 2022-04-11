@extends('web::layouts.grids.4-4-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('buyback.check') }}" method="post" id="item-check" name="item-check">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="items">1. Start a Corp-Buyback Request</label>
                    <p>Copy and paste your Items into the input field and press on the "Send" button</p>
                    <textarea name="items" cols="75" rows="10"></textarea>
                    <p><b>Max allowed Items: </b>{{ $maxAllowedItems }}</p>
                </div>
                <button type="submit" class="btn btn-success" form="item-check">Send</button>
            </form>
        </div>
    </div>
@stop

@if(!empty($eve_item_data))
@section('center')
    <div class="card">
        <div class="card-body">
            <label for="items">2. Contract Item Overview</label>
            <p>Please check the items and prices before you create the contract</p>
            <table class="table">
                <thead class="thead-dark">
                    <th scope="col" class="align-centered" colspan="2">Itemlist</th>
                </thead>
                <tbody>
            @foreach($eve_item_data["parsed"] as $item)
                <tr>
                    <td><img src="https://images.evetech.net/types/{{ $item["typeId"] }}/icon?size=32"/>
                        <b>{{ $item["typeQuantity"] }} x {{ $item["typeName"] }}</b>
                        ( {!! $item["marketConfig"]["marketOperationType"] == 0 ? '-' : '+' !!}{{$item["marketConfig"]["percentage"] }}% )
                    </td>
                    <td class="isk-td"><span class="isk-info">+{{ number_format($item["typeSum"],0,',', '.') }}</span> ISK</td>
                </tr>
            @endforeach
                <tr>
                    <td class="align-centered"><b>Summary</b></td>
                    <td class="align-centered isk-td"><b><span class="isk-info">+{{ number_format($finalPrice,0,',', '.') }}</span> ISK</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
     @if(count($eve_item_data["ignored"]) > 0)
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <table class="table table-borderless">
                        <thead class="thead">
                        <th class="align-centered bg-red">
                            <span class="ml-2"><i class='fas fa-ban'></i> Ignored Items ( Not bought )</span>
                        </th>
                        </thead>
                        <tbody>
                            @foreach($eve_item_data["ignored"] as $item)
                            <tr>
                                <td><img src="https://images.evetech.net/types/{{ $item["ItemId"] }}/icon?size=32">
                                    {{ $item["ItemQuantity"] }} x {{ $item["ItemName"] }}
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
            <label for="items">3. Your contract</label>
            <p>Please create a contract with the data shown below</p>
            <table class="table">
                <tbody>
                <tr>
                    <td>Contract type</td>
                    <td><b>Item Exchange</b></td>
                </tr>
                <tr>
                    <td>Contract to</td>
                    <td><b>Awesome ISK Dude</b></td>
                </tr>
                <tr>
                    <td>I will receive</td>
                    <td><b><span class="isk-info">{{ number_format($finalPrice,0,',', '.') }}</span> ISK</b></td>
                </tr>
                <tr>
                    <td>Expiration</td>
                    <td><b>4 Weeks</b></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><b>G5K9L3</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
@endif

@push('javascript')
    <script>

        console.log('Include any JavaScript you may need here!');

    </script>
@endpush
