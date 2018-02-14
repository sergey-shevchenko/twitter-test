@extends('layout')

@section('content')
    @if(false === $reach)
        <p>Tweet not found</p>
    @else
        <p>Tweet has a reach of {{$reach}} people</p>
    @endif
@endsection