<?php

/*
 * navbar.php — ESC Mobile Navbar
 * Kompatibel: Android Chrome, iOS Safari (iPhone 5s+)
 * Font: Figtree (Google Fonts)
 * Topbar: hitam | Drawer: putih
 */
?>

<!-- Google Fonts: Figtree -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">

<!-- ========== NAVBAR DESKTOP ========== -->
<nav class="navbar navbar-expand-lg d-none d-md-block">
    <div class="container">
        <img src="<?php echo base_url('myesc.id/assets/FestavaLive/video/esc10.png'); ?>"
            alt="Logo"
            style="width: 40px; height: 40px; margin-right: 20px;">
        <a class="navbar-brand" href="<?php echo site_url() ?>">
            El Shaddai Church
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">

                <?php
                $rsMenu1 = $this->db->query('SELECT * FROM v_frontmenus WHERE levels=1 ORDER BY nomorurut');
                if ($rsMenu1->num_rows() > 0) {
                    foreach ($rsMenu1->result() as $row1) {
                        $urlmenu = '';
                        $openinnewtab = ($row1->openinnewtab == '1') ? ' target="_blank" ' : '';
                        $active = ($menu == $row1->idmenu) ? 'active' : '';

                        switch ($row1->jenismenu) {
                            case 'Url Link':
                                if ($row1->linkmenu == '/') {
                                    if (empty($menu))
                                        $active = 'active';
                                    $urlmenu = site_url('home');
                                } else {
                                    $urlmenu = (substr($row1->linkmenu, 0, 1) == '/')
                                        ? site_url($row1->linkmenu . '/' . $this->encrypt->encode($row1->idmenu))
                                        : $row1->linkmenu;
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
                            echo '<li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle ' . $active . '" id="navbarDropdown" data-bs-toggle="dropdown">' . $row1->namamenu . '</a>
                                <div class="dropdown-menu m-0">';
                            foreach ($rsMenu2->result() as $row2) {
                                $openinnewtab = ($row2->openinnewtab == '1') ? ' target="_blank" ' : '';
                                $urlmenu = '';
                                switch ($row2->jenismenu) {
                                    case 'Url Link':
                                        $urlmenu = (substr($row2->linkmenu, 0, 1) == '/')
                                            ? site_url($row2->linkmenu . '/' . $this->encrypt->encode($row2->idmenu))
                                            : $row2->linkmenu;
                                        break;
                                    case 'Kategori Link':
                                        $urlmenu = site_url('kategori/index/' . $this->encrypt->encode($row2->idmenu) . '/' . $row2->slug_pageskategori);
                                        break;
                                    case 'Page Link':
                                        $urlmenu = site_url('pages/read/' . $this->encrypt->encode($row2->idmenu) . '/' . $row2->slug_pages);
                                        break;
                                    default:
                                        $urlmenu = '#';
                                }
                                echo '<a href="' . $urlmenu . '" class="dropdown-item"' . $openinnewtab . '>' . $row2->namamenu . '</a>';
                            }
                            echo '</div></li>';
                        } else {
                            echo '<li class="nav-item">
                                <a class="nav-link ' . $active . '" href="' . $urlmenu . '"' . $openinnewtab . '>' . $row1->namamenu . '</a>
                            </li>';
                        }
                    }
                }
                ?>

                <?php
                if (empty($this->session->userdata('idjemaat'))) {
                    echo '<a href="' . site_url('login') . '" class="custom-btn d-lg-block d-none show-form-login">Login</a>';
                } else {
                    $active = ($menu == 'Akun') ? 'active' : '';
                    echo '
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle ' . $active . '" data-bs-toggle="dropdown">'
                        . $this->session->userdata('namalengkap')
                        . '<span class="badge bg-danger start-100 translate-middle rounded-pill text-sm notifikasi-permohonan" style="margin-left:10px;"></span>
                            </a>
                            <div class="dropdown-menu m-0" style="min-width:200px;">
                                <a href="' . site_url('akun/profil') . '" class="dropdown-item">Profil Saya</a>
                                <a href="' . site_url('akun/kelas') . '" class="dropdown-item">Kelas Saya</a>
                                <a href="' . site_url('permohonansaya') . '" class="dropdown-item">Permohonan Saya
                                    <span class="badge bg-danger start-100 translate-middle rounded-pill text-sm notifikasi-permohonan" style="margin-left:10px;"></span>
                                </a>
                                <a href="' . site_url('login/keluar') . '" class="dropdown-item">Logout</a>
                            </div>
                        </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>


<!-- ========== NAVBAR MOBILE — Slide Drawer ========== -->
<style>
/* ----- Reset & base ----- */
*,
*::before,
*::after { box-sizing: border-box; }

/* ----- Topbar (hitam) ----- */
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
    /* Safe area iPhone notch/Dynamic Island */
    padding-left: max(1.25rem, env(safe-area-inset-left));
    padding-right: max(1.25rem, env(safe-area-inset-right));
}
.mob-brand {
    font-family: 'Figtree', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    letter-spacing: -0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
    -webkit-tap-highlight-color: transparent;
}
.mob-brand img {
    width: 28px;
    height: 28px;
    object-fit: contain;
}
.mob-hamburger {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    z-index: 1100;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
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

/* ----- Overlay ----- */
.mob-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.65);
    z-index: 1060;
    opacity: 0;
    transition: opacity 0.3s ease;
    -webkit-tap-highlight-color: transparent;
}
.mob-overlay.show { opacity: 1; }

