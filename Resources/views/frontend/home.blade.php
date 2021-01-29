@extends("btfourpointfour::frontend.layouts.master")

@section('head')

    {!! get_field($data, 'seo-meta-tags') !!}

@endsection


@section('scripts')

@endsection

@section('content')



    <h1 class="my-4">Permalink
        <small>{{$data->permalink}}</small>
    </h1>


    <p>
        {!! get_field($data, 'content') !!}
    </p>




@endsection
