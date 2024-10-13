$(function () {
    // サンプル画像の取得
	// 変数に要素を入れる
	var sampleImgModalWrapper = $('#sampleImgModalWrapper'),
		sampleImgContainer = $('#sampleImgContainer')

    $('.sampleImgOpenModal').on('click', function () {

        var targetContentId = $(this).data('content-id');
        sampleImgModalWrapper.empty();

        $.ajax({
            url: `get-sample-data-detail/${targetContentId}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.result.items[0]['sampleImageURL']) {
                    response.result.items[0]['sampleImageURL']['sample_l']['image'].forEach(function (targetImgUrl) {
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
                sampleImgModalWrapper.append('<p>画像を取得できませんでした。</p>');
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
	var sampleVideoModalWrapper = $('#sampleVideoModalWrapper'),
		sampleVideoContainer = $('#sampleVideoContainer')

    $('.sampleVideoOpenModal').on('click', function () {
        var targetContentId = $(this).data('content-id');
        sampleVideoModalWrapper.empty();

        $.ajax({
            url: `get-sample-data-detail/${targetContentId}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.result.items[0]['sampleMovieURL']) {
                    targetVideoUrl = response.result.items[0]['sampleMovieURL']['size_720_480']
                    targetVideoTitle = response.result.items[0]['title']
                        sampleVideoModalWrapper.append(
                            `
                            <div
                                style="width:100%;
                                padding-top: 75%;
                                position:relative;"
                            >
                                <iframe
                                    class="sampleVideoIframe"
                                    max-width="1280px"
                                    style="position: absolute; top: 0; left: 0;"
                                    src="${targetVideoUrl}"
                                    scrolling="no"
                                    frameborder="0"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            `
                        );
                } else {
                    sampleVideoModalWrapper.append('<p>サンプル画像はありません。</p>');
                    sampleVideoModalWrapper.addClass('bg-white')
                }
                sampleVideoContainer.removeClass('hidden')
            },
            error: function (error) {
                sampleVideoModalWrapper.append('<p>画像を取得できませんでした。</p>');
                sampleVideoModalWrapper.addClass('bg-white pt-10')
                sampleVideoContainer.removeClass('hidden');
            }
        })
        return false;
    })

    $('#sampleVideoModalClose').on('click', function () {
        sampleVideoContainer.addClass('hidden');
    })
    $('#sampleVideoContainer').on('click', function () {
        sampleVideoContainer.addClass('hidden');
    })
});
