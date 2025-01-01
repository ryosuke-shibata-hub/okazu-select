@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/search.js') }} defer></script>
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-blue-400 lg:mr-2 fa-solid fa-magnifying-glass"></i>検索
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        <div class="">
            <!-- ジャンル別 -->
            <div
                class="my-5 border border-gray-200 rounded-md">
                <button
                    id="search-genre-btn"
                    class="flex items-center justify-between w-full px-4 py-2 mx-auto text-gray-700 bg-white rounded-md">
                    <span class="mx-auto font-bold text-gray-600">ジャンルから探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="p-5" id="open-filter-input-genre">
                    <input
                        type="text"
                        id="filterInputGenre"
                        class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-md"
                        placeholder="ジャンルを検索..."
                    >
                </div>
                <form action="/search/result/genre" method="GET">
                    <div
                        id="search-genre-area"
                        class="grid grid-cols-3 gap-2 p-2 mb-3 md:grid-cols-8 md:gap-4">
                        @foreach($genreData as $genre)
                        <div class="flex w-full genre-item" data-genre="{{ $genre->genre_name }}">
                            <input
                                type="checkbox"
                                class="mx-auto my-auto mr-1 rounded-lg"
                                name="checked_genre[]"
                                value={{ $genre->genre_name }}
                            />
                                <div
                                    class="w-full mx-auto my-auto overflow-hidden bg-white border border-gray-500 rounded-md genre-list"
                                >
                                    <p class="p-1 text-xs text-left text-gray-700">{{ $genre->genre_name }}</p>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="open-filter-btn-genre" class="py-3 text-center">
                        <button type="submit" class="px-5 py-1 text-base font-bold text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            検索
                        </button>
                    </div>
                </form>
            </div>
            <!-- 女優から -->
            <div
                class="my-3 border border-gray-200 rounded-md">
                <button
                    id="search-actress-btn"
                    class="flex items-center justify-between w-full px-4 py-2 mx-auto text-gray-700 bg-white rounded-md">
                    <span class="mx-auto font-bold text-gray-600">女優から探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    id="search-actress-area"
                    class="grid grid-cols-4 gap-2 p-2 md:grid-cols-8 md:gap-4">
                    @foreach($Gojuon as $group => $actress_gojuon)
                            <button
                                id="search-acress-name-btn"
                                data-group="{{ $group }}"
                                data-target-modal="actress-modal-{{ $group }}"
                                class="overflow-hidden bg-white border border-gray-500 rounded-md search-acress-name-btn">
                                <p
                                    class="p-1 text-xs text-left text-gray-700 actress-gojuon-btn">
                                    {{ $actress_gojuon }}
                                </p>
                            </button>
                            @include('components.modal.actress-list')
                    @endforeach
                </div>
            </div>
            <!-- メーカーから -->
            <div
                class="my-3 border border-gray-200 rounded-md">
                <button
                    id="search-maker-btn"
                    class="flex items-center justify-between w-full px-4 py-2 mx-auto text-gray-700 bg-white rounded-md">
                    <span class="mx-auto font-bold text-gray-600">メーカーから探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    id="search-maker-area"
                    class="grid grid-cols-4 gap-2 p-2 md:grid-cols-8 md:gap-4">
                    @foreach($Gojuon as $group => $gojuon)
                            <button
                                id="search-maker-name-btn"
                                data-group="{{ $group }}"
                                data-target-modal="maker-modal-{{ $group }}"
                                class="overflow-hidden bg-white border border-gray-500 rounded-md search-maker-name-btn">
                                <p
                                    class="p-1 text-xs text-left text-gray-700 gojuon-btn">
                                    {{ $gojuon }}
                                </p>
                            </button>
                            @include('components.modal.maker-list')
                    @endforeach
                </div>
            </div>
            <!-- シリーズから -->
            <div
                class="my-3 border border-gray-200 rounded-md">
                <button
                    id="search-series-btn"
                    class="flex items-center justify-between w-full px-4 py-2 mx-auto text-gray-700 bg-white rounded-md">
                    <span class="mx-auto font-bold text-gray-600">シリーズから探す</span>
                    <svg
                        class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    id="search-series-area"
                    class="grid grid-cols-4 gap-2 p-2 md:grid-cols-8 md:gap-4">
                    @foreach($Gojuon as $group => $gojuon)
                            <button
                                id="search-series-name-btn"
                                data-group="{{ $group }}"
                                data-target-modal="series-modal-{{ $group }}"
                                class="overflow-hidden bg-white border border-gray-500 rounded-md search-series-name-btn">
                                <p
                                    class="p-1 text-xs text-left text-gray-700 gojuon-btn">
                                    {{ $gojuon }}
                                </p>
                            </button>
                            @include('components.modal.series-list')
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
    {{-- @include('components.banner.right-banner') --}}
</div>
@include('components.page-top-link')
@endsection
