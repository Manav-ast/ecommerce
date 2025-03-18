@extends('layouts.users.app')

@section('content')
    <x-users.homepage-banner />
    <x-users.categories :categories="$categories" />
@endsection
