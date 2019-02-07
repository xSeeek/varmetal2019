@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('image')
    @php $error = rand(1, 4); @endphp
    <div style="background-image: url({{ asset('/errors/404_'.$error.'.jpg') }}); width: 100%; height: auto;" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@endsection

@section('message', __('La página solicitada no fue encontrada.'))
