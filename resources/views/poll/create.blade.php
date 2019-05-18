@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
    .form-control{
        display: inline-block;
    }
    .email{
        width: 30%;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Poll
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('poll.store') }}">
            <div class="form-group">
                @csrf
                <label for="name">Email:</label>
                <input type="text" class="form-control email" name="email"/>
            </div>
            <div class="form-group">
                <label for="price">What is your favourite JavaScript Library? :</label>
                @foreach($polloptions as $pOption)
                <p><input type="radio" class="" value="{{ $pOption->id }}" name="polloptions_id"/> &nbsp;{{ $pOption->name }}</p>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('poll.index')}}" class="btn btn-primary">Results</a>
        </form>
    </div>
</div>
@endsection