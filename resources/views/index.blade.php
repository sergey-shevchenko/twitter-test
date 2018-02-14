@extends('layout')

@section('content')
    <form method="POST" action="{{ route('post.tweetReach') }}" enctype="multipart/form-data">


        {{ csrf_field() }}


        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label for="tweetUrl">Enter tweet URL</label>
            <input type="url" name="tweetUrl" id="tweetUrl">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Calculate Tweet Reach</button>
        </div>
    </form>
@endsection