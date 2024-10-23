@extends('layouts.app')
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-green-500 fa-solid fa-circle-info lg:mr-2"></i>お知らせ
</h1>

    <section class="text-gray-700 body-font px-28">
        <div class="container px-5 py-20 mx-auto">
            <h2 class="font-bold text-md lg:text-lg">
                {{ $targetInfomation->title }}
            </h2>
            <div class="text-left" style="padding: 150px 100px;">
                <p class="text-lg leading-relaxed w-44">
                    {!! $targetInfomation->detail !!}
                </p>
            </div>
        </div>
    </section>

@endsection