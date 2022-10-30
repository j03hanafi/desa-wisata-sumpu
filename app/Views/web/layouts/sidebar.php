<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <!-- Sidebar Header -->
        <?= $this->include('web/layouts/sidebar_header'); ?>
        
        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3" id="avatar-sidebar">
                    <img src="<?= base_url('media/photos/pesona_sumpu.png'); ?>" alt="" srcset="">
                </div>
                <?php if (logged_in()): ?>
                    <div class="p-2 text-center">
                        <?php if (!empty(user()->first_name)): ?>
                            Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span>
                        <?php else: ?>
                            Hello, <span class="fw-bold">@<?= user()->username; ?></span>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">

                    <li class="sidebar-item <?= ($uri1 == 'index') ? 'active' : '' ?>">
                        <a href="/web" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span>Recommendation</span>
                        </a>
                    </li>

                    <!-- Rumah Gadang -->
                    <li class="sidebar-item <?= ($uri1 == 'rumahGadang') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <i class="fa-solid fa-campground"></i><span>Rumah Gadang</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'rumahGadang') ? 'active' : '' ?>">
                            <!-- List Rumah Gadang -->
                            <li class="submenu-item" id="rg-list">
                                <a href="<?= base_url('/web/rumahGadang'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                            </li>
                            <!-- Rumah Gadang Around You -->
                            <li class="submenu-item" id="rg-around-you">
                                    <a data-bs-toggle="collapse" href="#searchRadiusRG" role="button" aria-expanded="false" aria-controls="searchRadiusRG"><i class="fa-solid fa-compass me-3"></i>Around You</a>
                                <div class="collapse mb-3" id="searchRadiusRG">
                                    <label for="inputRadiusRG" class="form-label">Radius: </label>
                                    <label id="radiusValueRG" class="form-label">0 m</label>
                                    <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusRG" name="inputRadius" onchange="updateRadius('RG'); radiusSearch({postfix: 'RG'});">
                                </div>
                            </li>
                            <li class="submenu-item has-sub" id="rg-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu-rg" role="button" aria-expanded="false" aria-controls="subsubmenu-rg" class="collapse"><i class="fa-solid fa-magnifying-glass me-3"></i>Search</a>
                                <ul class="subsubmenu collapse" id="subsubmenu-rg">
                                    <!-- Rumah Gadang by Name -->
                                    <li class="submenu-item submenu-marker" id="rg-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNameRG" role="button" aria-expanded="false" aria-controls="searchNameRG"><i class="fa-solid fa-arrow-down-a-z me-3"></i>By Name</a>
                                        <div class="collapse mb-3" id="searchNameRG">
                                            <div class="d-grid gap-2">
                                                <input type="text" name="nameRG" id="nameRG" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByName('RG')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Rumah Gadang by Rating -->
                                    <li class="submenu-item submenu-marker" id="rg-by-rating">
                                        <a data-bs-toggle="collapse" href="#searchRatingRG" role="button" aria-expanded="false" aria-controls="searchRatingRG"><i class="fa-regular fa-star me-3"></i>By Rating</a>
                                        <div class="collapse mb-3" id="searchRatingRG">
                                            <div class="d-grid gap-2">
                                                <div class="star-containter">
                                                    <i class="fa-solid fa-star" id="star-1" onclick="setStar('star-1');"></i>
                                                    <i class="fa-solid fa-star" id="star-2" onclick="setStar('star-2');"></i>
                                                    <i class="fa-solid fa-star" id="star-3" onclick="setStar('star-3');"></i>
                                                    <i class="fa-solid fa-star" id="star-4" onclick="setStar('star-4');"></i>
                                                    <i class="fa-solid fa-star" id="star-5" onclick="setStar('star-5');"></i>
                                                    <input type="hidden" id="star-rating" value="0">
                                                </div>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByRating('RG')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Rumah Gadang by Facility -->
                                    <li class="submenu-item submenu-marker" id="rg-by-facility">
                                        <a data-bs-toggle="collapse" href="#searchFacilityRG" role="button" aria-expanded="false" aria-controls="searchFacilityRG"><i class="fa-solid fa-house-circle-check me-3"></i>By Facility</a>
                                        <div class="collapse mb-3" id="searchFacilityRG">
                                            <div class="d-grid">
                                                <script>getFacility();</script>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="facilitySelect">
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByFacility()">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Rumah Gadang by Type -->
                                    <li class="submenu-item submenu-marker" id="rg-by-category">
                                        <a data-bs-toggle="collapse" href="#searchCategoryRG" role="button" aria-expanded="false" aria-controls="searchCategoryRG"><i class="fa-solid fa-bed me-3"></i>By Category</a>
                                        <div class="collapse mb-3" id="searchCategoryRG">
                                            <div class="d-grid">
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="categoryRGSelect">
                                                        <option value="Homestay">Homestay</option>
                                                        <option value="Tidak Homestay">Tidak Homestay</option>
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByCategory('RG')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- Event -->
                    <li class="sidebar-item <?= ($uri1 == 'event') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <i class="fa-solid fa-bullhorn"></i><span>Event</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'event') ? 'active' : '' ?>">
                            <!-- List Event -->
                            <li class="submenu-item" id="ev-list">
                                <a href="<?= base_url('/web/event'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                            </li>
                            <!-- Event Around You -->
                            <li class="submenu-item" id="ev-around-you">
                                <a data-bs-toggle="collapse" href="#searchRadiusEV" role="button" aria-expanded="false" aria-controls="searchRadiusEV"><i class="fa-solid fa-compass me-3"></i>Around You</a>
                                <div class="collapse mb-3" id="searchRadiusEV">
                                    <label for="inputRadiusEV" class="form-label">Radius: </label>
                                    <label id="radiusValueEV" class="form-label">0 m</label>
                                    <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusEV" name="inputRadius" onchange="updateRadius('EV'); radiusSearch({postfix: 'EV'});">
                                </div>
                            </li>
                            <li class="submenu-item has-sub" id="ev-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu-ev" role="button" aria-expanded="false" aria-controls="subsubmenu-ev" class="collapse"><i class="fa-solid fa-magnifying-glass me-3"></i>Search</a>
                                <ul class="subsubmenu collapse" id="subsubmenu-ev">
                                    <!-- Event by Name -->
                                    <li class="submenu-item submenu-marker" id="ev-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNameEV" role="button" aria-expanded="false" aria-controls="searchNameEV"><i class="fa-solid fa-arrow-down-a-z me-3"></i>By Name</a>
                                        <div class="collapse mb-3" id="searchNameEV">
                                            <div class="d-grid gap-2">
                                                <input type="text" name="nameEV" id="nameEV" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByName('EV')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Event by Rating -->
                                    <li class="submenu-item submenu-marker" id="ev-by-rating">
                                        <a data-bs-toggle="collapse" href="#searchRatingEV" role="button" aria-expanded="false" aria-controls="searchRatingEV"><i class="fa-regular fa-star me-3"></i>By Rating</a>
                                        <div class="collapse mb-3" id="searchRatingEV">
                                            <div class="d-grid gap-2">
                                                <div class="star-containter">
                                                    <i class="fa-solid fa-star" id="star-1" onclick="setStar('star-1');"></i>
                                                    <i class="fa-solid fa-star" id="star-2" onclick="setStar('star-2');"></i>
                                                    <i class="fa-solid fa-star" id="star-3" onclick="setStar('star-3');"></i>
                                                    <i class="fa-solid fa-star" id="star-4" onclick="setStar('star-4');"></i>
                                                    <i class="fa-solid fa-star" id="star-5" onclick="setStar('star-5');"></i>
                                                    <input type="hidden" id="star-rating" value="0">
                                                </div>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByRating('EV')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Event by Category -->
                                    <li class="submenu-item submenu-marker" id="ev-by-category">
                                        <a data-bs-toggle="collapse" href="#searchCategoryEV" role="button" aria-expanded="false" aria-controls="searchCategoryEV"><i class="fa-solid fa-check-to-slot me-3"></i>By Category</a>
                                        <div class="collapse mb-3" id="searchCategoryEV">
                                            <div class="d-grid">
                                                <script>getCategory();</script>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="categoryEVSelect">
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByCategory('EV')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Event by Date -->
                                    <li class="submenu-item submenu-marker" id="ev-by-date">
                                        <a data-bs-toggle="collapse" href="#searchDateEV" role="button" aria-expanded="false" aria-controls="searchDateEV"><i class="fa-solid fa-calendar-days me-3"></i>By Date</a>
                                        <div class="collapse mb-3" id="searchDateEV">
                                            <div class="d-grid gap-2">
                                                <div class="input-group date" id="datepicker">
                                                    <input type="text" class="form-control" id="eventDate">
                                                    <div class="input-group-addon ms-2">
                                                        <i class="fa-solid fa-calendar-days" style="font-size: 1.5rem; vertical-align: bottom"></i>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByDate()">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php if (in_groups('user')): ?>
                    <li class="sidebar-item <?= ($uri1 == 'visitHistory') ? 'active' : '' ?>">
                        <a href="<?= base_url('web/visitHistory'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-clock-rotate-left"></i><span>Visit History</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (in_groups(['owner', 'admin'])): ?>
                    <li class="sidebar-item">
                        <?php if (in_groups(['owner'])): ?>
                        <a href="<?= base_url('dashboard/rumahGadang'); ?>" class="sidebar-link">
                        <?php elseif (in_groups(['admin'])): ?>
                        <a href="<?= base_url('dashboard/users'); ?>" class="sidebar-link">
                        <?php endif; ?>
                            <i class="bi bi-grid-fill"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="sidebar-item">
                        <div class="d-flex justify-content-around">
                            <a href="https://www.instagram.com/pesonasumpu" class="sidebar-link" target="_blank">
                                <i class="fa-brands fa-instagram"></i><span>Instagram</span>
                            </a>
                            <a href="https://www.tiktok.com/@pesonasumpu2" class="sidebar-link" target="_blank">
                                <i class="fa-brands fa-tiktok"></i><span>TikTok</span>
                            </a>
                        </div>
                    </li>
                </ul>
                
            </div>
        </div>
    </div>
</div>
