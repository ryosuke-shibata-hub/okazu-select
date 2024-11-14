@extends('layouts.app')
@section('script')
<script src={{ asset('static/js/static.js') }} defer></script>
@section('content')
@include('components.modal.sample-img')
@include('components.modal.sample-video')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="mr-2 text-yellow-400 fa-solid fa-ranking-star"></i>リアルタイム人気上位ランキング
</h1>
<div class="flex">
    <div class="w-11/12 p-2 mx-auto">
        @if($targetUrlToRanking)
            <div class="">
                @foreach($targetUrlToRanking['result']['items'] as $result)
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
                                        <span class="py-2 text-xs font-bold text-gray-600"><i class="pr-1 fa-solid fa-square"></i>{{ $iteminfo['name'] }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="pl-4">
                                @if(isset($result['iteminfo']['maker']))
                                    @foreach($result['iteminfo']['maker'] as $iteminfo)
                                    <a
                                        href='/search/result/maker/detail/{{ $iteminfo['id'] }}/{{ $iteminfo['name'] }}'
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
                        <div class="p-2">
                            @foreach($result['iteminfo']['genre'] as $genre)
                                <a
                                    href="/search/result/genre/{{$genre['id']}}/{{ $genre['name'] }}"
                                    class="px-1 text-xs text-gray-900 bg-white border border-gray-200 rounded-full font-sm focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                    <span class="">
                                        {{ $genre['name'] }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <img class="mx-auto" src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} />
                        </div>
                        <div class="flex p-1 pt-3 text-xs lg:text-center lg:text-xl lg:p-3">
                            <div class="lg:mx-auto">
                            @if(isset($result['sampleMovieURL']))
                                <button
                                    id=""
                                    type="button"
                                    data-content-id={{ $result['content_id'] }}
                                    class="p-1 text-gray-900 bg-white border border-gray-200 rounded-full sampleVideoOpenModal font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
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
                    </div>
                @endforeach
            </div>
        @else
            @include('components.message.error')
        @endif
    </div>
    @include('components.banner.right-banner')
</div>
@endsection
