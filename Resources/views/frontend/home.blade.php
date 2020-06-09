@extends("btfourpointfour::frontend.layouts.master")

@section('head')

@endsection


@section('scripts')

@endsection

@section('content')

    <h1 class="my-4">Page Heading
        <small>Secondary Text</small>
    </h1>


    {!! get_the_content($content->id) !!}


    <x-exp></x-exp>

    <?php

    $args = [
        'content_groups' => [
            [
                'slug' => 'default',
                'fields' => "title, slug, excerpt"
            ]
        ],
        'template_fields' => "action, action-label"
    ];

    $list = get_contents('blogs', $args);



    ?>


    @foreach($list as $item)


        {!! get_content_field($item, 'default', 'title') !!}



    @endforeach





@endsection
