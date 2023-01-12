@extends('layouts.admin')

@section('content')
    <h1>{{ $project->title }}</h1>
    <p>{!! $project->content !!}</p>
    @if ($project->cover_image)
        <img width="300" src="{{ asset('storage/' . $project->cover_image) }}">
    @endif
@endsection
