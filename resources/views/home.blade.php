@extends('layouts.app')

@section('content')
<div class="container-md ">
    <chat-component :user_id="{{\Illuminate\Support\Facades\Auth::user()->id}}"></chat-component>

</div>
@endsection

