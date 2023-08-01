@extends('layouts.main')
@section('back')
    /activity-template
@endsection
@push('css')
    <style>
        .trix-button--icon-strike,
        .trix-button--icon-link,
        .trix-button--icon-quote,
        .trix-button--icon-heading-1,
        .trix-button--icon-number-list,
        .trix-button--icon-attach,
        .trix-button--icon-code,
        .trix-button--icon-increase-nesting-level,
        .trix-button--icon-decrease-nesting-level,
        .trix-button-group--file-tools{
            display: none!important;
        }
        .trix-button-row{
            justify-content:unset!important;
        }
        .trix-button-group--history-tools{
            margin-left: auto!important;
        }
    </style>
@endpush
@push('js')
    <script>
        $('.btn-edit').click(function(e) {
            var id = $(this).attr(`data-id`);
            var default_value = $(this).attr(`data-default_value`);
            var parameter_type = $(this).attr(`data-parameter_type`);
            var parameter_key = $(this).attr(`data-parameter_key`);
            var element=document.getElementById("trix-editor");

            $('.add-edit-title').text('Update KEY "'+parameter_key+'"');
            $('textarea#default_value').val(default_value);
            element.editor.setSelectedRange([0, 0])
            element.editor.insertHTML(default_value)
            $('select#parameter_type').val(parameter_type);
            $('form').attr('action', `${window.location.pathname}/${id}`);
            $('form').prepend('<input type="hidden" name="_method" value="put">');
        });

        $('.btn-reset').click(function(e) {
            $('.add-edit-title').text('Update');
            $('form').trigger("reset");
            $('form').attr('action', ``);
            $('input[name="_method"]').remove();
        });
    </script>
@endpush
@section('main')
    <div class="container">
        <div class="row flex-md-row-reverse">
            <div class="col-md-4 col-12">
                <div class="border py-3 px-2 rounded">
                    <div class="add-edit-title mt-2 mb-3 fs-4 fw-bolder">
                        Update
                    </div>
                    <form method="post" action="">
                        @if (session()->pull('id') ?? null)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="default_value" class="form-label">default value</label>
                                <input name="default_value" id="default_value" cols="30" rows="10" class="form-control @error('default_value') is-invalid @enderror" id="default_value" type="hidden" value="{{ old('default_value', null) }}">
                                <trix-editor id="trix-editor" input="default_value"></trix-editor>
                                @error('default_value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label for="parameter_type" class="form-label">parameter type</label>
                                    <select name="parameter_type" class="form-control @error('parameter_type') is-invalid @enderror select2" id="parameter_type">
                                        <option {{ old('parameter_type', null) == '1' ? 'selected' : '' }} value="1">input</option>
                                        <option {{ old('parameter_type', null) == '2' ? 'selected' : '' }} value="2">textarea</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-warning btn-reset col-4 float-start">reset</button>

                                <button class="btn btn-success col-4 float-end">save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">no</th>
                                <th scope="col">parameter_key</th>
                                <th scope="col">parameter_type</th>
                                <th scope="col">default value</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $row->parameter_key }}</td>
                                    <td>{{ $row->parameter_type == '1' ? 'input' : 'textarea' }}</td>
                                    <td>{!! $row->default_value !!}</td>
                                    <td>
                                        <button data-parameter_key="{{ $row->parameter_key }}" data-id="{{ $row->id }}" data-default_value="{{ $row->default_value }}" data-parameter_type="{{ $row->parameter_type }}" class="btn btn-primary btn-edit">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
