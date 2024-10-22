<div class="">
    <section class="p-8">
        <div class="grid justify-center gap-5 my-10 md:grid-cols-2 lg:grid-cols-6 lg:gap-7">
            @foreach($getGoodMatchingData['result']['items'] as $result)
                <div
                    class="max-w-xs overflow-hidden bg-white border rounded-lg shadow-md md:max-w-none">
                    <a
                        href={{ $result['affiliateURL'] }}
                        target="_blank"
                    >
                        <h3
                            class="px-3 py-2 font-bold text-gray-600 lg:text-lg hover:text-blue-500"
                            style="font-size: 0.90rem;">
                            {{ $result['title'] }}
                        </h3>
                    </a>
                    <div class="">
                        <span
                            class="py-2 text-xs font-bold text-gray-600 hover:text-blue-500">
                            {{ $result['prices']['list_price'] ?? $result['prices']['price']}}円
                        </span>
                    </div>
                    <img class="object-cover w-full h-56 lg:h-60" src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} />
                    <div class="flex p-1 pt-3 text-xs lg:text-center lg:text-xl lg:p-3">
                        <div class="lg:mx-auto">
                            <a
                                target="_blank"
                                href={{ $result['affiliateURL'] }}
                                class="px-1 py-1.5 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                                style="font-size: 0.75rem;">
                                <i class="fa-solid fa-up-right-from-square"></i>FANZAで購入する
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
