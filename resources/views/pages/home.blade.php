@extends('layouts.users.app')

@section('content')
    <x-users.homepage-banner :banner="getHomeBanner()" />
    <x-users.categories :categories="$categories" />
@endsection
