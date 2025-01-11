@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/static.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@if($response == '')
    <div class="text-center">
        <p class="pt-5 my-5 text-xl font-bold text-gray-600 text-nowrap">お探しの作品が見つかりませんでした。</p>
        <a
            href="/search"
            class="inline-block pt-5 mt-4 text-xl font-bold text-gray-600 text-nowrap text-teal-lighter hover:text-blue-400">
                再検索
        </a>
    </div>
@else
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="mr-2 fa-solid fa-play fa-1xl" style="color: #63E6BE;"></i>
    @if(isset($genre))
        @foreach($genre as $value)
            「{{ $value }}」
        @endforeach
    @else
        「{{ $keyword }}」
    @endif

    の検索結果
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        @if($response['result']['items'])
            <div class="py-3 text-xs font-bold text-gray-500">
                <a href="/search/result/{{ $target }}/{{ $id }}/{{ $name }}/match" class="p-2 mr-2 border rounded-lg hover:bg-blue-300 hover:text-white">
                    おすすめ順
                </a>
                <a href="/search/result/{{ $target }}/{{ $id }}/{{ $name }}/rank" class="p-2 mr-3 border rounded-lg hover:bg-blue-300 hover:text-white">
                    人気順
                </a>
                <a href="/search/result/{{ $target }}/{{ $id }}/{{ $name }}/date" class="p-2 mr-3 border rounded-lg hover:bg-blue-300 hover:text-white">
                    新着順
                </a>
                <a href="/search/result/{{ $target }}/{{ $id }}/{{ $name }}/review" class="p-2 mr-3 border rounded-lg hover:bg-blue-300 hover:text-white">
                    評価順
                </a>
            </div>
            <div class="">
                @foreach($response['result']['items'] as $result)
                    <div class="p-2 mx-auto my-2 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="">
                            @if(isset($result['campaign']))
                                @foreach($result['campaign'] as $campaignTitle)
                                    <h2 class="px-3 py-2 text-xs font-bold text-red-600 lg:text-lg">
                                        {{ $campaignTitle['title'] }}
                                    </h2>
                                @endforeach
                            @endif
                            <a
                                href={{ $result['affiliateURL'] }}
                                target="_blank"
                            >
                                <h3 class="px-3 py-2 text-xs font-bold text-gray-600 lg:text-lg hover:text-blue-500">
                                    {{ $result['title'] }}
                                </h3>
                            </a>
                            <div class="pl-4">
                                @if(isset($result['iteminfo']['series']))
                                    @foreach($result['iteminfo']['series'] as $iteminfo)
                                        <a
                                            href='/search/result/series/detail/{{ $iteminfo['id'] }}/{{ str_replace('/', '／', $iteminfo['name']) }}'
                                            class="py-2 text-xs font-bold text-gray-600 hover:text-blue-500">
                                            <i class="pr-1 fa-xs fa-solid fa-location-pin"></i>{{ $iteminfo['name'] }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="pl-4">
                                @if(isset($result['iteminfo']['maker']))
                                    @foreach($result['iteminfo']['maker'] as $iteminfo)
                                    <a
                                        href='/search/result/maker/detail/{{ $iteminfo['id'] }}/{{ str_replace('/', '／', $iteminfo['name']) }}'
                                        class="py-2 text-xs font-bold text-gray-600 hover:text-blue-500">
                                        <i class="pr-1 fa-xs fa-solid fa-circle"></i>{{ $iteminfo['name'] }}
                                    </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="">
                            @if(isset($result['iteminfo']['actress']))
                                @foreach($result['iteminfo']['actress'] as $actressList)
                                    <a
                                        href='/search/result/actress/detail/{{ $actressList['id'] }}/{{ $actressList['name'] }}'
                                        class="py-2 text-xs font-bold text-gray-600 hover:text-blue-500">
                                        ・{{ $actressList['name'] }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                        {{-- ジャンルでのタグ検索用 --}}
                        @include('components.btn-group.search-genre-btn-group')
                        <div class="text-center">
                            <img class="mx-auto" src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} />
                        </div>
                        <div class="flex p-1 pt-3 text-xs lg:text-center lg:text-xl lg:p-3">
                            <div class="lg:mx-auto">
                            @if(isset($result['sampleMovieURL']))
                                <button
                                    type="button"
                                    data-content-id={{ $result['content_id'] }}
                                    class="px-2 py-1 text-gray-900 bg-white border border-gray-200 rounded-full play-sample-video-btn font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    <i class="pr-1 fa-solid fa-video" style="color: #ff6251;"></i>サンプル動画
                                </button>
                            @endif
                            @if(isset($result['sampleImageURL']))
                                <button
                                    id=""
                                    type="button"
                                    data-content-id={{ $result['content_id'] }}
                                    class="px-2 py-1 text-gray-900 bg-white border border-gray-200 rounded-full sampleImgOpenModal font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    <i class="pr-1 fa-regular fa-image" style="color: #74C0FC;"></i>サンプル画像
                                </button>
                            @endif
                                <a
                                    target="_blank"
                                    href={{ $result['affiliateURL'] }}
                                    class="px-2 py-1 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    <i class="pr-1 fa-solid fa-up-right-from-square"></i>FANZAへ
                                </a>
                            </div>
                        </div>
                    @include('components.modal.sample-video')
                    </div>
                @endforeach
            </div>
            {{-- バナーコンテンツ終わり --}}
            <div class="text-center">
                @include('components.banner.goods-banner')
            </div>
        @else
            <div class="py-5 text-center">
                <h3 class="text-xl font-bold text-gray-700">
                    {{ $keyword }}の検索結果は0件でした。
                </h3>
            </div>
        @endif
    </div>
    {{-- バナー右 --}}
    {{-- @include('components.banner.right-banner') --}}
</div>
@endif
@include('components.page-top-link')
@endsection
