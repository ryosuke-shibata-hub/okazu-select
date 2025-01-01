<div class="p-2">
    @if(isset($result['iteminfo']['genre']))
        @foreach($result['iteminfo']['genre'] as $genre)
        <form action="/search/result/genre" method="GET" class="inline-block -mb-10">
            <input
                type="hidden"
                name="checked_genre[]"
                value={{ $genre['name'] }}
            />
            <button
                type="submit"
                class="px-1 text-gray-900 bg-white border border-gray-200 rounded-full text-2xs lg:text-xs font-sm focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                <span class="">
                    {{ $genre['name'] }}
                </span>
            </button>
        </form>
        @endforeach
    @endif
</div>
