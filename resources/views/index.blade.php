@extends('layouts.main')
@section('back')
    /
@endsection
@push('js')
  
@endpush
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <a href="/worship-place" class="btn btn-primary">
                    worship-place
                </a>
            </div>
            <div class="col-3">
                <a href="/activity-template" class="btn btn-primary">
                    activity-template
                </a>
            </div>
        </div>
    </div>
@endsection
