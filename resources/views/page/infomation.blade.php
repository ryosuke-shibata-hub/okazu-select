@extends('layouts.app')
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-green-500 fa-solid fa-circle-info lg:mr-2"></i>お知らせ
</h1>
<div class="py-5">
<div class="w-full text-left infomation-page">
    <table class="mx-auto font-bold text-gray-700 table-fixed">
        <thead class="text-xl">
            <tr>
            <th>お知らせ</th>
            <th class="px-5">カテゴリ</th>
            <th>更新日</th>
            </tr>
        </thead>
        <tbody class="">
            @foreach($infomation as $list)
                <tr class="border-b-2 border-gray-600 text-md">
                    <td>
                        <a href="/infomation/{{ $list->id }}" class="hover:text-blue-400">
                            {{ $list->title }}
                        </a>
                    </td>
                    <td class="px-5">
                        @if($list->category === 1)
                            リリース
                        @endif
                    </td>
                    <td>{{ $list->created_at->format('Y年m月d日') }}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
