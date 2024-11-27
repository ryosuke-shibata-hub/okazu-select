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
            <div class="py-5">
                <img src={{ $result['sampleImageURL']['sample_l']['image'][3] }} />
            </div>
            <div class="flex items-center justify-end space-x-4">
                <div class="balloon balloon-left">
                    <div class="balloon-arrow balloon-arrow-left"></div>
                     <p>{{ $recommendDetail->detail_meta_2 }}</p>
                </div>
                <img src="{{ asset('static/image/18.png') }}" alt="オカズセレクト" class="rounded-full w-14 h-14">
            </div>
            <div class="">
                <h3 class="font-bold text-gray-500">
                    @foreach($result['iteminfo']['actress'] as $actress)
                        {{ $actress['name'] }}さんのプロフィール
                    @endforeach
                </h3>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
