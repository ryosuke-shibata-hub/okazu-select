@extends('errors.layout')
@section('title', __('Not Found'))
<di class="py-10">
    <div class="py-24 text-center">
        <h1 class="text-2xl font-bold text-center text-gray-700">
            404 Not Found
        </h1>
        <span class="font-bold text-gray-700">
            指定されたページが見つかりませんでした。
        </span>
    </div>
    <div class="font-bold text-center text-gray-700">
        <a href="/top" class="hover:text-blue-300">トップページへ戻る</a>
    </div>
</di>
