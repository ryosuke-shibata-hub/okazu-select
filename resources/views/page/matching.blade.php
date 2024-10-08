@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/matching.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@include('components.modal.sample-video')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-pink-600 lg:mr-2 fa-regular fa-heart"></i>おかずマッチング
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        {{-- @if($targetUrlToRanking) --}}
            <div id="question-container">
                <h2 id="question-text"></h2>
                <button class="answer-btn" data-answer="YES">YES</button>
                <button class="answer-btn" data-answer="NO">NO</button>
            </div>
        {{-- @else
            @include('components.message.error')
        @endif --}}
    </div>
    @include('components.banner.right-banner')
</div>
<input type="hidden" id="genre-data" value="{{ json_encode($getRandomGenre, JSON_UNESCAPED_UNICODE) }}">
@endsection
