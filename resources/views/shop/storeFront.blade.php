@extends('layouts.shop')

@section('content')
    @include('component.storeFront.carousel')
    @include('component.storeFront.schedule')
    @include('component.storeFront.service')
    @include('component.storeFront.doctorCarousel')
    @include('component.storeFront.post')
@endsection
