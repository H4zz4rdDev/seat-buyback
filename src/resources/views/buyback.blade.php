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
@if(!empty($eve_item_data))
    <div class="card">
        <div class="card-header" style="background-color: #da3545">
            <div class="card-title" style="color: white">
                <dl>
                    <dt><i class='fas fa-ban'></i> Ignored Items</dt>
                    <dd>This items are currently <b>not</b> bought by your corporation</dd>
                </dl>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <ul style="list-style-type: square">
                    <li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li>
                    <li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li>
                    <li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li>
                    <li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li><li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li>
                    <li>
                        <img src="https://images.evetech.net/types/21898/icon?size=32">
                        600 x Republic Fleet EMP S
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
@stop

@if(!empty($eve_item_data))
@section('center')
    <div class="card">
        <div class="card-body">
            <label for="items">2. Contract Item Overview</label>
            <p>Please check the items and prices before you create the contract</p>
            @foreach($eve_item_data as $group)
                <table class="table">
                    <thead class="thead-dark">
                    <th class="align-centered" colspan="2">{{ $group["marketGroupName"] }}
                        <span class="ml-2">( {!! $group["marketConfig"]["marketOperationType"] == 0 ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' !!}</span>
                        {{ $group["marketConfig"]["percentage"] }}% )
                    </th>
                    </thead>
                    <tbody>
                    @foreach($group["items"] as $item)
                        <tr>
                            <td><img src="https://images.evetech.net/types/{{ $item["typeID"] }}/icon?size=32"/>
                                <b>{{ $item["quantity"] }} x {{ $item["name"] }}</b>
                            </td>
                            <td class="isk-td"><span class="isk-info">+{{ number_format($item["sum"],0,',', '.') }}</span> ISK</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
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
                    <td><b><span class="isk-info">999.000.000</span> ISK</b></td>
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
