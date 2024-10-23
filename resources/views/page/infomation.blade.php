@extends('layouts.app')
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-green-500 fa-solid fa-circle-info lg:mr-2"></i>お知らせ
</h1>
<div class="py-5">
<div class="w-full text-left infomation-page">
    <div class="relative overflow-x-auto">
    <table class="mx-auto font-bold text-gray-700">
        <thead class="py-5 text-sm lg:text-xl">
            <tr>
            <th class="px-5 py-5">お知らせ</th>
            <th class="px-5 py-5">カテゴリ</th>
            <th class="px-5 py-5">更新日</th>
            </tr>
        </thead>
        <tbody class="">
            @foreach($infomation as $list)
                <tr class="text-xs border-b-2 border-gray-600 lg:text-base">
                    <td>
                        <a href="/infomation/{{ $list->id }}" class="hover:text-blue-400">
                            {{ $list->title }}
                        </a>
                    </td>
                    <td class="px-5">
                        @if($list->category === 1)
                            リリース
                        @elseif($list->category === 3)
                            おしらせ
                        @elseif($list->category === 5)
                            障害
                        @endif
                    </td>
                    <td>{{ $list->created_at->format('Y年m月d日') }}</td>
                </tr>

            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>

@endsection
