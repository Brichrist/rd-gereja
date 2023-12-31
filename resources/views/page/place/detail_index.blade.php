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
        var $time_start = $('#time_start').attr('data-time_start')

        function remakeTime() {
            let index = $('.playground.sortable-form-group-pre .item-sort').length - 1
            $time = $time_start
            for (index; index >= 0; index--) {
                $el = $('.playground.sortable-form-group-pre .item-sort').eq(index)
                $time = moment($time, "hh:mm").subtract($el.attr('data-default_time'), 'minutes').format("hh:mm")
                $el.find('.time').text($time)
            }

            let last = $('.playground.sortable-form-group-post .item-sort').length
            $time = $time_start
            for (let index = 0; index < last; index++) {
                $el = $('.playground.sortable-form-group-post .item-sort').eq(index)
                $time = moment($time, "hh:mm").add($el.attr('data-default_time'), 'minutes').format("hh:mm")
                $el.find('.time').text($time)
            }
        }

        $(document).ready(function() {
            remakeTime()
        })
        $(document).on('click', '.edit-default-time', function() {
            // $(this).parents('.item-sort').attr('data-default_time','').find('.hidden-default_time').val('')
            $('.modal-input-waktu').val($(this).parents('.item-sort').find('.hidden-default_time').val())
            $('.save-default-time').attr('data-id', $(this).parents('.item-sort').attr('data-id'))
        })
        $(document).on('click', '.save-default-time', function() {
            $('#activity-' + $(this).attr('data-id')).attr('data-default_time', $('.modal-input-waktu').val()).find('.hidden-default_time').val($('.modal-input-waktu').val())
            $('.save-default-time').attr('data-id', '')
            remakeTime()
        })
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
                if (key == "default_time") {
                    array[key] = $('#waktu').val()
                    html_param += ` data-${key}="${$('#waktu').val()}"`
                } else {
                    array[key] = value
                    html_param += ` data-${key}="${value}"`
                }
            });
            var html = ` 
            <div class="col-12 mb-2 item-sort" id="activity-${array['id']}" ${html_param}>
                <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                    <div class="text-white fs-5 d-flex align-items-center">
                        ${array['activity']}
                    </div>
                    <div class="text-white fs-5 d-flex align-items-center time d-none">

                    </div>
                    <input type="hidden" name="done[]" value="${array['done']}">
                    <input type="hidden" name="default_time[]" class="hidden-default_time" value="${array['default_time']}">
                    <input type="hidden" name="id[]" value="${array['id']}">
                    <div class="float-end">
                        <button type="button" class="btn btn-warning edit-default-time fs-6" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-primary icon-sortable fs-6"><i class="bi bi-hand-index-thumb"></i></button>
                    </div>
                </div>
            </div>`
            if (array['done'] == '1') {
                $('.sortable-form-group-post:not(.playground)').append(html)
            } else {
                $('.sortable-form-group-pre:not(.playground)').append(html)
            }


        })
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
                        remakeTime()
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
                        remakeTime()
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
                                @foreach ($ActivityTmplt[1]->where('done', '-1')->where('default_time', '!=', null)->whereNotIn('id', $arr)->get() as $item)
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
                                    <div class="col-12 mb-2 item-sort" id="activity-{{ $item->id }}" {!! $param !!}>
                                        <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                            <div class="text-white fs-5 d-flex align-items-center">
                                                {{ $item->activity }}
                                            </div>
                                            <div class="text-white fs-5 d-flex align-items-center time d-none">
                                            </div>
                                            <input type="hidden" name="done[]" value="{{ $item->done }}">
                                            <input type="hidden" name="default_time[]" class="hidden-default_time" value="{{ $item->default_time }}">
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                            <div class="float-end">
                                                <button type="button" class="btn btn-warning edit-default-time fs-6" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-primary icon-sortable fs-6"><i class="bi bi-hand-index-thumb"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="row sortable-form-group-post">
                                @foreach ($ActivityTmplt[2]->where('done', '1')->where('default_time', '!=', null)->whereNotIn('id', $arr)->get() as $item)
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
                                    <div class="col-12 mb-2 item-sort" id="activity-{{ $item->id }}" {!! $param !!}>
                                        <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                            <div class="text-white fs-5 d-flex align-items-center">
                                                {{ $item->activity }}
                                            </div>
                                            <div class="text-white fs-5 d-flex align-items-center time d-none">

                                            </div>
                                            <input type="hidden" name="done[]" value="{{ $item->done }}">
                                            <input type="hidden" name="default_time[]" class="hidden-default_time" value="{{ $item->default_time }}">
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                            <div class="float-end">
                                                <button type="button" class="btn btn-warning edit-default-time fs-6" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-primary icon-sortable fs-6"><i class="bi bi-hand-index-thumb"></i></button>
                                            </div>
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
                                        $item->id_activity_template .
                                        "' 
                                        data-value='" .
                                        $item->linkActivityTemplate->value .
                                        "' 
                                        data-default_time='" .
                                        $item->default_time .
                                        "' 
                                        data-done='" .
                                        $item->done .
                                        "' 
                                        data-type='" .
                                        $item->linkActivityTemplate->type .
                                        "' 
                                        data-status='" .
                                        $item->linkActivityTemplate->status .
                                        "'";
                                @endphp
                                <div class="col-12 mb-2 item-sort" id="activity-{{ $item->id_activity_template }}" {!! $param !!}>
                                    <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                        <div class="text-white fs-5 d-flex align-items-center">
                                            {{ $item->linkActivityTemplate->activity }}
                                        </div>
                                        <div class="text-white fs-5 d-flex align-items-center time d-none">

                                        </div>
                                        <input type="hidden" name="done[]" value="{{ $item->done }}">
                                        <input type="hidden" name="default_time[]" class="hidden-default_time" value="{{ $item->default_time }}">
                                        <input type="hidden" name="id[]" value="{{ $item->id_activity_template }}">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-warning edit-default-time fs-6" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-primary icon-sortable fs-6"><i class="bi bi-hand-index-thumb"></i></button>
                                        </div>
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
                                        $item->id_activity_template .
                                        "' 
                                    data-value='" .
                                        $item->linkActivityTemplate->value .
                                        "' 
                                    data-default_time='" .
                                        $item->default_time .
                                        "' 
                                    data-done='" .
                                        $item->done .
                                        "' 
                                    data-type='" .
                                        $item->linkActivityTemplate->type .
                                        "' 
                                    data-status='" .
                                        $item->linkActivityTemplate->status .
                                        "'";
                                @endphp
                                <div class="col-12 mb-2 item-sort" id="activity-{{ $item->id_activity_template }}" {!! $param !!}>
                                    <div class="item bg-secondary border rounded d-flex justify-content-between px-3 py-1">
                                        <div class="text-white fs-5 d-flex align-items-center">
                                            {{ $item->linkActivityTemplate->activity }}
                                        </div>
                                        <div class="text-white fs-5 d-flex align-items-center time d-none">

                                        </div>
                                        <input type="hidden" name="done[]" value="{{ $item->done }}">
                                        <input type="hidden" name="default_time[]" class="hidden-default_time" value="{{ $item->default_time }}">
                                        <input type="hidden" name="id[]" value="{{ $item->id_activity_template }}">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-warning edit-default-time fs-6" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-primary icon-sortable fs-6"><i class="bi bi-hand-index-thumb"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 col-6">
                        <label for="waktu" class="form-label">waktu</label>
                        <input type="number" name="waktu" value="0" class="form-control modal-input-waktu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-default-time" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
