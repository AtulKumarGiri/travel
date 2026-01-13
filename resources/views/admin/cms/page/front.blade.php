@extends('layouts.front.index')

@section('title', $page->meta_title ?? $page->title)

@section('content')
<div class="container-fluid pb-5 pt-3">

    @if($page->image)
        <img src="{{ asset('storage/'.$page->image) }}" class="img-fluid mb-3">
    @endif

    <div>{!! $page->content !!}</div>

</div>
@endsection
