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
                    <li class="sidebar-title">Main Attraction</li>

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
                            <li class="submenu-item <?= ($uri1 == 'rumahGadang' && $uri2 == '') ? 'active' : '' ?>">
                                <a href="<?= base_url('/web/rumahGadang'); ?>">List Rumah Gadang</a>
                            </li>
                            <li class="submenu-item <?= ($uri2 == 'findByName') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByName') : ?>
                                <a data-bs-toggle="collapse" href="#searchNameRG" role="button" aria-expanded="true" aria-controls="searchNameRG">Search by Name</a>
                                <?php else : ?>
                                <a data-bs-toggle="collapse" href="#searchNameRG" role="button" aria-expanded="false" aria-controls="searchNameRG">Search by Name</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByName') ? 'show' : '' ?>" id="searchNameRG">
                                    <form action="<?= base_url('/web/rumahGadang/findByName'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?= $input ?? ''; ?>" <?= isset($input) ? 'autofocus' : ''; ?>>
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="submenu-item <?= ($uri2 == 'findByRadius') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByRadius') : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusRG" role="button" aria-expanded="true" aria-controls="searchRadiusRG">Search by Radius</a>
                                <?php else : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusRG" role="button" aria-expanded="false" aria-controls="searchRadiusRG">Search by Radius</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByRadius') ? 'show' : '' ?>" id="searchRadiusRG">
                                    <form action="<?= base_url('/web/rumahGadang/findByRadius'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" id="inputLatRG" name="lat">
                                        <input type="hidden" id="inputLngRG" name="long">
                                        <input type="hidden" id="radiusRG" name="radius">
                                        <label for="inputRadiusRG" class="form-label">Radius: </label>
                                        <label id="radiusValueRG" class="form-label">0 m</label>
                                        <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusRG" name="inputRadius" onchange="updateRadius('RG'); radiusSearch({postfix: 'RG'});">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- Event -->
                    <li class="sidebar-item <?= ($uri1 == 'event') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <span>Event</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'event') ? 'active' : '' ?>">
                            <li class="submenu-item <?= ($uri1 == 'event' && $uri2 == '') ? 'active' : '' ?>">
                                <a href="<?= base_url('/web/event'); ?>">List Event</a>
                            </li>
                            <li class="submenu-item <?= ($uri2 == 'findByName') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByName') : ?>
                                    <a data-bs-toggle="collapse" href="#searchNameEV" role="button" aria-expanded="true" aria-controls="searchNameEV">Search by Name</a>
                                <?php else : ?>
                                    <a data-bs-toggle="collapse" href="#searchNameEV" role="button" aria-expanded="false" aria-controls="searchNameEV">Search by Name</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByName') ? 'show' : '' ?>" id="searchNameEV">
                                    <form action="<?= base_url('/web/event/findByName'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?= $input ?? ''; ?>" <?= isset($input) ? 'autofocus' : ''; ?>>
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="submenu-item <?= ($uri2 == 'findByRadius') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByRadius') : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusEV" role="button" aria-expanded="true" aria-controls="searchRadiusEV">Search by Radius</a>
                                <?php else : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusEV" role="button" aria-expanded="false" aria-controls="searchRadiusEV">Search by Radius</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByRadius') ? 'show' : '' ?>" id="searchRadiusEV">
                                    <form action="<?= base_url('/web/event/findByRadius'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" id="inputLatEV" name="lat">
                                        <input type="hidden" id="inputLngEV" name="long">
                                        <input type="hidden" id="radiusEV" name="radius">
                                        <label for="inputRadiusEV" class="form-label">Radius: </label>
                                        <label id="radiusValueEV" class="form-label">0 m</label>
                                        <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusEV" name="inputRadius" onchange="updateRadius('EV'); radiusSearch({postfix: 'EV'});">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-title">Supporting Objects</li>

                    <li class="sidebar-item <?= ($uri1 == 'culinaryPlace') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <span>Culinary Place</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'culinaryPlace') ? 'active' : '' ?>">
                            <li class="submenu-item <?= ($uri1 == 'culinaryPlace' && $uri2 == '') ? 'active' : '' ?>">
                                <a href="<?= base_url('/web/culinaryPlace'); ?>">List Culinary Place</a>
                            </li>
                            <li class="submenu-item <?= ($uri2 == 'findByName') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByName') : ?>
                                    <a data-bs-toggle="collapse" href="#searchNameCP" role="button" aria-expanded="true" aria-controls="searchNameCP">Search by Name</a>
                                <?php else : ?>
                                    <a data-bs-toggle="collapse" href="#searchNameCP" role="button" aria-expanded="false" aria-controls="searchNameCP">Search by Name</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByName') ? 'show' : '' ?>" id="searchNameCP">
                                    <form action="<?= base_url('/web/culinaryPlace/findByName'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="input-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?= $input ?? ''; ?>" <?= isset($input) ? 'autofocus' : ''; ?>>
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <li class="submenu-item <?= ($uri2 == 'findByRadius') ? 'active' : '' ?>">
                                <?php if ($uri2 == 'findByRadius') : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusCP" role="button" aria-expanded="true" aria-controls="searchRadiusCP">Search by Radius</a>
                                <?php else : ?>
                                    <a data-bs-toggle="collapse" href="#searchRadiusCP" role="button" aria-expanded="false" aria-controls="searchRadiusCP">Search by Radius</a>
                                <?php endif; ?>
                                <div class="collapse mb-3 <?= ($uri2 == 'findByRadius') ? 'show' : '' ?>" id="searchRadiusCP">
                                    <form action="<?= base_url('/web/culinaryPlace/findByRadius'); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" id="inputLatCP" name="lat">
                                        <input type="hidden" id="inputLngCP" name="long">
                                        <input type="hidden" id="radiusCP" name="radius">
                                        <label for="inputRadiusCP" class="form-label">Radius: </label>
                                        <label id="radiusValueCP" class="form-label">0 m</label>
                                        <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusCP" name="inputRadius" onchange="updateRadius('CP'); radiusSearch({postfix: 'CP'});">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item <?= ($uri1 == 'worshipPlace') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <span>Worship Place</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'worshipPlace') ? 'active' : '' ?>">
                            <li class="submenu-item <?= ($uri2 == 'list') ? 'active' : '' ?>">
                                <a href="">List Worship Place</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item <?= ($uri1 == 'souvenirPlace') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <span>Souvenir Place</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'souvenirPlace') ? 'active' : '' ?>">
                            <li class="submenu-item <?= ($uri2 == 'list') ? 'active' : '' ?>">
                                <a href="">List Souvenir Place</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</div>