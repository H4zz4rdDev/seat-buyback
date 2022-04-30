@extends('web::layouts.grids.4-4-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/buyback.css') }}"/>
@endpush

@section('left')
    <div class="card">
        <div class="card-body">
            <div id="overlay" onclick="off()">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner"></div>
                </div>
            </div>
            <form action="{{ route('buyback.check') }}" method="post" id="item-check" name="item-check">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="items">{{ trans('buyback::global.step_one_label') }}</label>
                    <p>{{ trans('buyback::global.step_one_introduction') }}</p>
                    <textarea class="w-100" name="items" rows="10"></textarea>
                    <p><b>{{ trans('buyback::global.max_allowed_items') }} </b>{{ $maxAllowedItems }}</p>
                </div>
                <button type="submit" onclick="on()" class="btn btn-primary" form="item-check">{{ trans('buyback::global.step_one_button') }}</button>
            </form>
        </div>
    </div>
@stop

@push('javascript')
    <script>
        function on() {
            document.getElementById("overlay").style.display = "flex";
        }
    </script>
@endpush

