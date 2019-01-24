@extends('errors::illustrated-layout')

@section('code', '500')
@section('title', __('Error'))

@section('image')
    <div style="background-image: url({{ asset('/errors/500.jpg') }});" class="relative pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, algo ha ocurrido con nuestros servidores.'))
