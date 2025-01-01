<div
    id="play-sample-video-area"
    class="hidden sampleVideoContainer play-sample-video-area"　
    data-content-id="{{ $result['content_id'] }}"
    style="min-height: 516px"
>
    <div class="sampleVideoModalBody">
        <div class="sampleVideoModalWrapper"></div>
    </div>
    <div class="text-center sampleVideoCloseModal">
        <button
            type="button"
            class="p-1 font-bold border rounded-md sampleVideoCloseBtn"
            data-content-id="{{ $result['content_id'] }}"
        >
            閉じる
        </button>
    </div>
</div>
