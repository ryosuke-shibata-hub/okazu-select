$(function () {

    // ジャンル検索のオートコンプリート
    const $filterInputGenre = $("#filterInputGenre"); // フィルタ入力フィールド
    const $genreItems = $(".genre-item");  // 全ジャンルアイテム
    // 入力イベントの監視
    $filterInputGenre.on("input", function () {
        const query = $(this).val().trim().toLowerCase(); // 入力値を取得して小文字に変換

        $genreItems.each(function () {
            const $genreItem = $(this); // 現在のアイテムをjQueryオブジェクト化
            const genreName = $genreItem.data("genre").toLowerCase(); // `data-genre`属性を取得して小文字に変換

            // 入力値に一致する場合は表示、一致しない場合は非表示
            if (genreName.includes(query)) {
                $genreItem.show(); // 表示
            } else {
                $genreItem.hide(); // 非表示
            }
        });
    });
    // 女優リストのインプット
    $(".actress-filter-input").on("input", function () {
        const query = $(this).val().trim().toLowerCase();
        const targetListId = $(this).data("target-list");
        const $targetItems = $(`#${targetListId}`).find(".actress-filter-item");

        $targetItems.each(function () {
        const actressName = $(this).data("actress").toLowerCase();
            if (actressName.includes(query)) {
                $(this).closest(".actress-item").show();
            } else {
                $(this).closest(".actress-item").hide();
            }
        });
    });
    // メーカーリストのインプット
    $(".maker-filter-input").on("input", function () {
        const query = $(this).val().trim().toLowerCase();
        const targetListId = $(this).data("target-list");
        const $targetItems = $(`#${targetListId}`).find(".maker-filter-item");
        $targetItems.each(function () {
        const makersName = $(this).data("maker").toLowerCase();
            if (makersName.includes(query)) {
                $(this).closest(".maker-item").show();
            } else {
                $(this).closest(".maker-item").hide();
            }
        });
    });

    // シリーズリストのインプット
    $(".series-filter-input").on("input", function () {
        const query = $(this).val().trim().toLowerCase();
        const targetListId = $(this).data("target-list");
        const $targetItems = $(`#${targetListId}`).find(".series-filter-item");

        $targetItems.each(function () {
        const seriesName = $(this).data("series").toLowerCase();
            if (seriesName.includes(query)) {
                $(this).closest(".series-item").show();
            } else {
                $(this).closest(".series-item").hide();
            }
        });
    });


    //ジャンルリスト変数
    var searchGenreArea = $('#search-genre-area');
    var searchGenreInputArea = $('#open-filter-input-genre');
    var searchGenreBtn = $('#search-genre-btn');
    // 女優リスト変数
    var searchActressesArea = $('#search-actress-area');
    var searchActressesInputArea = $('#open-filter-input-actress');
    var searchActressAreaBtn = $('#search-actress-btn');
    var actressGojuonBtn = $('.search-acress-name-btn');
    // メーカーリスト変数
    var searchMakerArea = $('#search-maker-area');
    var searchMakerInputArea = $('#open-filter-input-maker');
    var searchMakerAreaBtn = $('#search-maker-btn');
    var makerGojuonBtn = $('.search-maker-name-btn');
    var makerList = $('#maker-list');
    // シリーズリスト変数
    var searchSeriesArea = $('#search-series-area');
    var searchSeriesInputArea = $('#open-filter-input-series');
    var searchSeriesAreaBtn = $('#search-series-btn');
    var seriesGojuonBtn = $('.search-series-name-btn');
    var seriesList = $('#series-list');


    $(searchGenreArea).css('display', 'none');
    $(searchGenreInputArea).css('display', 'none');

    $(searchActressesArea).css('display', 'none');
    $(searchActressesInputArea).css('display', 'none');

    $(searchMakerArea).css('display', 'none');
    $(searchMakerInputArea).css('display', 'none');

    $(searchSeriesArea).css('display', 'none');
    $(searchSeriesInputArea).css('display', 'none');


    $(searchGenreBtn).on('click', function () {
        searchGenreArea.slideToggle();
        searchGenreInputArea.slideToggle();
    })
    $(searchActressAreaBtn).on('click', function () {
        searchActressesArea.slideToggle();
        searchActressesInputArea.slideToggle();
    })
    $(searchMakerAreaBtn).on('click', function () {
        searchMakerArea.slideToggle();
        searchMakerInputArea.slideToggle();
    })
    $(searchSeriesAreaBtn).on('click', function () {
        searchSeriesArea.slideToggle();
        searchSeriesInputArea.slideToggle();
    })

    // 女優リストの取得
    $(actressGojuonBtn).on('click', function () {

        const targetModalId = $(this).data("target-modal");
        const targetGojyuon = $(this).data("group");
        const $targetModal = $("#" + targetModalId);
        const actressList = $(`#actress-list-${targetGojyuon}`);
        $targetModal.show();
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
                            <li class="actress-item flex flex-col items-center mx-auto actress-item">
                                <a href="/search/result/actress/detail/${actress.actress_id}/${actress.actress_name}"
                                class="actress-link actress-filter-item"
                                data-actress="${actress.actress_name}">
                                <img src="${actress.imageURL || '/static/image/now_printing.jpg'}"
                                    alt="${actress.actress_name}" class="w-12 h-12 rounded-full"/>
                                <p class="mt-2 text-xs actress-name">${actress.actress_name}</p>
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
    // モーダルを閉じるボタンにイベントを付与
    $(document).on('click', '.actress-close', function () {
        const targetCloseModalId = $(this).closest('.actress-modal').attr('id');
        const $targetCloseModal = $("#" + targetCloseModalId);
        // モーダルを非表示にする
        $targetCloseModal.hide();
    });


    // メーカーリストの取得
    $(makerGojuonBtn).on('click', function () {
        const targetModalId = $(this).data("target-modal");
        const targetGojyuon = $(this).data("group");
        const $targetModal = $("#" + targetModalId);
        const makerList = $(`#maker-list-${targetGojyuon}`);
        $targetModal.show();

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
                            <li class="maker-item flex flex-col items-center mx-auto">
                            <a href="/search/result/maker/detail/${maker.maker_id}/${maker.maker_name}"
                                class="maker-link maker-filter-item"
                                data-maker="${maker.maker_name}">
                                <div
                                    class="border border-gray-500 overflow-hidden bg-white rounded-md"
                                >
                                    <p class="p-1 text-xs text-left text-gray-700">${maker.maker_name}</p>
                                </div>
                            </a>
                            </li>
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
    // モーダルを閉じるボタンにイベントを付与
    $(document).on('click', '.maker-close', function () {
        const targetCloseModalId = $(this).closest('.maker-modal').attr('id');
        const $targetCloseModal = $("#" + targetCloseModalId);
        // モーダルを非表示にする
        $targetCloseModal.hide();
    });
    // シリーズリストの取得
    $(seriesGojuonBtn).on('click', function () {
        const targetModalId = $(this).data("target-modal");
        const targetGojyuon = $(this).data("group");
        const $targetModal = $("#" + targetModalId);
        const seriesList = $(`#series-list-${targetGojyuon}`);
        $targetModal.show();
        // document.getElementById('series-modal').style.display = 'block';

        // var targetGojyuon = $(this).data('group');
        seriesList.empty().append('<p class="loading-message">読み込み中...<i class="fa-solid fa-spinner fa-spin"></i></p>');

        $.ajax({
            url: `/get/api/series/${targetGojyuon}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                seriesList.empty();
                if (response && response.length > 0) {
                    response.forEach(function (series) {
                        seriesList.append(
                            `
                            <li class="series-item flex flex-col items-center mx-auto">
                            <a href="/search/result/series/detail/${series.series_id}/${series.series_name}"
                                class="series-link series-filter-item"
                                data-series="${series.series_name}">
                                <div
                                    class="border border-gray-500 overflow-hidden bg-white rounded-md"
                                >
                                    <p class="p-1 text-xs text-left text-gray-700">${series.series_name}</p>
                                </div>
                            </a>
                            </li>
                            `
                        );
                    });
                } else {
                    seriesList.append('<p>対象のシリーズが見つかりませんでした</p>');
                    seriesList.addClass('bg-white');
                }
            },
            error: function (error) {
                seriesList.append('<p>シリーズデータを取得できませんでした</p>');
                seriesList.addClass('bg-white pt-10');
                seriesList.removeClass('hidden');
            }
        })
        return false;
    });
    // モーダルを閉じるボタンにイベントを付与
    $(document).on('click', '.series-close', function () {
        const targetCloseModalId = $(this).closest('.series-modal').attr('id');
        const $targetCloseModal = $("#" + targetCloseModalId);
        // モーダルを非表示にする
        $targetCloseModal.hide();
    });
});
