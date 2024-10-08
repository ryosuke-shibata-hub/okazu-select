@extends('layouts.app')
@section('script')
<script src={{ asset('static/static.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@include('components.modal.sample-video')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-pink-600 lg:mr-2 fa-regular fa-heart"></i>おかずマッチング
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        {{-- @if($targetUrlToRanking) --}}

        {{-- @else
            @include('components.message.error')
        @endif --}}
    </div>
    @include('components.banner.right-banner')
</div>
@endsection
