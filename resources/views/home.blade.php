@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5">
                            <form method="post" action="{{ route('post') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">{{__('Title')}}</label>
                                    <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">{{__('Description')}}</label>
                                    <textarea class="form-control @error('title') is-invalid @enderror" name="description" rows="3"  required>{{old('description')}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                    <label for="user_id" class="control-label">User
                                        <span class="required">*</span>
                                    </label>
                                    <select name="user_id" id="area" class="form-control {{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                                        <option value="">--- Select an user ---</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                    <span class="text-danger">
                                    {{ $message }}
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group  mb-0">
                                    <div >
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">description</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 0)
                                @foreach($posts as  $post)
                                <tr>
                                    <th scope="row">{{$i+=1}}</th>
                                    <td>{{$post->title}}</td>
                                     <td>{{$post->description}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
