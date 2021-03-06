@extends('layouts.navbar')


@section('content')
<div class="container">
    <a href="{{ route('admin.posts') }}" class="btn btn-dark mb-3">Back to posts</a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ 'Add Post' }}</div>

                <div class="card-body">
                    <form action="{{ route('admin.post.store') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">Poster</label>

                            <div class="col-md-6">

                                <select class="form-control" data-live-search="true" name="user_id">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->firstname . " " . $user->lastname }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('user_id')
                                <span class="invalid-feedback" user_id="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}" required autocomplete="name" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    required autocomplete="description" autofocus>{{ old('description') }}</textarea>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ 'Save Changes' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection