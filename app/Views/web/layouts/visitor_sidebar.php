<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <a href="/web"
                        ><img src="<?= base_url('assets/images/logo/logo.svg'); ?>" alt="Logo" srcset=""
                            /></a>
                    </div>
                    <div class="theme-toggle d-flex gap-2 align-items-center mt-">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--system-uicons"
                                width="20"
                                height="20"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 21 21"
                        >
                            <g
                                    fill="none"
                                    fill-rule="evenodd"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                            >
                                <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"
                                ></path>
                                <g transform="translate(-210 -1)">
                                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path
                                            d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"
                                    ></path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input
                                    class="form-check-input me-0"
                                    type="checkbox"
                                    id="toggle-dark"
                            />
                            <label class="form-check-label"></label>
                        </div>
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--mdi"
                                width="20"
                                height="20"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path
                                    fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="sidebar-toggler x">
                        <a href="" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            
        </div>
        
        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3">
                    <img src="<?= base_url('assets/images/faces/3.jpg'); ?>" alt="" srcset="">
                </div>
                <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <ul class="menu">

                    <li class="sidebar-item <?= ($uri1 == 'index') ? 'active' : '' ?>">
                        <a href="/web" class="sidebar-link">
                            <span>Recommendation</span>
                        </a>
                    </li>

                    <!-- Rumah Gadang -->
                    <li class="sidebar-item <?= ($uri1 == 'rumahGadang') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <span>Rumah Gadang</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'rumahGadang') ? 'active' : '' ?>">
                            <!-- List Rumah Gadang -->
                            <li class="submenu-item" id="rg-list">
                                <a href="<?= base_url('/web/rumahGadang'); ?>">List Rumah Gadang</a>
                            </li>
                            <!-- Rumah Gadang Around You -->
                            <li class="submenu-item" id="rg-around-you">
                                    <a data-bs-toggle="collapse" href="#searchRadiusRG" role="button" aria-expanded="false" aria-controls="searchRadiusRG">Rumah Gadang Around You</a>
                                <div class="collapse mb-3" id="searchRadiusRG">
                                    <label for="inputRadiusRG" class="form-label">Radius: </label>
                                    <label id="radiusValueRG" class="form-label">0 m</label>
                                    <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusRG" name="inputRadius" onchange="updateRadius('RG'); radiusSearch({postfix: 'RG'});">
                                </div>
                            </li>
                            <li class="submenu-item has-sub" id="rg-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu" role="button" aria-expanded="false" aria-controls="subsubmenu" class="collapse">Search Rumah Gadang</a>
                                <ul class="subsubmenu collapse" id="subsubmenu">
                                    <!-- Rumah Gadang by Name -->
                                    <li class="submenu-item submenu-marker" id="rg-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNameRG" role="button" aria-expanded="false" aria-controls="searchNameRG">By Name</a>
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
                                        <a data-bs-toggle="collapse" href="#searchRatingRG" role="button" aria-expanded="false" aria-controls="searchRatingRG">By Rating</a>
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
                                        <a data-bs-toggle="collapse" href="#searchFacilityRG" role="button" aria-expanded="false" aria-controls="searchFacilityRG">By Facility</a>
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
                                        <a data-bs-toggle="collapse" href="#searchCategoryRG" role="button" aria-expanded="false" aria-controls="searchCategoryRG">By Category</a>
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
                            <span>Event</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'event') ? 'active' : '' ?>">
                            <!-- List Event -->
                            <li class="submenu-item" id="ev-list">
                                <a href="<?= base_url('/web/event'); ?>">List Event</a>
                            </li>
                            <!-- Event Around You -->
                            <li class="submenu-item" id="ev-around-you">
                                <a data-bs-toggle="collapse" href="#searchRadiusEV" role="button" aria-expanded="false" aria-controls="searchRadiusEV">Event Around You</a>
                                <div class="collapse mb-3" id="searchRadiusEV">
                                    <label for="inputRadiusEV" class="form-label">Radius: </label>
                                    <label id="radiusValueEV" class="form-label">0 m</label>
                                    <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusEV" name="inputRadius" onchange="updateRadius('EV'); radiusSearch({postfix: 'EV'});">
                                </div>
                            </li>
                            <li class="submenu-item has-sub" id="ev-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu" role="button" aria-expanded="false" aria-controls="subsubmenu" class="collapse">Search Event</a>
                                <ul class="subsubmenu collapse" id="subsubmenu">
                                    <!-- Event by Name -->
                                    <li class="submenu-item submenu-marker" id="ev-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNameEV" role="button" aria-expanded="false" aria-controls="searchNameEV">By Name</a>
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
                                        <a data-bs-toggle="collapse" href="#searchRatingEV" role="button" aria-expanded="false" aria-controls="searchRatingEV">By Rating</a>
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
                                        <a data-bs-toggle="collapse" href="#searchCategoryEV" role="button" aria-expanded="false" aria-controls="searchCategoryEV">By Category</a>
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
                                        <a data-bs-toggle="collapse" href="#searchDateEV" role="button" aria-expanded="false" aria-controls="searchDateEV">By Date</a>
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
                </ul>
            </div>
            
        </div>
    </div>
</div>
