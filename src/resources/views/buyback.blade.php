@extends('web::layouts.grids.6-6')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@section('left')
    <div class="card card-primary card-solid">
        <div class="card-header">
            <h3 class="card-title">{{ $evepraisal }}</h3>
        </div>
    </div>

@stop

@push('javascript')
    <script>

        console.log('Include any JavaScript you may need here!');

    </script>
@endpush
