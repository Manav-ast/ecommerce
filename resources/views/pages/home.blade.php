@extends('layouts.users.app')

@section('content')
    <x-users.homepage-banner :banner="getStaticBlock('home-banner')" />
    <x-users.categories :categories="$categories" />
    <x-users.products :products="$products" />
@endsection
