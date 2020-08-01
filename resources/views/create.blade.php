@extends('layouts.app')

@section('content')
    <form method="POST" action="/">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" value="{{ old('title') }}" name="title" class="form-control @error('title') is-invalid @enderror" id="title">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="bodyText">Body</label>
            <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="bodyText">{{ old('body') }}</textarea>
            @error('body')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
@endsection

@section('scripts')
    <script>
        let textEditor = new EasyMDE();
    </script>
@endsection