@extends('layouts.users.app') 

@section('content')
    <x-categories :categories="$categories" />
@endsection
