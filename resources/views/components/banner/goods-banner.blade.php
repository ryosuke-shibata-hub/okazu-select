<section class="text-gray-600 body-font">
  <div class="container py-5 mx-auto lg:px-5">
    <div class="flex flex-col w-full text-center">
      <h1 class="mb-4 text-xs font-bold text-gray-600 lg:text-xl title-font">
            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
            ご一緒にこちらもいかがですか？
            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
            <i class="fa-solid fa-arrow-down fa-bounce lg:fa-2xl" style="color: #ff8c82;"></i>
      </h1>
    </div>
    <div class="flex flex-wrap -m-2">
        @foreach($getGoodMatchingData['result']['items'] as $result)
            <div class="w-full p-2 lg:w-1/3 md:w-1/2">
                <div class="flex items-center h-full p-4 border border-gray-200 rounded-lg">
                    <img src={{ $result['imageURL']['large'] }} alt={{ $result['title'] }} class="flex-shrink-0 object-cover object-center w-16 h-16 mr-4 bg-gray-100 rounded-lg">
                    <div class="flex-grow">
                        <a
                            href={{ $result['affiliateURL'] }}
                            target="_blank"
                        >
                        <h2 class="text-sm font-medium text-gray-700 title-font">{{ $result['title'] }}</h2>
                        <p class="text-xs font-bold text-right text-gray-500">{{ $result['prices']['list_price'] ?? $result['prices']['price']}}円</p>
                        </a>
                        <div class="flex p-1 pt-3 text-xs lg:text-center lg:text-xl lg:p-3">
                            <div class="lg:mx-auto">
                                <a
                                    target="_blank"
                                    href={{ $result['affiliateURL'] }}
                                    class="text-xs lg:text-md lg:px-1 lg:py-1.5 text-right text-gray-900 bg-white border border-gray-200 rounded-full font-md focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                                    style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-up-right-from-square"></i>FANZAで購入する
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</section>
