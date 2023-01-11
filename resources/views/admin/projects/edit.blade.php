@extends('layouts.admin')

@section('content')
    <h1>Modifica {{ $project->title }}</h1>


    <div class="row bg-white">
        <div class="col-12">
            <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" class="p-4">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $project->title) }}">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Contenuto</label>
                    <textarea class="form-control" id="content" name="content"> {{ old('content', $project->content) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
            </form>
        </div>
    </div>
@endsection
