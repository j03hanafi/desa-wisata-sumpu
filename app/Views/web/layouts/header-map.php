<div class="col">
    <input type="hidden" id="currentLat" value="0">
    <input type="hidden" id="currentLng" value="0">
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Current Location" class="btn icon btn-primary mx-1" id="current-position" onclick="currentPosition()">
        <span class="material-symbols-outlined">my_location</span>
    </a>
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Manual Location" class="btn icon btn-primary mx-1" id="manual-position" onclick="manualPosition()">
        <span class="material-symbols-outlined">pin_drop</span>
    </a>
    <a href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle Legend" class="btn icon btn-primary mx-1">
        <span class="material-symbols-outlined">visibility</span>
    </a>
</div>