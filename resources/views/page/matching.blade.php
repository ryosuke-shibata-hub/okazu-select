@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/matching.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@include('components.modal.sample-video')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-pink-600 lg:mr-2 fa-regular fa-heart"></i>おかずマッチング
</h1>
<div class="flex pt-10">
    <div class="w-11/12 p-2 mx-auto">
        @if(!empty($error))
            <div class="py-10 font-bold text-center">
                <span class="text-gray-600">
                    {{ $error }}
                </span>
            </div>
        @endif
        <div id="question-container">
            <h2 class="text-4xl font-bold text-center text-gray-600" id="question-text"></h2>
            <div class="pt-10 text-center">
                <span class="text-2xl font-bold text-gray-700">は好きですか？</span>
            </div>
            <div class="pt-20 text-center">
                <button
                    id="answer-yes-btn"
                    class="mr-5 answer-btn text-gray-700 hover:text-white border-2 border-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                    data-answer="YES">
                    YES
                </button>
                <button
                    id="answer-no-btn"
                    class="ml-5 answer-btn text-gray-700 hover:text-white border-2 border-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" data-answer="NO">
                    NO
                </button>
            </div>
        </div>
        <div
            id="view-matching-video"
            class="hidden pt-10 text-center">
            <div class="py-10 text-4xl text-center">
                <i class="fa-solid fa-heart fa-bounce fa-2xl" style="color: #ff2600;"></i>
            </div>
            <form action="/result" method="GET">
                @csrf
                <input type="hidden" id="selectGenre" name="selectGenre" value="" />
                <button
                    type="submit"
                    class="mt-10 ml-5 text-gray-700 hover:text-white border-2 border-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    マッチした作品を見てみる？
                </button>
            </form>
        </div>
    </div>
    {{-- @include('components.banner.right-banner') --}}
</div>
<input type="hidden" id="genre-data" value="{{ json_encode($getRandomGenre, JSON_UNESCAPED_UNICODE) }}">
@endsection
