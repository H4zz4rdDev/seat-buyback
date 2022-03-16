@extends('web::layouts.grids.4-4-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@section('left')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('buyback.check') }}" method="post" id="item-check" name="item-check">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="items">Start a Corp-Buyback Request</label>
                    <p>Copy and paste your Items into the input field and press on the "Send" button</p>
                    <textarea name="items" cols="75" rows="10"></textarea>
                </div>
                <button type="submit" class="btn btn-success" form="item-check">Send</button>
            </form>
        </div>
    </div>
@stop

@section('center')
    <div class="card">
        <div class="card-body">
            @if(!empty($eve_item_data))
                @foreach($eve_item_data as $item)
                    <P>{{ $item["name"] }} - {{ $item["quantity"] }}</P>
                @endforeach
            @endif
        </div>
    </div>
@stop

@push('javascript')
    <script>

        console.log('Include any JavaScript you may need here!');

    </script>
@endpush
