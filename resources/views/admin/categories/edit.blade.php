@extends('layouts.admin')

@section('content')
    <h1>Modifica {{ $category->name }}</h1>


    <div class="row bg-white">
        <div class="col-12">
            <form action="{{ route('admin.categories.update', $category->slug) }}" method="POST" class="p-4">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $category->name) }}">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-primary">Reset</button>
            </form>
        </div>
    </div>
@endsection
