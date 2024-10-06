$(function () {
	// 変数に要素を入れる
	var sampleImgModalWrapper = $('#sampleImgModalWrapper'),
		sampleImgContainer = $('#sampleImgContainer')

    $('.sampleImgOpenModal').on('click', function () {

        var targetContentId = $(this).data('content-id');
        sampleImgModalWrapper.empty();

        $.ajax({
            url: `get-sample-img/${targetContentId}`,
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
                }
                sampleImgContainer.removeClass('hidden')
            },
            error: function (error) {
                sampleImgModalWrapper.append('<p>画像を取得できませんでした。</p>');
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
});
