$(function () {
    var searchGenreArea = $('#search-genre-area');
    var searchActressesArea = $('#search-actress-area');
    var searchGenreBtn = $('#search-genre-btn');
    var searchAreaBtn = $('#search-actress-btn');
    var gojuonBtn = $('.search-acress-name-btn');
    var actressList = $('#actress-list');

    $(searchGenreArea).css('display', 'none');
    $(searchActressesArea).css('display', 'none');

    $(searchGenreBtn).on('click', function () {
        searchGenreArea.slideToggle();
    })

    $(searchAreaBtn).on('click', function () {
        searchActressesArea.slideToggle();
    })

    $(gojuonBtn).on('click', function () {
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
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('actress-modal').style.display = 'none';
    });




});
