@extends('layouts.app')
@section('content')

<div class="py-5">
    @foreach($response['result']['items'] as $result)
    <div class="p-3 px-5 mx-auto recommend-detail-lg ">
        <h1 class="mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
            {{ $result['title'] }}
        </h1>
        <div class="pt-5">
            <p class="text-sm font-bold text-gray-600 lg:text-base">出演女優</p>
            <h2>
                @foreach($result['iteminfo']['actress'] as $actress)
                    <a class="font-bold text-gray-500" href="/search/result/free-word/?searchKeyword={{ $actress['name'] }}">
                        ・{{ $actress['name'] }}
                    </a>
                @endforeach
            </h2>
            <p class="pt-5 text-sm font-bold text-gray-600 lg:text-base">メーカー</p>
            <h2>
                @foreach($result['iteminfo']['maker'] as $maker)
                    <a class="font-bold text-gray-500" href="/search/result/free-word/?searchKeyword={{ $maker['name'] }}">
                        ・{{ $maker['name'] }}
                    </a>
                @endforeach
            </h2>
            @if(isset($result['iteminfo']['series']))
                <p class="pt-5 text-sm font-bold text-gray-600 lg:text-base">シリーズ</p>
                <h2>
                    @foreach($result['iteminfo']['series'] as $series)
                        <a class="font-bold text-gray-500" href="/search/result/free-word/?searchKeyword={{ $series['name'] }}">
                            ・{{ $series['name'] }}
                        </a>
                    @endforeach
                </h2>
            @endif
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
            <p class="pt-5 text-xs font-bold text-gray-600 lg:text-sm">
                配信開始日 {{ date('Y年m月d日', strtotime($result['date']))   }}
            </p>
            <div class="py-5">
                <img src={{ $result['imageURL']['large'] }} />
            </div>
            <div class="flex items-center space-x-4">
                <img src="{{ asset('static/image/18.png') }}" alt="オカズセレクト" class="rounded-full w-14 h-14">
                <div class="balloon">
                    <div class="balloon-arrow"></div>
                    <p class="">{{ $recommendDetail->detail_meta_1 }}</p>
                </div>
            </div>
            <div class="pt-5 text-xs font-bold text-gray-600 lg:text-sm">
                <p class="py-5">
                    ＜作品紹介＞
                </p>
                <span class="">
                    {{ $recommendDetail->detail_meta_3 }}
                </span>
            </div>
            <div class="py-5">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            @foreach($result['sampleImageURL']['sample_l'] as $sampleImageList)
                                @foreach($sampleImageList as $image)
                                        <div class="p-4 md:w-1/3">
                                            <div class="h-full overflow-hidden border-2 border-gray-200 rounded-lg border-opacity-60">
                                            <img class="object-cover object-center w-full lg:h-48 md:h-36" src={{ $image }} alt="blog">
                                            </div>
                                        </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <div class="balloon balloon-left">
                    <div class="balloon-arrow balloon-arrow-left"></div>
                     <p>{{ $recommendDetail->detail_meta_2 }}</p>
                </div>
                <img src="{{ asset('static/image/18.png') }}" alt="オカズセレクト" class="rounded-full w-14 h-14">
            </div>
            <div class="">
                <h3 class="pb-10 font-bold text-gray-500">
                    @foreach($result['iteminfo']['actress'] as $actress)
                        {{ $actress['name'] }}さんのプロフィール
                    @endforeach
                </h3>
                <div class="p-10 text-sm font-bold text-gray-600 rounded-lg shadow-2xl justify-items-center lg:text-base">
                    @foreach($responseActressData['result']['actress'] as $actressData)
                        <img src={{ $actressData['imageURL']['large'] }} class="w-48 h-48 rounded-full"/>
                        <h3 class="py-1">
                            女優名：{{ $actressData['name'] }}（{{ $actressData['ruby'] }}）
                        </h3>
                        <p class="py-1">
                            @if($actressData['bust'] && $actressData['waist'] && $actressData['hip'])
                                スリーサイズ：{{ $actressData['bust'] }}-{{ $actressData['waist'] }}-{{ $actressData['hip'] }}
                            @else
                                スリーサイズ：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['cup'])
                                カップ数：{{ $actressData['cup'] }}
                            @else
                                カップ数：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['height'])
                                身長：{{ $actressData['height'] }}cm
                            @else
                                身長：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['birthday'])
                                生年月日：{{ date('Y年m月d日', strtotime($actressData['birthday'])) }}
                            @else
                                生年月日：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['blood_type'])
                                血液型：{{ $actressData['blood_type'] }}型
                            @else
                                血液型：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['prefectures'])
                                出身地：{{ $actressData['prefectures']}}
                            @else
                                出身地：-
                            @endif
                        </p>
                        <p class="py-1">
                            @if($actressData['hobby'])
                                趣味：{{ $actressData['hobby'] }}型
                            @else
                                趣味：-
                            @endif
                        </p>
                        <div class="my-5">
                            <a
                                href='/search/result/actress/detail/{{ $actressData['id'] }}/{{ $actressData['name'] }}'
                                class="px-2 py-1 text-right bg-white border border-gray-200 rounded-full text-2xs font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 text-nowrap">
                                <i class="pr-1 fa-solid fa-magnifying-glass"></i>{{ $actressData['name'] }}さんの作品をもっと見る？
                            </a>
                        </div>
                    @endforeach
                    <div class="my-5">
                        <a
                            target="_blank"
                            href={{ $result['affiliateURL'] }}
                            class="px-2 py-1 text-right bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                            <i class="pr-1 fa-solid fa-up-right-from-square"></i>FANZAで購入する
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if($responseGoodsData['result']['result_count'] != 0)
            <section class="text-gray-600 body-font">
                <div class="container py-5 mx-auto lg:px-5">
                    <div class="flex flex-col w-full text-center">
                    <h1 class="mb-4 font-bold text-gray-600 text-2xs lg:text-xl title-font">
                            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
                            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
                            「{{ $result['title'] }}」のお供にこちらもいかがですか？
                            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
                            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
                    </h1>
                    </div>
                    <div class="flex flex-wrap -m-2">
                        @foreach($responseGoodsData['result']['items'] as $result)
                            <div class="w-full p-2 lg:w-1/3 md:w-1/2">
                                <div class="flex items-center h-full p-4 border border-gray-200 rounded-lg">
                                    <img src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} class="flex-shrink-0 object-cover object-center w-16 h-16 mr-4 bg-gray-100 rounded-lg">
                                    <div class="flex-grow">
                                        <a
                                            href={{ $result['affiliateURL'] }}
                                            target="_blank"
                                        >
                                        <h2 class="text-sm font-medium text-gray-700 title-font goods-banner">{{ $result['title'] }}</h2>
                                        <p class="text-xs font-bold text-right text-gray-500">{{ $result['prices']['list_price'] ?? $result['prices']['price']}}円</p>
                                        </a>
                                        <div class="flex p-1 pt-3 text-xs lg:text-center lg:text-xl lg:p-3">
                                            <div class="lg:mx-auto">
                                                <a
                                                    target="_blank"
                                                    href={{ $result['affiliateURL'] }}
                                                    class="text-xs lg:text-md lg:px-1 lg:py-1.5 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                                                    style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-up-right-from-square"></i>FANZAで購入する
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
    @endforeach
</div>
@include('components.page-top-link')
@endsection
