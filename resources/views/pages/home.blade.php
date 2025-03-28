@extends('layouts.users.app')

@section('content')
    <x-users.homepage-banner :banner="getStaticBlock('home-banner')" :title1="getStaticBlock('home-banner-title-1')" :subtitle="getStaticBlock('home-subtitle')" />
    <x-users.categories :categories="$categories" />
    <x-users.products :products="$products" />
@endsection
