@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/search.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@include('components.modal.sample-video')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-blue-400 lg:mr-2 fa-solid fa-magnifying-glass"></i>検索
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        <div class="">
            <!-- ジャンル別 -->
            <div
                class="my-5 border border-gray-200 rounded-md dark:border-slate-700">
                <button
                    id="search-genre-btn"
                    class="w-full flex justify-between items-center py-2 px-4 bg-white dark:bg-[#20293A] dark:text-gray-400 text-gray-700 rounded-md mx-auto">
                    <span class="mx-auto font-bold text-gray-600">ジャンルから探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    id="search-genre-area"
                    class="grid grid-cols-3 gap-2 p-2 md:grid-cols-8 md:gap-4">
                    @foreach($genreData as $genre)
                        <a href="/search/result/genre/{{ $genre->genre_id }}/{{ $genre->genre_name }}" class="">
                            <div
                                class="border border-gray-500 overflow-hidden bg-white dark:bg-[#20293A] rounded-md"
                            >
                                <p class="p-1 text-xs text-left text-gray-700 dark:text-gray-400">{{ $genre->genre_name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <!-- 女優から -->
            <div
                class="my-3 border border-gray-200 rounded-md dark:border-slate-700">
                <button
                    id="search-actress-btn"
                    class="w-full flex justify-between items-center py-2 px-4 bg-white dark:bg-[#20293A] dark:text-gray-400 text-gray-700 rounded-md mx-auto">
                    <span class="mx-auto font-bold text-gray-600">女優から探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    id="search-actress-area"
                    class="grid grid-cols-4 gap-2 p-2 md:grid-cols-8 md:gap-4">
                    @foreach($actressGojuon as $group => $gojuon)
                            <button
                                id="search-acress-name-btn"
                                data-group="{{ $group }}"
                                class="search-acress-name-btn border border-gray-500 overflow-hidden bg-white dark:bg-[#20293A] rounded-md">
                                <p
                                    class="p-1 text-xs text-left text-gray-700 gojuon-btn dark:text-gray-400">
                                    {{ $gojuon }}
                                </p>
                            </button>
                            @include('components.modal.actress-list')
                    @endforeach
                </div>
            </div>
            {{-- フリーワード --}}
            <div class="my-3 text-center">
                <form action="/search/result/free-word/" method="GET">
                    <label for="free-word" class="px-4 py-2 text-sm font-bold text-gray-600">フリーワード検索</label>
                    <div class="">
                        <input
                            id="free-word"
                            name="searchKeyword"
                            type="text"
                            class="w-8/12 border rounded-md lg:w-9/12 border-slate-200"
                            placeholder="中出し　人妻　潮吹き"
                            />
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">検索</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('components.banner.right-banner')
</div>
@endsection
