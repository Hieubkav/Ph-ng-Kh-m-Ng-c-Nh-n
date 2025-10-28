@extends('layouts.shop')

@section('content')
    @include('component.storeFront.carousel', [
        'carousels' => $carousels,
        'hotPosts' => $hotPosts,
    ])
    @include('component.storeFront.schedule', ['activeSchedule' => $activeSchedule])
    @include('component.storeFront.service', ['services' => $services])
    @include('component.storeFront.doctorCarousel', ['doctors' => $doctors])
    @include('component.storeFront.post', ['catPosts' => $catPosts])
@endsection
