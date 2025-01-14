@extends('layouts.guest')
@section('content')
<div class="">
    <div class="py-20">
        <div class="">
            <img src="{{ asset('static/image/18.png') }}" alt="おかずせれくと.com" class="w-56 h-56 mx-auto" />
            <p class="pt-5 text-2xl font-bold text-center">ここから先は18歳以上の紳士のみ入場可能です。</p>
            <p class="pt-5 text-2xl font-bold text-center">あなたは18歳以上ですか？</p>
        </div>
        <div class="flex justify-center pt-10 mx-auto text-2xl font-bold">
            <form action={{ '/confirm-age' }} method="POST" class="">
                @csrf
                <button type="submit" class="hover:text-blue-500">YES(入場)</button>
            </form>
            <span class="">/</span>
            <a href={{ config('const.REDIRECT') }} class="hover:text-red-500">NO(退場)</a>
        </div>
        <div class="pt-10 text-center">
            <img src="{{ asset('static/image/site-title.png') }}" alt="おかずせれくと.com" class="mx-auto" />
        </div>
        <div class="text-center">
            <div class="w-9/12 pt-20 mx-auto">
                <h2 class="inline text-2xl font-bold border-b-4 border-pink-300">今晩のおかず、探してみませんか？</h2>
                <div class="flex items-center justify-start gap-4 pt-10">
                    <div class="p-3 text-gray-800 bg-pink-100 rounded-xl">
                        <h3 class="inline font-bold border-b-2 border-white">あなたにあった「おかず」をお探しします</h3>
                        <p class="p-3 pt-5 text-start">
                            おかずせれくと.comではあなたにあったらおかずを提案します。
                            <br>
                            使い方は簡単です。好きな女優、好きなメーカー、好きなジャンル ...etc
                            を選択するだけ。さながらマッチングアプリで好みの相手を探すように...
                        </p>
                    </div>
                    <div class="inline ">
                        <img src="{{ asset('static/image/site-introduction-01.png') }}" alt="おかずせれくと.com" class="" />
                    </div>
                </div>

                <div class="flex items-center justify-start gap-4 pt-10">
                    <div class="inline ">
                        <img src="{{ asset('static/image/site-introduction-02.png') }}" alt="おかずせれくと.com" class="" />
                    </div>
                    <div class="p-3 text-gray-800 bg-blue-100 rounded-xl">
                        <h3 class="inline font-bold border-b-2 border-white">あなたに最適な「エロ」を</h3>
                        <p class="p-3 pt-5 text-start">
                            おかずせれくと.comは、あなたの好みを反映して最適なAVをピックアップします。
                            <br>
                            女優、プレイ内容、ジャンルを自由にカスタマイズし、理想の一作を簡単に見つけましょう。
                            <br>
                            毎日が新しい発見の連続です。
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-start gap-4 pt-10">
                    <div class="p-3 text-gray-800 bg-pink-100 rounded-xl">
                        <h3 class="inline font-bold border-b-2 border-white">すぐに理想の一作に出会える</h3>
                        <p class="p-3 pt-5 text-start">
                            煩わしいアカウント作成・登録は不要です。
                            <br>
                            必要なのはあなたが今「何がみたいか？」その気持ちだけです。
                        </p>
                    </div>
                    <div class="inline">
                        <img src="{{ asset('static/image/site-introduction-03.png') }}" alt="おかずせれくと.com" class="w-3/6 " />
                    </div>
                </div>
            </div>

            <div class="py-10 text-center">
                <span class="text-2xl font-bold text-gray-800">新しいおかずに出会に行く準備はできましたか？</span>
                <br>
                <br>
                <span class="text-2xl font-bold text-gray-800">最高の一本を探しにいきましょう</span>
            </div>
        </div>
        <div class="pt-20">
            <img src="{{ asset('static/image/18.png') }}" alt="おかずせれくと.com" class="w-56 h-56 mx-auto" />
            <p class="pt-5 text-2xl font-bold text-center">ここから先は18歳以上の紳士のみ入場可能です。</p>
            <p class="pt-5 text-2xl font-bold text-center">あなたは18歳以上ですか？</p>
        </div>
        <div class="flex justify-center pt-10 mx-auto text-2xl font-bold">
            <form action={{ '/confirm-age' }} method="POST" class="">
                @csrf
                <button type="submit" class="hover:text-blue-500">YES(入場)</button>
            </form>
            <span class="">/</span>
            <a href={{ config('const.REDIRECT') }} class="hover:text-red-500">NO(退場)</a>
        </div>
    </div>
    @include('components.footer')
</div>
@endsection
