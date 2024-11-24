<div id="series-modal-{{ $group }}" class="modal series-modal" data-target-close-modal="series-close-modal-{{ $group }}">
    <div class="modal-content">
        <span class="series-close">&times;</span>
        <h2>シリーズリスト</h2>
        <input
            type="text"
            class="w-full p-2 mb-4 border border-gray-300 rounded-md series-filter-input"
            placeholder="検索..."
            data-target-list="series-list-{{ $group }}">
        <ul id="series-list-{{ $group }}" class="series-list">
        </ul>
    </div>
</div>
