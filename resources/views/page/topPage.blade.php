@extends('layouts.app')
@section('content')
<div class="">
    @include('components.header')
    <div class="w-9/12 mx-auto">
        <h1 class="inline-block p-3 px-5 mt-4 text-xl font-bold text-gray-600 lg:mt-0 text-teal-lighter">
            <i class="mr-2 text-yellow-400 fa-solid fa-ranking-star"></i>リアルタイム人気上位ランキング
        </h1>
        @if($targetUrlToRanking)
        <div class="">
            @foreach($targetUrlToRanking['result']['items'] as $result)
                <div class="p-2 mx-auto my-2 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="">
                        @if(isset($result['campaign']))
                            @foreach($result['campaign'] as $campaignTitle)
                                <h2 class="px-3 py-2 text-lg font-bold text-red-600">
                                    {{ $campaignTitle['title'] }}
                                </h2>
                            @endforeach
                        @endif
                        <a
                            href={{ $result['affiliateURL'] }}
                            target=”_blank”
                        >
                            <h3 class="px-3 py-2 text-sm font-bold text-gray-600 hover:text-blue-500">
                                {{ $result['title'] }}
                            </h3>
                        </a>
                    </div>
                    <div class="">
                        @if(isset($result['iteminfo']['actress']))
                            @foreach($result['iteminfo']['actress'] as $actressList)
                                <a
                                    href={{ $actressList['name'] }}
                                    class="py-2 text-xs font-bold text-gray-600 hover:text-blue-500">
                                    ・{{ $actressList['name'] }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="p-2">
                        @foreach($result['iteminfo']['genre'] as $key => $value)
                            <a
                                href=""
                                class="px-2 py-1 mb-2 text-xs text-gray-900 bg-white border border-gray-200 rounded-full font-sm focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                <span class="">
                                    {{ $value['name'] }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <img class="mx-auto" src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} />
                    </div>
                    <div class="p-4 py-3">
                        @if(isset($result['sampleMovieURL']))
                            <button type="button" class="px-2 py-1 text-gray-900 bg-white border border-gray-200 rounded-full font-md text-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                <i class="pr-1 fa-solid fa-video" style="color: #ff6251;"></i>サンプル動画
                            </button>
                        @endif
                        @if(isset($result['sampleImageURL']))
                            <button type="button" class="px-2 py-1 text-gray-900 bg-white border border-gray-200 rounded-full font-md text-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                <i class="pr-1 fa-regular fa-image" style="color: #74C0FC;"></i>サンプル画像
                            </button>
                        @endif
                        <div class="text-right">
                            <a
                                target=”_blank”
                                href={{ $result['affiliateURL'] }}
                                class="px-2 py-1 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md text-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                <i class="pr-1 fa-solid fa-up-right-from-square"></i>FANZAへ
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        @else
            ng
        @endif
    </div>
    @include('components.footer')
</div>
@endsection