/* ----- Drawer (putih) ----- */
.mob-drawer {
    position: fixed;
    top: 0; right: 0;
    /* Lebar: 82% layar, max 300px — pas di semua HP */
    width: min(300px, 82vw);
    height: 100%;
    /* iOS: full height termasuk safe area */
    height: 100dvh;
    background: #fff;
    z-index: 1070;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    border-left: 1px solid #e8e8e8;
    overflow: hidden;
    /* Pastikan font tidak dioverride sistem */
    font-family: 'Figtree', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing: antialiased;
}
.mob-drawer.open { transform: translateX(0); }

/* ----- Drawer header ----- */
.mob-drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem;
    height: 56px;
    border-bottom: 1px solid #f0f0f0;
    flex-shrink: 0;
    background: #fff;
}
.mob-drawer-title {
    font-family: 'Figtree', sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: #aaa;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.mob-close {
    background: none;
    border: none;
    color: #aaa;
    font-size: 20px;
    cursor: pointer;
    padding: 6px;
    line-height: 1;
    transition: color 0.15s;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
}
.mob-close:hover,
.mob-close:active { color: #111; background: #f5f5f5; }

/* ----- Nav list (scrollable) ----- */
.mob-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    list-style: none;
    margin: 0;
    padding: 4px 0;
    /* Scrollbar tipis di Android */
    scrollbar-width: thin;
    scrollbar-color: #e0e0e0 transparent;
}
.mob-nav::-webkit-scrollbar { width: 3px; }
.mob-nav::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 3px; }

