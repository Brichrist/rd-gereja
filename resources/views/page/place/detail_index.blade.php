@extends('layouts.main')
@section('back')
    /worship-place
@endsection
@push('css')
    <style>
        .playground {
            min-height: 250px
        }
        .playground .time{
            display: unset!important;
        }
    </style>
@endpush
@push('js')
    <script>
        var $time_start = $('#time_start').data('time_start')
        sortable_el = document.querySelectorAll('.sortable-form-group-post');
        if (sortable_el.length > 0) {
            sortable_el.forEach(function(el) {
                new Sortable(el, {
                    handle: '.icon-sortable',
                    animation: 150,
                    ghostClass: "sortable-form-group-placeholder",
                    group: {
                        name: 'shared-post',
                    },
                    onEnd: function( /**Event*/ evt) {
                        let last = $('.playground.sortable-form-group-post .item-sort').length
                        $time = $time_start
                        for (let index = 0; index < last; index++) {
                            $el = $('.playground.sortable-form-group-post .item-sort').eq(index)
                            $time = moment($time, "hh:mm").add($el.data('default_time'), 'minutes').format("hh:mm")
                            $el.find('.time').text($time)
                        }
                    },
                });
            });
        }
        sortable_el = document.querySelectorAll('.sortable-form-group-pre');
        if (sortable_el.length > 0) {
            sortable_el.forEach(function(el) {
                new Sortable(el, {
                    handle: '.icon-sortable',
                    animation: 150,
                    ghostClass: "sortable-form-group-placeholder",
                    group: {
                        name: 'shared-pre',
                    },
                    onEnd: function( /**Event*/ evt) {
                        let index = $('.playground.sortable-form-group-pre .item-sort').length - 1
                        $time = $time_start
                        for (index; index >= 0; index--) {
                            $el = $('.playground.sortable-form-group-pre .item-sort').eq(index)
                            $time = moment($time, "hh:mm").subtract($el.data('default_time'), 'minutes').format("hh:mm")
                            $el.find('.time').text($time)
                        }
                        console.log(evt.to)
                    },
                });
            });
        }
    </script>
@endpush
@section('main')
    <div class="container">
        <div class="row flex-md-row-reverse">
            <div class="col-md-4 col-12">
                <div class="border py-3 px-2 rounded">
                    <div class="add-edit-title mt-2 mb-3 fs-4 fw-bolder">
                        add free Activity
                    </div>
                    <div class="row">
                        <div class="container">
                            
                           
                        </div>
                    </div>
                </div>
                <div class="border py-3 px-2 rounded">
                    <div class="add-edit-title mt-2 mb-3 fs-4 fw-bolder">
                        Registered Activity
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="row sortable-form-group-pre">
                                @foreach ($ActivityTemplates->where('done', '-1')->where('default_time','!=',null) as $item)
                                    @php
                                        $param =
                                            "
                                            data-activity='" .
                                            $item->activity .
                                            "' 
                                            data-value='" .
                                            $item->value .
                                            "' 
                                            data-default_time='" .
                                            $item->default_time .
                                            "' 
                                            data-done='" .
                                            $item->done .
                                            "' 
                                            data-type='" .
                                            $item->type .
                                            "' 
                                            data-status='" .
                                            $item->status .
                                            "'";
                                    @endphp
                                    <div class="col-12 mb-2 item-sort" {!! $param !!}>
                                        <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                            <div class="text-white fs-5 d-flex align-items-center">
                                                {{ $item->activity }}
                                            </div>
                                            <div class="text-white fs-5 d-flex align-items-center time d-none">

                                            </div>
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                            <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="row sortable-form-group-post">
                                @foreach ($ActivityTemplates->where('done', '1')->where('default_time','!=',null) as $item)
                                    @php
                                        $param =
                                            "
                                            data-activity='" .
                                            $item->activity .
                                            "' 
                                            data-value='" .
                                            $item->value .
                                            "' 
                                            data-default_time='" .
                                            $item->default_time .
                                            "' 
                                            data-done='" .
                                            $item->done .
                                            "' 
                                            data-type='" .
                                            $item->type .
                                            "' 
                                            data-status='" .
                                            $item->status .
                                            "'";
                                    @endphp
                                    <div class="col-12 mb-2 item-sort" {!! $param !!}>
                                        <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                            <div class="text-white fs-5 d-flex align-items-center">
                                                {{ $item->activity }}
                                            </div>
                                            <div class="text-white fs-5 d-flex align-items-center time">

                                            </div>
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                            <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <form method="POST" action="/dashboard/addition-content/sorting" enctype="multipart/form-data">
                    @csrf
                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary mb-3 col-12">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded">
                        <div class="container playground sortable-form-group-pre">

                        </div>
                        <div class="d-flex" id="time_start" data-time_start="{{ $WorshipPlace->time_start }}">
                            <div class="mt-1 ms-2">
                                {{ $WorshipPlace->time_start }}
                            </div>
                            <hr class="mx-4 flex-grow-1">
                        </div>
                        <div class="container playground sortable-form-group-post">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
