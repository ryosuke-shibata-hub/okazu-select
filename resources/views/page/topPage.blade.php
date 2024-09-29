@extends('layouts.app')
@section('content')
<div class="">
    <div class="">
    <div class="pt-20">
        <img src="{{ asset('static/image/18.png') }}" alt="オカズセレクト" class="mx-auto w-56 h-56" />
        <p class="text-center font-bold text-2xl pt-5">ここから先は18歳以上の紳士のみ入場可能です。</p>
        <p class="text-center font-bold text-2xl pt-5">あなたは18歳以上ですか？</p>
    </div>
    <div class="text-center font-bold text-2xl pt-10">
        <a href="#" class="hover:text-blue-500">YES(入場)</a>
        <span class="">/</span>
        <a href="#" class="hover:text-red-500">NO(退場)</a>
    </div>
    <div class="pt-20">
        <h1 class="text-center font-bold text-6xl">オカズセレクト.com</h1>
    </div>
    </div>
</div>
@endsection
