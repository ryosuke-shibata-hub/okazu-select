<div id="actress-modal-{{ $group }}" class="modal actress-modal">
    <div class="modal-content">
        <span class="actress-close">&times;</span>
        <h2>女優名リスト</h2>
        <input
            type="text"
            class="w-full p-2 mb-4 border border-gray-300 rounded-md actress-filter-input"
            placeholder="検索..."
            data-target-list="actress-list-{{ $group }}">
        <ul id="actress-list-{{ $group }}" class="actress-list">
        </ul>
    </div>
</div>
