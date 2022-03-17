@extends('web::layouts.grids.4-4-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@section('left')
    <div class="card">
        <div class="card-body">
            <p>Adminpanel</p>
        </div>
    </div>
@stop

@push('javascript')
    <script>

        console.log('Include any JavaScript you may need here!');

    </script>
@endpush
