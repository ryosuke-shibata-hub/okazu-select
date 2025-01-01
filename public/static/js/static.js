$(function () {
    var $setElm = $('.goods-banner');// 対象となるID・クラス
    var cutFigure = '15';// カットしたい文字数
    var afterTxt = '…';// カット後の文字

    $setElm.each(function(){
    var textLength = $(this).text().length;
    var textTrim = $(this).text().substr(0,(cutFigure));
    if(cutFigure < textLength) {
        $(this).html(textTrim + afterTxt).css({visibility:'visible'});
    } else if(cutFigure >= textLength) {
        $(this).css({visibility:'visible'});
    }
    });

    // サンプル画像の取得
	// 変数に要素を入れる
	var sampleImgModalWrapper = $('#sampleImgModalWrapper'),
		sampleImgContainer = $('#sampleImgContainer')

    $('.sampleImgOpenModal').on('click', function () {

        var targetContentId = $(this).data('content-id');
        sampleImgModalWrapper.empty();

        $.ajax({
            url: `/get-sample-data-detail/${targetContentId}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.result.items[0]['sampleImageURL']['sample_l']) {
                    response.result.items[0]['sampleImageURL']['sample_l']['image'].forEach(function (targetImgUrl) {
                        sampleImgModalWrapper.append(
                            `
                                <img src="${targetImgUrl}" class="mx-auto sample-image" alt="${targetImgUrl}" />
                            `
                        );
                    });
                } else if(response && response.result.items[0]['sampleImageURL']['sample_s']) {
                    response.result.items[0]['sampleImageURL']['sample_s']['image'].forEach(function (targetImgUrl) {
                        sampleImgModalWrapper.append(
                            `
                                <img src="${targetImgUrl}" class="mx-auto sample-image" alt="${targetImgUrl}" />
                            `
                        );
                    });
                } else {
                    sampleImgModalWrapper.append('<p>サンプル画像はありません。</p>');
                    sampleImgModalWrapper.addClass('bg-white');
                }
                sampleImgContainer.removeClass('hidden')
            },
            error: function (error) {
                sampleImgModalWrapper.append('<p>サンプル画像を取得できませんでした。</p>');
                sampleImgModalWrapper.addClass('bg-white pt-10');
                sampleImgContainer.removeClass('hidden');
            }
        })
        return false;
    })

    $('#sampleImgModalClose').on('click', function () {
        sampleImgContainer.addClass('hidden');
    })
    $('#sampleImgContainer').on('click', function () {
        sampleImgContainer.addClass('hidden');
    })


    // サンプル動画の取得
    var playSampleVideoBtn = $('.play-sample-video-btn')

    $(playSampleVideoBtn).on('click', function () {

        var $button = $(this); // クリックしたボタン
        var contentId = $button.data('content-id'); // ボタンのcontent-id
        var $targetArea = $('.play-sample-video-area[data-content-id="' + contentId + '"]'); // 対応する動画エリア
        var $targetWrapper = $targetArea.find('.sampleVideoModalWrapper'); // 対応する動画ラッパー

        $targetArea.slideToggle();
        $targetWrapper.empty();

        $.ajax({
            url: `/get-sample-data-detail/${contentId}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.result.items[0]['sampleMovieURL']) {
                    var targetVideoUrl = response.result.items[0]['sampleMovieURL']['size_720_480']
                    var targetVideoTitle = response.result.items[0]['title']
                        $targetWrapper.append(
                            `
                                <iframe
                                    name=${targetVideoTitle}
                                    class="w-full h-screen py-2"
                                    style="min-height: 516px"
                                    src="${targetVideoUrl}"
                                    scrolling="no"
                                    frameborder="0"
                                    allowfullscreen>
                                </iframe>
                            `
                        );
                } else {
                    $targetWrapper.append('<p>サンプル動画はありません。</p>');
                    $targetWrapper.addClass('bg-white')
                }
                $targetArea.removeClass('hidden')
            },
            error: function (error) {
                $targetWrapper.append('<p>サンプル動画を取得できませんでした。</p>');
                $targetWrapper.addClass('bg-white pt-10')
                $targetArea.removeClass('hidden');
            }
        })
        return false;
    })

    var playSampleVideoCloseBtn = $('.sampleVideoCloseBtn')

    $(playSampleVideoCloseBtn).on('click', function () {
        var $button = $(this); // クリックしたボタン
        var contentId = $button.data('content-id'); // ボタンのcontent-id
        var $targetArea = $('.play-sample-video-area[data-content-id="' + contentId + '"]'); // 対応する動画エリア
        $targetArea.hide();
     })
});
