@extends("btfourpointfour::frontend.layouts.master")

@section('head')

@endsection


@section('scripts')

@endsection

@section('content')
    {!! get_field($data, 'content') !!}
@endsection
