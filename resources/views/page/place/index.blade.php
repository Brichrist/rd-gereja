@extends('layouts.main')
@section('back')
    /
@endsection
@push('js')
    <script>
        $('.btn-edit').click(function(e) {
            var id = $(this).attr(`data-id`);
            var name = $(this).attr(`data-name`);
            var time_start = $(this).attr(`data-time_start`);
            var time_end = $(this).attr(`data-time_end`);
            var status = $(this).attr(`data-status`);

            $('.add-edit-title').text('Edit');
            $('input#name').val(name);
            $('input#time_start').val(time_start);
            $('input#time_end').val(time_end);
            $('select#status').val(status);

            $('form').attr('action', `/worship-place/${id}`);
            $('form').prepend('<input type="hidden" name="_method" value="put">');
        });

        $('.reset-button').click(function(e) {
            $('.add-edit-title').text('create');
            $('form').trigger("reset");
            $('form').attr('action', `/worship-place`);
            $('input[name="_method"]').remove();
        });
    </script>
@endpush
@section('main')
    <div class="container">
        <div class="row flex-md-row-reverse">
            <div class="col-md-6 col-12">
                <div class="border py-3 px-2 rounded">
                    <h4 class="add-edit-title mt-2 mb-3">
                        @if (session()->pull('id') ?? null)
                            Update
                        @else
                            Create
                        @endif
                    </h4>
                    <form method="post" action="/worship-place/{{session()->pull('id') ?? null}}">
                        @if (session()->pull('id') ?? null)
                            <input type="hidden" name="_method" value="put">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="name" class="form-label">nama tempat</label>
                                <input type="text" name="name" value="{{old('name', null) }}" class="form-control @error('name') is-invalid @enderror" id="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="time_start" class="form-label">jam mulai ibadah</label>
                                <input type="time" name="time_start" value="{{ old('time_start', null) }}" class="form-control @error('time_start') is-invalid @enderror" id="time_start">
                                @error('time_start')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="time_end" class="form-label">jam akhir ibadah</label>
                                <input type="time" name="time_end" value="{{ old('time_end', null) }}" class="form-control @error('time_end') is-invalid @enderror" id="time_end">
                                @error('time_end')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                <button class="btn btn-success col-4 float-end">save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">no</th>
                                <th scope="col">tempat</th>
                                <th scope="col">jam ibadah</th>
                                <th scope="col">status</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ date('H:i',strtotime($row->time_start)) . ($row->time_end ?? null ? ' - ' . date('H:i',strtotime($row->time_end)) : '') }}</td>
                                    <td>{{ $row->status == '1' ? 'aktif' : 'tidak aktif' }}</td>
                                    <td>
                                        <button data-name="{{ $row->name }}" data-id="{{ $row->id }}" data-status="{{ $row->status }}" data-time_start="{{ date('H:i',strtotime($row->time_start)) ?? null }}" data-time_end="{{ date('H:i',strtotime($row->time_end)) ?? null }}" class="btn btn-primary btn-edit">Edit</button>
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
