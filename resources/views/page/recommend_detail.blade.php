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
            <p class="pt-5 text-xs font-bold text-gray-600 lg:text-sm">配信開始日 {{ $result['date'] }}</p>
            <div class="py-5">
                <img src={{ $result['imageURL']['large'] }} />
            </div>
            <div class="flex items-center space-x-4">
                <img src="{{ asset('static/image/18.png') }}" alt="オカズセレクト" class="rounded-full w-14 h-14">
                <div class="balloon">
                    <div class="balloon-arrow"></div>
                    <p>{{ $recommendDetail->detail_meta_1 }}</p>
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
                            スリーサイズ：{{ $actressData['bust'] }}-{{ $actressData['waist'] }}-{{ $actressData['hip'] }}
                        </p>
                        <p class="py-1">
                            カップ数：{{ $actressData['cup'] }}
                        </p>
                        <p class="py-1">
                            身長：{{ $actressData['height'] }}cm
                        </p>
                        <p class="py-1">
                            生年月日：{{ $actressData['birthday'] }}
                        </p>
                        <p class="py-1">
                            血液型：{{ $actressData['blood_type'] }}型
                        </p>
                        <p class="py-1">
                            出身地：{{ $actressData['prefectures']}}
                        </p>
                        <p class="py-1">
                            趣味：{{ $actressData['hobby'] }}型
                        </p>
                        <div class="my-5">
                            <a
                                href='/search/result/actress/detail/{{ $actressData['id'] }}/{{ $actressData['name'] }}'
                                class="px-2 py-1 text-right bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
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
    </div>
    @endforeach
</div>

@endsection
