@extends('layouts.app')
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-yellow-400 fa-regular fa-star lg:mr-2"></i>おすすめ
</h1>
<div class="flex pt-10">
    <div class="w-11/12 p-2 mx-auto">
        <div class="py-5">
            <div class="w-full text-left recommend-list">
            <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-col w-full mb-20 text-center">
                        <h1 class="mb-4 text-base font-medium tracking-widest text-gray-900 lg:text-2xl title-font">おかずせれくと.comのおすすめAV</h1>
                        <p class="mx-auto leading-relaxed text-2xs lg:text-base lg:w-2/3">
                            おかずせれくと.comの中の人が個人的におすすめするAV作品を紹介！
                        </p>
                        </div>
                        @foreach($recommendList as $list)
                            <div class="w-full">
                                <div class="p-4">
                                    <div class="flex flex-col items-center justify-center w-full h-full text-center sm:flex-row sm:justify-start sm:text-left">
                                        <img
                                            alt={{ $list->title }}
                                            class="flex-shrink-0 object-cover object-center w-48 h-48 mb-4 rounded-lg sm:mb-0"
                                            src={{ $list->thumbnail }}
                                        >
                                        <div class="flex-grow sm:pl-8">
                                            <h2 class="text-lg font-medium text-gray-900 title-font">
                                                <a href="/recommend/detail/{{ $list->content_id }}">
                                                    {{ $list->title }}
                                                </a>
                                            </h2>
                                            @if($list->actress)
                                                <h3 class="mb-3 text-gray-500">
                                                    <a href="/search/result/free-word/?searchKeyword={{ $list->actress }}">
                                                        ・{{ $list->actress }}
                                                    </a>
                                                </h3>
                                            @endif
                                            <p class="mb-1 text-xs">
                                                <a href="/search/result/free-word/?searchKeyword={{ $list->maker }}">
                                                    <i class="pr-1 fa-xs fa-solid fa-circle"></i>{{ $list->maker }}
                                                </a>
                                            </p>
                                            @if( $list->series)
                                            <p class="mb-4 text-xs">
                                                <a href="/search/result/free-word/?searchKeyword={{ $list->series }}">
                                                    <i class="pr-1 fa-xs fa-solid fa-circle"></i>{{ $list->series }}
                                                </a>
                                            </p>
                                            @endif
                                            <p class="py-1 text-xs">
                                                閲覧数：{{ $list->view_count }}
                                            </p>
                                            <span class="inline-flex">
                                                <a
                                                    href="/recommend/detail/{{ $list->content_id }}"
                                                    class="px-2 py-1 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                                    <i class="fa-solid fa-arrow-right"></i>この記事を読む
                                                </a>
                                            </span>
                                            <div class="w-full ">
                                                <span class="sm:text-center lg:right-0 text-2xs lg:text-xs">
                                                    更新日 {{ $list->updated_at->format('Y年m月d日') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
    {{-- @include('components.banner.right-banner') --}}
</div>
@include('components.page-top-link')
@endsection