/* Item menu utama */
.mob-nav > li {
    border-bottom: 1px solid #f2f2f2;
}
.mob-nav > li > a {
    font-family: 'Figtree', sans-serif;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 1.5rem;
    font-size: 15px;
    font-weight: 500;
    color: #1a1a1a;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    /* Minimal tap target 48px — aksesibilitas mobile */
    min-height: 52px;
}
.mob-nav > li > a:hover,
.mob-nav > li > a:active { background: #fdf4f1; color: #ff5008; }
.mob-nav > li > a.active {
    color: #ff5008;
    background: #fdf4f1;
    border-left: 3px solid #ff5008;
    padding-left: calc(1.5rem - 3px);
}

/* ----- Submenu accordion ----- */
.mob-submenu {
    list-style: none;
    margin: 0;
    padding: 0;
    background: #fafafa;
    display: none;
    border-top: 1px solid #f2f2f2;
}
.mob-submenu.open { display: block; }
.mob-submenu > li { border-bottom: 1px solid #f2f2f2; }
.mob-submenu > li:last-child { border-bottom: none; }
.mob-submenu a {
    font-family: 'Figtree', sans-serif;
    display: block;
    padding: 13px 1.5rem 13px 2rem;
    font-size: 14px;
    font-weight: 400;
    color: #555;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-height: 46px;
    display: flex;
    align-items: center;
}
.mob-submenu a:hover,
.mob-submenu a:active { color: #ff5008; background: #fdf4f1; }

/* Chevron */
.mob-chevron {
    font-size: 11px;
    color: #ccc;
    transition: transform 0.25s ease;
    display: inline-block;
    flex-shrink: 0;
    margin-left: 8px;
}
.mob-has-sub.open > a .mob-chevron { transform: rotate(180deg); }

/* ----- Footer drawer ----- */
.mob-drawer-footer {
    flex-shrink: 0;
    border-top: 1px solid #efefef;
    background: #fafafa;
    /* Safe area iPhone home indicator */
    padding-bottom: max(1.25rem, env(safe-area-inset-bottom));
}

/* Kondisi: belum login */
.mob-login-wrap {
    padding: 1.25rem 1.5rem;
}
.mob-login-btn {
    display: block;
    width: 100%;
    padding: 13px;
    background: #111;
    color: #fff;
    font-family: 'Figtree', sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    letter-spacing: 0.04em;
    border-radius: 6px;
    transition: background 0.15s;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}
.mob-login-btn:hover,
.mob-login-btn:active { background: #333; color: #fff; }

/* Kondisi: sudah login — user card */
.mob-user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 1.5rem;
    border-bottom: 1px solid #efefef;
}
.mob-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ff5008;
    color: #fff;
    font-family: 'Figtree', sans-serif;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.mob-user-meta { flex: 1; min-width: 0; }
.mob-user-info {
    font-family: 'Figtree', sans-serif;
    font-size: 10px;
    font-weight: 500;
    color: #bbb;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 2px;
}
.mob-user-name {
    font-family: 'Figtree', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* User links */
.mob-user-links {
    display: flex;
    flex-direction: column;
    padding: 4px 0;
}
.mob-user-links a {
    font-family: 'Figtree', sans-serif;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 1.5rem;
    font-size: 14px;
    font-weight: 400;
    color: #444;
    text-decoration: none;
    border-bottom: 1px solid #f5f5f5;
    transition: background 0.15s, color 0.15s;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-height: 48px;
}
.mob-user-links a:last-child { border-bottom: none; }
.mob-user-links a:hover,
.mob-user-links a:active { background: #f7f7f7; color: #111; }
.mob-user-links a svg {
    flex-shrink: 0;
    opacity: 0.5;
}
.mob-user-links a.mob-logout { color: #e74c3c; }
.mob-user-links a.mob-logout svg { opacity: 0.7; }
.mob-user-links a.mob-logout:hover,
.mob-user-links a.mob-logout:active { background: #fff5f5; color: #c0392b; }

/* ----- Spacer (agar konten tidak tertutup topbar) ----- */
.mob-spacer {
    display: none;
    height: 56px;
    /* iOS safe area */
    height: calc(56px + env(safe-area-inset-top, 0px));
}

/* ----- Responsive breakpoint ----- */
@media (max-width: 767px) {
    .mob-topbar { display: flex; }
    .mob-spacer { display: block; }
}

/* ----- Landscape HP kecil (mis. iPhone SE landscape) ----- */
@media (max-width: 767px) and (orientation: landscape) {
    .mob-topbar { height: 48px; }
    .mob-spacer { height: 48px; }
    .mob-nav > li > a { padding: 12px 1.5rem; min-height: 44px; }
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
    <button class="mob-hamburger" id="mobHamburger" aria-label="Buka menu" aria-expanded="false" aria-controls="mobDrawer">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>

<!-- Overlay -->
<div class="mob-overlay" id="mobOverlay" role="presentation"></div>

<!-- Drawer -->
<div class="mob-drawer" id="mobDrawer" role="dialog" aria-label="Navigasi">

    <!-- Header -->
    <div class="mob-drawer-header">
        <span class="mob-drawer-title">Menu</span>
        <button class="mob-close" id="mobClose" aria-label="Tutup menu">&#x2715;</button>
    </div>

    <!-- Nav List -->
    <ul class="mob-nav" id="mobNavList">
        <?php
        $rsMenuMob = $this->db->query('SELECT * FROM v_frontmenus WHERE levels=1 ORDER BY nomorurut');
        if ($rsMenuMob->num_rows() > 0) {
            foreach ($rsMenuMob->result() as $rowMob) {
                $urlmenuMob = '';
                $openinnewtabMob = ($rowMob->openinnewtab == '1') ? ' target="_blank" rel="noopener"' : '';
                $activeMob = ($menu == $rowMob->idmenu) ? 'active' : '';

                switch ($rowMob->jenismenu) {
                    case 'Url Link':
                        if ($rowMob->linkmenu == '/') {
                            if (empty($menu))
                                $activeMob = 'active';
                            $urlmenuMob = site_url('home');
                        } else {
                            $urlmenuMob = (substr($rowMob->linkmenu, 0, 1) == '/')
                                ? site_url($rowMob->linkmenu . '/' . $this->encrypt->encode($rowMob->idmenu))
                                : $rowMob->linkmenu;
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
                }

                $rsMenu2Mob = $this->db->query("SELECT * FROM v_frontmenus WHERE parentidmenu='" . $rowMob->idmenu . "' ORDER BY nomorurut");

                if ($rsMenu2Mob->num_rows() > 0) {
                    // Cek active dari submenu
                    $activeMob = '';
                    foreach ($rsMenu2Mob->result() as $rowCek) {
                        if ($menu == $rowCek->idmenu) {
                            $activeMob = 'active';
                            break;
                        }
                    }
                    $subId = 'sub_' . $rowMob->idmenu;
                    echo '<li class="mob-has-sub">
                        <a href="#" class="' . $activeMob . '"
                            onclick="toggleMobSub(this); return false;"
                            aria-expanded="false"
                            aria-controls="' . $subId . '">
                            <span>' . $rowMob->namamenu . '</span>
                            <span class="mob-chevron" aria-hidden="true">&#9660;</span>
                        </a>
                        <ul class="mob-submenu" id="' . $subId . '">';
                    foreach ($rsMenu2Mob->result() as $row2Mob) {
                        $openinnewtab2 = ($row2Mob->openinnewtab == '1') ? ' target="_blank" rel="noopener"' : '';
                        $urlmenu2 = '';
                        switch ($row2Mob->jenismenu) {
                            case 'Url Link':
                                $urlmenu2 = (substr($row2Mob->linkmenu, 0, 1) == '/')
                                    ? site_url($row2Mob->linkmenu . '/' . $this->encrypt->encode($row2Mob->idmenu))
                                    : $row2Mob->linkmenu;
                                break;
                            case 'Kategori Link':
                                $urlmenu2 = site_url('kategori/index/' . $this->encrypt->encode($row2Mob->idmenu) . '/' . $row2Mob->slug_pageskategori);
                                break;
                            case 'Page Link':
                                $urlmenu2 = site_url('pages/read/' . $this->encrypt->encode($row2Mob->idmenu) . '/' . $row2Mob->slug_pages);
                                break;
                            default:
                                $urlmenu2 = '#';
                        }
                        $activeSubMob = ($menu == $row2Mob->idmenu) ? 'style="color:#ff5008;font-weight:500;"' : '';
                        echo '<li><a href="' . $urlmenu2 . '"' . $openinnewtab2 . ' ' . $activeSubMob . '>' . $row2Mob->namamenu . '</a></li>';
                    }
                    echo '</ul></li>';
                } else {
                    echo '<li>
                        <a href="' . $urlmenuMob . '" class="' . $activeMob . '"' . $openinnewtabMob . '>
                            ' . $rowMob->namamenu . '
                        </a>
                    </li>';
                }
            }
        }
        ?>
    </ul>

    <!-- Footer Drawer -->
    <div class="mob-drawer-footer">
        <?php if (empty($this->session->userdata('idjemaat'))): ?>

            <!-- Belum login -->
            <div class="mob-login-wrap">
                <a href="<?php echo site_url('login') ?>" class="mob-login-btn show-form-login">
                    Login
                </a>
            </div>

        <?php
else:
    // Ambil inisial 1-2 huruf dari nama
    $namaLengkap = $this->session->userdata('namalengkap');
    $words = preg_split('/\s+/', trim($namaLengkap));
    $inisial = strtoupper(mb_substr($words[0], 0, 1));
    if (count($words) > 1)
        $inisial .= strtoupper(mb_substr($words[1], 0, 1));
    ?>

            <!-- User card -->
            <div class="mob-user-card">
                <div class="mob-user-avatar"><?php echo $inisial; ?></div>
                <div class="mob-user-meta">
                    <div class="mob-user-info">Masuk sebagai</div>
                    <div class="mob-user-name">
                        <?php echo htmlspecialchars($namaLengkap); ?>
                        <span class="badge bg-danger rounded-pill text-sm notifikasi-permohonan"
                            style="font-size:10px;padding:2px 6px;"></span>
                    </div>
                </div>
            </div>

            <!-- User links -->
            <div class="mob-user-links">
                <a href="<?php echo site_url('akun/profil') ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-3.866 3.582-7 8-7s8 3.134 8 7"/>
                    </svg>
                    Profil Saya
                </a>
                <a href="<?php echo site_url('akun/kelas') ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M8 10h8M8 14h5"/>
                    </svg>
                    Kelas Saya
                </a>
                <a href="<?php echo site_url('permohonansaya') ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                        <path d="M9 12h6M9 16h4"/>
                    </svg>
                    Permohonan Saya
                    <span class="badge bg-danger rounded-pill text-sm notifikasi-permohonan"
                        style="font-size:10px;padding:2px 6px;margin-left:2px;"></span>
                </a>
                <a href="<?php echo site_url('login/keluar') ?>" class="mob-logout">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </a>
            </div>

        <?php endif; ?>
    </div>

</div><!-- end .mob-drawer -->

<script>
(function () {
    'use strict';

    var hamburger = document.getElementById('mobHamburger');
    var overlay   = document.getElementById('mobOverlay');
    var drawer    = document.getElementById('mobDrawer');
    var closeBtn  = document.getElementById('mobClose');
    var isOpen    = false;

    function openDrawer() {
        isOpen = true;
        drawer.classList.add('open');
        overlay.style.display = 'block';
        // Delay kecil agar transition opacity berjalan
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                overlay.classList.add('show');
            });
        });
        hamburger.classList.add('open');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        // iOS: cegah scroll di belakang drawer
        document.body.style.position = '';
    }

    function closeDrawer() {
        isOpen = false;
        drawer.classList.remove('open');
        overlay.classList.remove('show');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        setTimeout(function () {
            if (!isOpen) overlay.style.display = 'none';
        }, 320);
    }

    hamburger.addEventListener('click', function () {
        isOpen ? closeDrawer() : openDrawer();
    });
    overlay.addEventListener('click', closeDrawer);
    closeBtn.addEventListener('click', closeDrawer);

    // Tutup drawer saat tap link login/registrasi/lupa password
    document.addEventListener('click', function (e) {
        if (e.target.closest('.show-form-login, .show-form-registrasi, .show-form-lupapassword')) {
            closeDrawer();
        }
    });

    // Tutup drawer dengan tombol Escape (keyboard)
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isOpen) closeDrawer();
    });

    // iOS: cegah body scroll saat drawer dibuka (workaround iOS rubber-band)
    drawer.addEventListener('touchmove', function (e) {
        e.stopPropagation();
    }, { passive: true });

}());

function toggleMobSub(el) {
    var li  = el.closest('.mob-has-sub');
    var sub = li.querySelector('.mob-submenu');
    var wasOpen = li.classList.contains('open');

    // Tutup semua submenu lain
    document.querySelectorAll('.mob-has-sub.open').forEach(function (item) {
        item.classList.remove('open');
        item.querySelector('.mob-submenu').style.display = 'none';
        item.querySelector('a').setAttribute('aria-expanded', 'false');
    });

    // Toggle yang dipilih
    if (!wasOpen) {
        li.classList.add('open');
        sub.style.display = 'block';
        el.setAttribute('aria-expanded', 'true');
    }
}
</script>