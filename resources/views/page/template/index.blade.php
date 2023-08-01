@extends('layouts.main')
@section('back')
    /
@endsection
@push('js')
    <script>
        $('.btn-edit').click(function(e) {
            var id = $(this).attr(`data-id`);
            var activity = $(this).attr(`data-activity`);
            var value = $(this).attr(`data-value`);
            var default_time = $(this).attr(`data-default_time`);
            var done = $(this).attr(`data-done`);
            var type = $(this).attr(`data-type`);
            var status = $(this).attr(`data-status`);

            $('.add-edit-title').text('Update');
            $('input#activity').val(activity);
            $('textarea#value').text(value);
            $('input#default_time').val(default_time);
            $('select#done').val(done);
            $('select#type').val(type);
            $('select#status').val(status);

            $('form').attr('action', `/activity-template/${id}`);
            $('form').prepend('<input type="hidden" name="_method" value="put">');
        });

        $('.btn-reset').click(function(e) {
            $('.add-edit-title').text('create');
            $('form').trigger("reset");
            $('textarea#value').text('');
            $('form').attr('action', `/activity-template`);
            $('input[name="_method"]').remove();
        });
    </script>
@endpush
@section('main')
    <div class="container">
        <div class="row flex-md-row-reverse">
            <div class="col-md-4 col-12">
                <div class="border py-3 px-2 rounded">
                    <h4 class="add-edit-title mt-2 mb-3">
                        @if (session()->pull('id') ?? null)
                            Update
                        @else
                            Create
                        @endif
                    </h4>
                    <form method="post" action="/activity-template/{{ session()->pull('id') ?? null }}">
                        @if (session()->pull('id') ?? null)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="activity" class="form-label">nama kegiatan</label>
                                <input type="text" name="activity" value="{{ old('activity', null) }}" class="form-control @error('activity') is-invalid @enderror" id="activity">
                                @error('activity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12">
                                <label for="value" class="form-label">text</label>
                                <textarea name="value" class="form-control @error('value') is-invalid @enderror" id="value" cols="30" rows="10">{{ old('value', null) }}</textarea>
                                @error('value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12">
                                <label for="default_time" class="form-label">durasi master</label>
                                <input type="text" name="default_time" value="{{ old('default_time', null) }}" class="form-control @error('default_time') is-invalid @enderror" id="default_time">
                                @error('default_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label for="done" class="form-label">done when</label>
                                    <select name="done" class="form-control @error('done') is-invalid @enderror select2" id="done">
                                        <option {{ old('done', null) == '1' ? 'selected' : '' }} value="1">postworship</option>
                                        <option {{ old('done', null) == '-1' ? 'selected' : '' }}value="-1">preworship</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label for="type" class="form-label">type</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror select2" id="type">
                                        <option {{ old('type', null) == '0' ? 'selected' : '' }}value="0">normal</option>
                                        <option {{ old('type', null) == '1' ? 'selected' : '' }} value="1">special</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror select2" id="status">
                                        <option {{ old('status', null) == '1' ? 'selected' : '' }} value="1">aktif</option>
                                        <option {{ old('status', null) == '0' ? 'selected' : '' }}value="0">tidak aktif</option>
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
                                <th scope="col">activity</th>
                                <th scope="col">text</th>
                                <th scope="col">durasi master</th>
                                <th scope="col">done when</th>
                                <th scope="col">type</th>
                                <th scope="col">status</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $row->activity }}</td>
                                    <td>{{ $row->value }}</td>
                                    <td>{{ $row->default_time }}</td>
                                    <td>{{ $row->done }}</td>
                                    <td>{{ $row->type }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>
                                        <button data-id="{{ $row->id }}" data-activity="{{ $row->activity }}" data-value="{{ $row->value }}" data-default_time="{{ $row->default_time }}" data-done="{{ $row->done }}" data-type="{{ $row->type }}" data-status="{{ $row->status }}" class="btn btn-primary btn-edit">Edit</button>
                                        <a href="/activity-template/{{ $row->id }}/parameter" class="btn btn-success">set parameter</a>
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
