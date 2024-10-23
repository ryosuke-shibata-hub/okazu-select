@extends('layouts.app')
@section('content')
<h1 class="inline-block p-3 px-5 mt-4 text-xs font-bold text-gray-600 lg:mt-0 text-teal-lighter lg:text-xl">
    <i class="text-gray-800 border-4 rounded-full lg:p-1 lg:px-2 fa-solid fa-question" style="color: #929292;"></i>ヘルプ
</h1>
<div class="help-page">
    <div class="text-center">
        <h2 class="inline-block text-2xl font-bold text-center text-gray-600 border-b-2 border-gray-500 section-title">
            <i class="fa-solid fa-circle-info"></i> おかずせれくと.comとは？
        </h2>
    </div>

    <p class="pt-5 font-bold text-center text-gray-600 intro-text">
        今日のおかず探しに悩んでいませんか？<br>
        おかずセレクトでは、あなたの好みに合ったおかずを簡単に見つけることができます。
    </p>
    <p class="pt-5 font-bold text-center text-gray-600 feature-text">
        「人気のおかず」では評価の高い作品を厳選して紹介しています。<br>
        「検索」機能では、ジャンル、女優名、またはフリーワードからおかずを見つけられます。<br>
        自分だけのお気に入り作品を探し出しましょう！
    </p>
    <p class="pt-5 font-bold text-center text-gray-600 feature-text">
        「おかずマッチング」機能では、ランダムな質問にYES・NOで答えるだけで、今の気分にぴったりなおかずを提案いたします。
    </p>
    <div class="pt-10 text-center">
        <h2 class="inline-block pt-5 text-2xl font-bold text-center text-gray-600 border-b-2 border-gray-500 section-title">
            <i class="fa-regular fa-heart" style="color: #ff6251;"></i> 気に入った作品はすぐに購入可能！
        </h2>
    </div>
    <p class="pt-5 font-bold text-center text-gray-600 purchase-info">
        あなたが見つけたおかずを気に入ったら、作品情報の「FANZAで見る」ボタンからすぐに購入できます。<br>
        FANZAの公式サイトへ移動して、スムーズに購入手続きを進められます。
    </p>
    <div class="pt-10 text-center">
        <h2 class="inline-block pt-5 text-2xl font-bold text-center text-gray-600 border-b-2 border-gray-500 section-title">
            <i class="fa-solid fa-comment-dollar" style="color: #000000;"></i> 100%無料で利用可能！会員登録も不要
        </h2>
    </div>
    <p class="pt-5 font-bold text-center text-gray-600 free-info">
        おかずセレクトは完全無料で、面倒な会員登録も不要です。<br>
        今すぐ、あなたが求めるおかずを見つけましょう！
    </p>
    <div class="pt-10 text-center">
        <h2 class="inline-block pt-5 text-2xl font-bold text-center text-gray-600 border-b-2 border-gray-500 section-title">
            <i class="fa-regular fa-handshake"></i>サイトの改善にご協力ください
        </h2>
    </div>
    <p class="pt-5 font-bold text-center text-gray-600 feedback-request">
        おかずセレクトをより良いサイトにするために、皆様のご意見やご要望をお待ちしております。<br>
        サイトの機能に関するご提案や改善点があれば、ぜひお聞かせください。
    </p>
    <p class="pt-5 font-bold text-center text-gray-600 feedback-link">
        ご意見・ご要望は<a href="https://forms.gle/PMP2CcXwvApLLjFu6" class="feedback-url" target="_blank">こちらのフォームまで</a>お問合せください。
    </p>
</div>
@endsection
