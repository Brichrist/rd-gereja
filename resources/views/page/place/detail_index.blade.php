@extends('layouts.main')
@section('back')
    /worship-place
@endsection
@push('css')
    <style>
        .playground {
            min-height: 250px
        }

        .playground .time {
            display: unset !important;
        }
    </style>
@endpush
@push('js')
    <script>
        $('#waktu').change(function() {

            if (($('#parameter_type').val() != "") && $('#waktu').val() != "" && $('#waktu').val() > 0) {
                $('.btn-add-activity').removeAttr('disabled')
            } else {
                $('.btn-add-activity').attr('disabled', 'disabled');
            }
        })
        $('#parameter_type').change(function() {

            if (($('#parameter_type').val() != "") && $('#waktu').val() != "" && $('#waktu').val() > 0) {
                $('.btn-add-activity').removeAttr('disabled')
            } else {
                $('.btn-add-activity').attr('disabled', 'disabled');
            }
        })

        $('.btn-add-activity').click(function() {
            $('#waktu').val()
            $('#parameter_type').val()
            var e = document.getElementById("parameter_type");
            var text = e.options[e.selectedIndex];
            var obj = getDataset(e.options[e.selectedIndex])
            var array = []
            var html_param = ''
            $.each(obj, function(key, value) {
                console.log(key, value)
                if (key == "default_time") {
                    array[key] = $('#waktu').val()
                    html_param += ` data-${key}="${$('#waktu').val()}"`
                } else {
                    array[key] = value
                    html_param += ` data-${key}="${value}"`
                }
            });
            var html = ` 
            <div class="col-12 mb-2 item-sort" ${html_param}>
                <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                    <div class="text-white fs-5 d-flex align-items-center">
                        ${array['activity']}
                    </div>
                    <div class="text-white fs-5 d-flex align-items-center time d-none">

                    </div>
                    <input type="hidden" name="done[]" value="${array['done']}">
                    <input type="hidden" name="default_time[]" value="${array['default_time']}">
                    <input type="hidden" name="id[]" value="${array['id']}">
                    <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                </div>
            </div>`
            if (array['done'] == '1') {
                $('.sortable-form-group-post:not(.playground)').append(html)
            } else {
                $('.sortable-form-group-pre:not(.playground)').append(html)
            }


        })
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
                    <div class="container ">
                        @php
                            $ActivityTmplt[0] = clone $ActivityTemplates;
                            $ActivityTmplt[1] = clone $ActivityTemplates;
                            $ActivityTmplt[2] = clone $ActivityTemplates;
                        @endphp
                        <div class="row">
                            <div class="mb-3 col-6">
                                <div class="form-group">
                                    <label for="parameter_type" class="form-label">parameter type</label>
                                    <select name="parameter_type" class="form-control select2" id="parameter_type">
                                        <option value="">-- select --</option>
                                        @foreach ($ActivityTmplt[0]->where('default_time', null)->get() as $item)
                                            @php
                                                $param =
                                                    "
                                                    data-activity='" .
                                                    $item->activity .
                                                    "' 
                                                    data-id='" .
                                                    $item->id .
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
                                            <option value="{{ $item->id }}" {!! $param !!}>{{ $item->activity }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="waktu" class="form-label">waktu</label>
                                <input type="number" name="waktu" value="" class="form-control " id="waktu">
                                @error('waktu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="col-3 float-end">
                                    <button class="btn btn-primary col-12 btn-add-activity" disabled> add </button>
                                </div>
                            </div>
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
                                @foreach ($ActivityTmplt[1]->where('done', '-1')->where('default_time', '!=', null)->whereNotIn('id',$arr)->get() as $item)
                                    @php
                                        $param =
                                            "
                                            data-activity='" .
                                            $item->activity .
                                            "' 
                                            data-id='" .
                                            $item->id .
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
                                            <input type="hidden" name="done[]" value="{{ $item->done }}">
                                            <input type="hidden" name="default_time[]" value="{{ $item->default_time }}">
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                            <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="row sortable-form-group-post">
                                @foreach ($ActivityTmplt[2]->where('done', '1')->where('default_time', '!=', null)->whereNotIn('id',$arr)->get() as $item)
                                    @php
                                        $param =
                                            "
                                            data-activity='" .
                                            $item->activity .
                                            "' 
                                            data-id='" .
                                            $item->id .
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
                                            <input type="hidden" name="done[]" value="{{ $item->done }}">
                                            <input type="hidden" name="default_time[]" value="{{ $item->default_time }}">
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
                <form method="POST" action="/worship-place/{{ $WorshipPlace->id }}/activity" enctype="multipart/form-data">
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
                            @foreach ($DetailWorshipTemplates->where('done', '-1') as $item)
                                @php
                                    $param =
                                        "
                                        data-activity='" .
                                        $item->linkActivityTemplate->activity .
                                        "' 
                                        data-id='" .
                                        $item->linkActivityTemplate->id .
                                        "' 
                                        data-value='" .
                                        $item->linkActivityTemplate->value .
                                        "' 
                                        data-default_time='" .
                                        $item->linkActivityTemplate->default_time .
                                        "' 
                                        data-done='" .
                                        $item->linkActivityTemplate->done .
                                        "' 
                                        data-type='" .
                                        $item->linkActivityTemplate->type .
                                        "' 
                                        data-status='" .
                                        $item->linkActivityTemplate->status .
                                        "'";
                                @endphp
                                <div class="col-12 mb-2 item-sort" {!! $param !!}>
                                    <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                        <div class="text-white fs-5 d-flex align-items-center">
                                            {{ $item->linkActivityTemplate->activity }}
                                        </div>
                                        <div class="text-white fs-5 d-flex align-items-center time">

                                        </div>
                                        <input type="hidden" name="done[]" value="{{ $item->linkActivityTemplate->done }}">
                                        <input type="hidden" name="default_time[]" value="{{ $item->linkActivityTemplate->default_time }}">
                                        <input type="hidden" name="id[]" value="{{ $item->linkActivityTemplate->id }}">
                                        <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex" id="time_start" data-time_start="{{ $WorshipPlace->time_start }}">
                            <div class="mt-1 ms-2">
                                {{ $WorshipPlace->time_start }}
                            </div>
                            <hr class="mx-4 flex-grow-1">
                        </div>
                        <div class="container playground sortable-form-group-post">
                            @foreach ($DetailWorshipTemplates->where('done', '1') as $item)
                                @php
                                    $param =
                                        "
                                    data-activity='" .
                                        $item->linkActivityTemplate->activity .
                                        "' 
                                    data-id='" .
                                        $item->linkActivityTemplate->id .
                                        "' 
                                    data-value='" .
                                        $item->linkActivityTemplate->value .
                                        "' 
                                    data-default_time='" .
                                        $item->linkActivityTemplate->default_time .
                                        "' 
                                    data-done='" .
                                        $item->linkActivityTemplate->done .
                                        "' 
                                    data-type='" .
                                        $item->linkActivityTemplate->type .
                                        "' 
                                    data-status='" .
                                        $item->linkActivityTemplate->status .
                                        "'";
                                @endphp
                                <div class="col-12 mb-2 item-sort" {!! $param !!}>
                                    <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                        <div class="text-white fs-5 d-flex align-items-center">
                                            {{ $item->linkActivityTemplate->activity }}
                                        </div>
                                        <div class="text-white fs-5 d-flex align-items-center time">

                                        </div>
                                        <input type="hidden" name="done[]" value="{{ $item->linkActivityTemplate->done }}">
                                        <input type="hidden" name="default_time[]" value="{{ $item->linkActivityTemplate->default_time }}">
                                        <input type="hidden" name="id[]" value="{{ $item->linkActivityTemplate->id }}">
                                        <button type="button" class="btn btn-primary icon-sortable fs-6 float-end"><i class="bi bi-hand-index-thumb"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
