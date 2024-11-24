<div id="maker-modal-{{ $group }}" class="modal maker-modal" data-target-close-modal="maker-close-modal-{{ $group }}">
    <div class="modal-content">
        <span class="maker-close">&times;</span>
        <h2>メーカーリスト</h2>
        <input
            type="text"
            class="w-full p-2 mb-4 border border-gray-300 rounded-md maker-filter-input"
            placeholder="検索..."
            data-target-list="maker-list-{{ $group }}">
        <ul id="maker-list-{{ $group }}" class="maker-list">
        </ul>
    </div>
</div>
