@extends('web::layouts.grids.4-4-4')

@section('title', trans('buyback::global.browser_title'))
@section('page_header', trans('buyback::global.page_title'))

@section('left')
    <div class="card">
        <div class="card-body">
            <p>Adminpanel</p>
            <div class="container mt-5">
                <select class="groupsearch form-control" name="groupsearch"></select>
            </div>
        </div>
    </div>
@stop

@push('javascript')
    <script>

        $('.groupsearch').select2({
            placeholder: 'Select group',
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

    </script>
@endpush
