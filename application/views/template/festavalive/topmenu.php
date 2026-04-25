<!-- ========== NAVBAR DESKTOP (tidak berubah) ========== -->
<nav class="navbar navbar-expand-lg d-none d-md-block">
    <div class="container">
        <img src="<?php echo base_url('myesc.id/assets/FestavaLive/video/esc10.png'); ?>"
            alt="Logo"
            style="width: 40px; height: 40px; margin-right: 20px;">
        <a class="navbar-brand" href="<?php echo site_url() ?>">
            El Shaddai Church
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">

                <?php
                $rsMenu1 = $this->db->query('SELECT * FROM v_frontmenus WHERE levels=1 ORDER BY nomorurut');
                if ($rsMenu1->num_rows() > 0) {
                    foreach ($rsMenu1->result() as $row1) {
                        $urlmenu = '';
                        if ($row1->openinnewtab == '1') {
                            $openinnewtab = ' target="_blank" ';
                        } else {
                            $openinnewtab = '';
                        }

                        if ($menu == $row1->idmenu) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }

                        switch ($row1->jenismenu) {
                            case 'Url Link':
                                if ($row1->linkmenu == '/') {
                                    if (empty($menu)) {
                                        $active = 'active';
                                    }
                                    $urlmenu = site_url('home');
                                } else {
                                    if (substr($row1->linkmenu, 0, 1) == '/') {
                                        $urlmenu = site_url($row1->linkmenu . '/' . $this->encrypt->encode($row1->idmenu));
                                    } else {
                                        $urlmenu = $row1->linkmenu;
                                    }
                                }
                                break;
                            case 'Kategori Link':
                                $urlmenu = site_url('kategori/index/' . $this->encrypt->encode($row1->idmenu) . '/' . $row1->slug_pageskategori);
                                break;
                            case 'Page Link':
                                $urlmenu = site_url('pages/read/' . $this->encrypt->encode($row1->idmenu) . '/' . $row1->slug_pages);
                                break;
                            default:
                                $urlmenu = '#';
                                break;
                        }

                        $rsMenu2 = $this->db->query("SELECT * FROM v_frontmenus WHERE parentidmenu='" . $row1->idmenu . "' ORDER BY nomorurut");
                        if ($rsMenu2->num_rows() > 0) {
                            $active = '';
                            foreach ($rsMenu2->result() as $rowCekActive) {
                                if ($menu == $rowCekActive->idmenu) {
                                    $active = 'active';
                                    break;
                                }
                            }
                            echo '
                                <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle ' . $active . '" id="navbarDropdown" data-bs-toggle="dropdown">' . $row1->namamenu . '</a>
                                <div class="dropdown-menu m-0">';

                            foreach ($rsMenu2->result() as $row2) {
                                if ($row2->openinnewtab == '1') {
                                    $openinnewtab = ' target="_blank" ';
                                } else {
                                    $openinnewtab = '';
                                }
                                $urlmenu = '';
                                switch ($row2->jenismenu) {
                                    case 'Url Link':
                                        if (substr($row2->linkmenu, 0, 1) == '/') {
                                            $urlmenu = site_url($row2->linkmenu . '/' . $this->encrypt->encode($row2->idmenu));
                                        } else {
                                            $urlmenu = $row2->linkmenu;
                                        }
                                        break;
                                    case 'Kategori Link':
                                        $urlmenu = site_url('kategori/index/' . $this->encrypt->encode($row2->idmenu) . '/' . $row2->slug_pageskategori);
                                        break;
                                    case 'Page Link':
                                        $urlmenu = site_url('pages/read/' . $this->encrypt->encode($row2->idmenu) . '/' . $row2->slug_pages);
                                        break;
                                    default:
                                        $urlmenu = '#';
                                        break;
                                }
                                echo '<a href="' . $urlmenu . '" class="dropdown-item"' . $openinnewtab . '>' . $row2->namamenu . '</a>';
                            }
                            echo '</div></li>';
                        } else {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link ' . $active . '" href="' . $urlmenu . '"' . $openinnewtab . '>' . $row1->namamenu . '</a>
                                </li>
                            ';
                        }
                    }
                }
                ?>

                <?php
                if (empty($this->session->userdata('idjemaat'))) {
                    echo '<a href="' . site_url('login') . '" class="custom-btn d-lg-block d-none show-form-login">Login</a>';
                } else {
                    if ($menu == 'Akun') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    echo '
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle ' . $active . '" data-bs-toggle="dropdown">' . $this->session->userdata('namalengkap') . '<span class="badge bg-danger start-100 translate-middle rounded-pill text-sm notifikasi-permohonan" style="margin-left: 10px;"></span></a>
                            <div class="dropdown-menu m-0" style="min-width: 200px;">
                                <a href="' . site_url('akun/profil') . '" class="dropdown-item">Profil Saya</a>
                                <a href="' . site_url('akun/kelas') . '" class="dropdown-item">Kelas Saya</a>
                                <a href="' . site_url('permohonansaya') . '" class="dropdown-item">Pemohonan Saya
                                <span class="badge bg-danger start-100 translate-middle rounded-pill text-sm notifikasi-permohonan" style="margin-left: 10px;"></span></a>
                                <a href="' . site_url('login/keluar') . '" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>


<!-- ========== NAVBAR MOBILE — Slide Drawer ========== -->
<style>
/* Topbar mobile */
.mob-topbar {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1050;
    background: #000;
    height: 56px;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem;
    border-bottom: 1px solid #1a1a1a;
}
.mob-brand {
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.mob-brand img {
    width: 28px;
    height: 28px;
}
.mob-hamburger {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    z-index: 1100;
}
.mob-hamburger span {
    display: block;
    width: 22px;
    height: 2px;
    background: #fff;
    border-radius: 2px;
    transition: transform 0.3s ease, opacity 0.3s ease;
    transform-origin: center;
}
.mob-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.mob-hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.mob-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Overlay gelap */
.mob-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 1060;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.mob-overlay.show { opacity: 1; }

/* Drawer dari kanan */
.mob-drawer {
    position: fixed;
    top: 0; right: 0;
    width: 280px;
    height: 100%;
    background: #000;
    z-index: 1070;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    border-left: 1px solid #1a1a1a;
    overflow-y: auto;
}
.mob-drawer.open { transform: translateX(0); }

/* Drawer header */
.mob-drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem;
    height: 56px;
    border-bottom: 1px solid #1a1a1a;
    flex-shrink: 0;
}
.mob-drawer-title {
    font-size: 13px;
    color: #555;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    font-weight: 500;
}
.mob-close {
    background: none;
    border: none;
    color: #555;
    font-size: 20px;
    cursor: pointer;
    padding: 4px;
    line-height: 1;
    transition: color 0.15s;
}
.mob-close:hover { color: #fff; }

/* Nav items */
.mob-nav {
    flex: 1;
    padding: 0.5rem 0;
    list-style: none;
    margin: 0;
}
.mob-nav li { border-bottom: 1px solid #0d0d0d; }
.mob-nav a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 1.5rem;
    font-size: 14px;
    color: #ccc;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
}
.mob-nav a:hover,
.mob-nav a.active { background: #0a0a0a; color: #fff; }
.mob-nav a.active { border-left: 2px solid #fff; padding-left: calc(1.5rem - 2px); }

/* Submenu accordion */
.mob-submenu {
    list-style: none;
    margin: 0;
    padding: 0;
    background: #050505;
    display: none;
}
.mob-submenu.open { display: block; }
.mob-submenu li { border-top: 1px solid #0d0d0d; }
.mob-submenu a {
    padding: 12px 1.5rem 12px 2.25rem;
    font-size: 13px;
    color: #666;
}
.mob-submenu a:hover { color: #ccc; background: #080808; }
.mob-chevron {
    font-size: 10px;
    color: #444;
    transition: transform 0.25s;
    display: inline-block;
}
.mob-has-sub.open .mob-chevron { transform: rotate(180deg); }

/* Footer drawer */
.mob-drawer-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #1a1a1a;
    flex-shrink: 0;
}
.mob-user-info {
    font-size: 12px;
    color: #444;
    margin-bottom: 10px;
    letter-spacing: 0.04em;
}
.mob-user-name {
    font-size: 14px;
    font-weight: 500;
    color: #ccc;
    margin-bottom: 12px;
}
.mob-user-links {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.mob-user-links a {
    font-size: 13px;
    color: #555;
    text-decoration: none;
    padding: 6px 0;
    border-bottom: 1px solid #0d0d0d;
    transition: color 0.15s;
}
.mob-user-links a:hover { color: #ccc; }
.mob-login-btn {
    display: block;
    width: 100%;
    padding: 11px;
    background: #fff;
    color: #000;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    letter-spacing: 0.04em;
    border-radius: 2px;
    transition: background 0.15s;
}
.mob-login-btn:hover { background: #e0e0e0; color: #000; }

/* Spacer agar konten tidak tertutup topbar */
.mob-spacer { display: none; height: 56px; }

@media (max-width: 767px) {
    .mob-topbar { display: flex; }
    .mob-spacer { display: block; }
    /* Sembunyikan nav desktop di mobile */
    nav.navbar.d-md-none { display: none !important; }
}
</style>

<!-- Spacer -->
<div class="mob-spacer"></div>

<!-- Topbar -->
<div class="mob-topbar">
    <a class="mob-brand" href="<?php echo site_url() ?>">
        <img src="<?php echo base_url('myesc.id/assets/FestavaLive/video/esc10.png'); ?>" alt="Logo">
        El Shaddai Church
    </a>
    <button class="mob-hamburger" id="mobHamburger" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>

<!-- Overlay -->
<div class="mob-overlay" id="mobOverlay"></div>

<!-- Drawer -->
<div class="mob-drawer" id="mobDrawer">

    <div class="mob-drawer-header">
        <span class="mob-drawer-title">Menu</span>
        <button class="mob-close" id="mobClose">&#x2715;</button>
    </div>

    <ul class="mob-nav" id="mobNavList">
        <?php
        $rsMenuMob = $this->db->query('SELECT * FROM v_frontmenus WHERE levels=1 ORDER BY nomorurut');
        if ($rsMenuMob->num_rows() > 0) {
            foreach ($rsMenuMob->result() as $rowMob) {
                $urlmenuMob = '';
                $openinnewtabMob = ($rowMob->openinnewtab == '1') ? ' target="_blank"' : '';
                $activeMob = ($menu == $rowMob->idmenu) ? 'active' : '';

                switch ($rowMob->jenismenu) {
                    case 'Url Link':
                        if ($rowMob->linkmenu == '/') {
                            if (empty($menu))
                                $activeMob = 'active';
                            $urlmenuMob = site_url('home');
                        } else {
                            if (substr($rowMob->linkmenu, 0, 1) == '/') {
                                $urlmenuMob = site_url($rowMob->linkmenu . '/' . $this->encrypt->encode($rowMob->idmenu));
                            } else {
                                $urlmenuMob = $rowMob->linkmenu;
                            }
                        }
                        break;
                    case 'Kategori Link':
                        $urlmenuMob = site_url('kategori/index/' . $this->encrypt->encode($rowMob->idmenu) . '/' . $rowMob->slug_pageskategori);
                        break;
                    case 'Page Link':
                        $urlmenuMob = site_url('pages/read/' . $this->encrypt->encode($rowMob->idmenu) . '/' . $rowMob->slug_pages);
                        break;
                    default:
                        $urlmenuMob = '#';
                        break;
                }

                $rsMenu2Mob = $this->db->query("SELECT * FROM v_frontmenus WHERE parentidmenu='" . $rowMob->idmenu . "' ORDER BY nomorurut");

                if ($rsMenu2Mob->num_rows() > 0) {
                    $activeMob = '';
                    foreach ($rsMenu2Mob->result() as $rowCek) {
                        if ($menu == $rowCek->idmenu) {
                            $activeMob = 'active';
                            break;
                        }
                    }
                    echo '<li class="mob-has-sub">
                        <a href="#" class="' . $activeMob . '" onclick="toggleMobSub(this); return false;">
                            <span>' . $rowMob->namamenu . '</span>
                            <span class="mob-chevron">▾</span>
                        </a>
                        <ul class="mob-submenu">';
                    foreach ($rsMenu2Mob->result() as $row2Mob) {
                        $openinnewtab2 = ($row2Mob->openinnewtab == '1') ? ' target="_blank"' : '';
                        $urlmenu2 = '';
                        switch ($row2Mob->jenismenu) {
                            case 'Url Link':
                                if (substr($row2Mob->linkmenu, 0, 1) == '/') {
                                    $urlmenu2 = site_url($row2Mob->linkmenu . '/' . $this->encrypt->encode($row2Mob->idmenu));
                                } else {
                                    $urlmenu2 = $row2Mob->linkmenu;
                                }
                                break;
                            case 'Kategori Link':
                                $urlmenu2 = site_url('kategori/index/' . $this->encrypt->encode($row2Mob->idmenu) . '/' . $row2Mob->slug_pageskategori);
                                break;
                            case 'Page Link':
                                $urlmenu2 = site_url('pages/read/' . $this->encrypt->encode($row2Mob->idmenu) . '/' . $row2Mob->slug_pages);
                                break;
                            default:
                                $urlmenu2 = '#';
                                break;
                        }
                        echo '<li><a href="' . $urlmenu2 . '"' . $openinnewtab2 . '>' . $row2Mob->namamenu . '</a></li>';
                    }
                    echo '</ul></li>';
                } else {
                    echo '<li><a href="' . $urlmenuMob . '" class="' . $activeMob . '"' . $openinnewtabMob . '>' . $rowMob->namamenu . '</a></li>';
                }
            }
        }
        ?>
    </ul>

    <!-- Footer drawer: Login atau info user -->
    <div class="mob-drawer-footer">
        <?php if (empty($this->session->userdata('idjemaat'))): ?>
            <a href="<?php echo site_url('login') ?>" class="mob-login-btn show-form-login">Login</a>
        <?php else: ?>
            <div class="mob-user-info">Masuk sebagai</div>
            <div class="mob-user-name">
                <?php echo $this->session->userdata('namalengkap'); ?>
                <span class="badge bg-danger rounded-pill text-sm notifikasi-permohonan ms-1"></span>
            </div>
            <div class="mob-user-links">
                <a href="<?php echo site_url('akun/profil') ?>">Profil Saya</a>
                <a href="<?php echo site_url('akun/kelas') ?>">Kelas Saya</a>
                <a href="<?php echo site_url('permohonansaya') ?>">
                    Pemohonan Saya
                    <span class="badge bg-danger rounded-pill text-sm notifikasi-permohonan ms-1"></span>
                </a>
                <a href="<?php echo site_url('login/keluar') ?>" style="color:#c0392b;">Logout</a>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
(function () {
    var hamburger = document.getElementById('mobHamburger');
    var overlay   = document.getElementById('mobOverlay');
    var drawer    = document.getElementById('mobDrawer');
    var closeBtn  = document.getElementById('mobClose');

    function openDrawer() {
        drawer.classList.add('open');
        overlay.style.display = 'block';
        setTimeout(function () { overlay.classList.add('show'); }, 10);
        hamburger.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('show');
        hamburger.classList.remove('open');
        document.body.style.overflow = '';
        setTimeout(function () { overlay.style.display = 'none'; }, 300);
    }

    hamburger.addEventListener('click', function () {
        drawer.classList.contains('open') ? closeDrawer() : openDrawer();
    });
    overlay.addEventListener('click', closeDrawer);
    closeBtn.addEventListener('click', closeDrawer);
}());

function toggleMobSub(el) {
    var li = el.closest('.mob-has-sub');
    var sub = li.querySelector('.mob-submenu');
    var isOpen = li.classList.contains('open');
    // tutup semua submenu lain
    document.querySelectorAll('.mob-has-sub.open').forEach(function (item) {
        item.classList.remove('open');
        item.querySelector('.mob-submenu').style.display = 'none';
    });
    if (!isOpen) {
        li.classList.add('open');
        sub.style.display = 'block';
    }
}
</script>