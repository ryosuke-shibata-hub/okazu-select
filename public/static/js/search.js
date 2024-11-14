$(function () {
    var searchGenreArea = $('#search-genre-area');
    var searchActressesArea = $('#search-actress-area');
    var searchMakerArea = $('#search-maker-area');
    var searchGenreBtn = $('#search-genre-btn');
    var searchActressAreaBtn = $('#search-actress-btn');
    var searchMakerAreaBtn = $('#search-maker-btn');
    var actressGojuonBtn = $('.search-acress-name-btn');
    var makerGojuonBtn = $('.search-maker-name-btn');
    var actressList = $('#actress-list');
    var makerList = $('#maker-list');

    $(searchGenreArea).css('display', 'none');
    $(searchActressesArea).css('display', 'none');
    $(searchMakerArea).css('display', 'none');

    $(searchGenreBtn).on('click', function () {
        searchGenreArea.slideToggle();
    })

    $(searchActressAreaBtn).on('click', function () {
        searchActressesArea.slideToggle();
    })

    $(searchMakerAreaBtn).on('click', function () {
        searchMakerArea.slideToggle();
    })

    // 女優リストの取得
    $(actressGojuonBtn).on('click', function () {
        document.getElementById('actress-modal').style.display = 'block';

        var targetGojyuon = $(this).data('group');
        actressList.empty().append('<p class="loading-message">読み込み中...<i class="fa-solid fa-spinner fa-spin"></i></p>');

        $.ajax({
            url: `/get/api/actresses/${targetGojyuon}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                actressList.empty();
                if (response && response.length > 0) {
                    response.forEach(function (actress) {
                        actressList.append(
                            `
                            <li class="actress-item mx-auto flex flex-col items-center">
                                <a href="/search/result/actress/detail/${actress.actress_id}/${actress.actress_name}" class="actress-link">
                                    <img
                                        src="${actress.imageURL && actress.imageURL.trim() !== '' ?
                                        actress.imageURL : '/static/image/now_printing.jpg'}"
                                        alt="${actress.actress_name}" class="w-12 h-12 rounded-full"/>
                                    <p class="actress-name mt-2 text-xs">${actress.actress_name}</p>
                                </a>
                            </li>
                            `
                        );
                    });
                } else {
                    actressList.append('<p>対象の女優が見つかりませんでした</p>');
                    actressList.addClass('bg-white');
                }
            },
            error: function (error) {
                actressList.append('<p>女優データを取得できませんでした</p>');
                actressList.addClass('bg-white pt-10');
                actressList.removeClass('hidden');
            }
        })
        return false;
    });

    // モーダルを閉じる
    document.querySelector('.actress-close').addEventListener('click', function() {
        document.getElementById('actress-modal').style.display = 'none';
    });

    // メーカーリストの取得
    $(makerGojuonBtn).on('click', function () {
        document.getElementById('maker-modal').style.display = 'block';

        var targetGojyuon = $(this).data('group');
        makerList.empty().append('<p class="loading-message">読み込み中...<i class="fa-solid fa-spinner fa-spin"></i></p>');

        $.ajax({
            url: `/get/api/maker/${targetGojyuon}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                makerList.empty();
                if (response && response.length > 0) {
                    response.forEach(function (maker) {
                        makerList.append(
                            `
                            <a href="/search/result/maker/detail/${maker.maker_id}/${maker.maker_name}" class="">
                                <div
                                    class="border border-gray-500 overflow-hidden bg-white dark:bg-[#20293A] rounded-md"
                                >
                                    <p class="p-1 text-xs text-left text-gray-700 dark:text-gray-400">${maker.maker_name}</p>
                                </div>
                            </a>
                            `
                        );
                    });
                } else {
                    makerList.append('<p>対象のメーカーが見つかりませんでした</p>');
                    makerList.addClass('bg-white');
                }
            },
            error: function (error) {
                makerList.append('<p>メーカーデータを取得できませんでした</p>');
                makerList.addClass('bg-white pt-10');
                makerList.removeClass('hidden');
            }
        })
        return false;
    });

    document.querySelector('.maker-close').addEventListener('click', function() {
        document.getElementById('maker-modal').style.display = 'none';
    });
});
