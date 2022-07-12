<!-- Check nearby -->
<div class="col-12" id="check-nearby-col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-center">Object Around</h5>
        </div>
        <div class="card-body">
            <div class="form-check">
                <div class="checkbox">
                    <input type="checkbox" id="check-cp" class="form-check-input" checked>
                    <label for="check-cp">Culinary</label>
                </div>
            </div>
            <div class="form-check">
                <div class="checkbox">
                    <input type="checkbox" id="check-wp" class="form-check-input">
                    <label for="check-cp">Worship</label>
                </div>
            </div>
            <div class="form-check">
                <div class="checkbox">
                    <input type="checkbox" id="check-sp" class="form-check-input">
                    <label for="check-cp">Souvenir</label>
                </div>
            </div>
            <div class="mt-3">
                <label for="inputRadiusNearby" class="form-label">Radius: </label>
                <label id="radiusValueNearby" class="form-label">0 m</label>
                <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusNearby" name="inputRadius" onchange="updateRadius('Nearby');">
            </div>
        </div>
    </div>
</div>

<!-- Search result nearby -->
<div class="col-12" id="result-nearby-col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-center">Search Result Object Around</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive overflow-auto" id="table-result-nearby">
                <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-cp">
                </table>
                <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-wp">
                </table>
                <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-sp">
                </table>
            </div>
        </div>
    </div>
</div>