<?php $this->load->view('template/festavalive/header'); ?>

<body>
  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

      /* =============================================
         ROOT & RESET
      ============================================= */
      :root {
        --bg-base:       #0f0e13;
        --bg-card:       #1a1824;
        --bg-card-hover: #1f1d2c;
        --accent:        #e04607;
        --accent-soft:   rgba(224, 70, 7, 0.15);
        --green:         #22c55e;
        --green-soft:    rgba(34, 197, 94, 0.15);
        --gray:          #64748b;
        --gray-soft:     rgba(100, 116, 139, 0.15);
        --orange-soft:   rgba(224, 70, 7, 0.12);
        --text-primary:  #f1f5f9;
        --text-muted:    #94a3b8;
        --border:        rgba(255,255,255,0.07);
        --font:          'Plus Jakarta Sans', sans-serif;
        --radius:        16px;
      }

      html, body {
        margin: 0; padding: 0;
        background: var(--bg-base);
        font-family: var(--font);
        color: var(--text-primary);
        line-height: 1.65;
      }

      *, *::before, *::after { box-sizing: border-box; }

      /* =============================================
         PAGE WRAPPER
      ============================================= */
      .ks-page {
        min-height: 100vh;
        padding: 140px 0 100px;
      }

      @media (max-width: 767px) {
        .ks-page { padding: 100px 0 80px; }
      }

      /* =============================================
         PAGE HEADER
      ============================================= */
      .ks-header {
        margin-bottom: 48px;
      }

      .ks-header h1 {
        font-size: clamp(1.8rem, 4vw, 2.6rem);
        font-weight: 800;
        color: var(--text-primary);
        margin: 0 0 8px;
        letter-spacing: -0.03em;
      }

      .ks-header p {
        font-size: 1rem;
        color: var(--text-muted);
        margin: 0;
      }

      /* =============================================
         CLASS CARDS
      ============================================= */
      .ks-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .ks-card {
        display: flex;
        background: var(--bg-card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        animation: fadeUp 0.5s ease both;
      }

      .ks-card:hover {
        transform: translateY(-3px);
        background: var(--bg-card-hover);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
      }

      @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
      }

      /* Staggered animation delay */
      .ks-card:nth-child(1) { animation-delay: 0.05s; }
      .ks-card:nth-child(2) { animation-delay: 0.12s; }
      .ks-card:nth-child(3) { animation-delay: 0.19s; }
      .ks-card:nth-child(4) { animation-delay: 0.26s; }
      .ks-card:nth-child(5) { animation-delay: 0.33s; }

      /* Locked card styling */
      .ks-card.is-locked {
        opacity: 0.72;
      }

      /* --- Thumbnail --- */
      .ks-card__thumb {
        width: 280px;
        min-width: 280px;
        overflow: hidden;
        position: relative;
        background: #0f0e13;
      }

      .ks-card__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
        filter: brightness(0.85);
      }

      .ks-card:hover .ks-card__thumb img {
        transform: scale(1.06);
      }

      /* Overlay gradient on thumb */
      .ks-card__thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 60%, var(--bg-card) 100%);
        pointer-events: none;
      }

      /* Locked overlay */
      .ks-card.is-locked .ks-card__thumb::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(15,14,19,0.45);
        z-index: 1;
      }

      /* --- Body --- */
      .ks-card__body {
        flex: 1;
        padding: 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      /* --- Top row: badge + date --- */
      .ks-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
      }

      .ks-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 6px;
      }

      .ks-badge.lulus {
        background: var(--green-soft);
        color: var(--green);
        border: 1px solid rgba(34,197,94,0.25);
      }

      .ks-badge.belum-lulus {
        background: var(--accent-soft);
        color: var(--accent);
        border: 1px solid rgba(224,70,7,0.3);
      }

      .ks-badge.terkunci {
        background: var(--gray-soft);
        color: var(--gray);
        border: 1px solid rgba(100,116,139,0.2);
      }

      .ks-badge.tersedia {
        background: var(--orange-soft);
        color: #fb923c;
        border: 1px solid rgba(251,146,60,0.25);
      }

      .ks-badge svg {
        width: 12px; height: 12px;
        flex-shrink: 0;
      }

      .ks-card__date {
        font-size: 0.8rem;
        color: var(--text-muted);
        white-space: nowrap;
      }

      /* --- Title --- */
      .ks-card__title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.02em;
        line-height: 1.3;
      }

      .ks-card.is-locked .ks-card__title {
        color: #64748b;
      }

      /* --- Description --- */
      .ks-card__desc {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }

      /* --- Action button --- */
      .ks-card__footer {
        margin-top: auto;
        padding-top: 8px;
      }

      .ks-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 50px;
        font-family: var(--font);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
      }

      .ks-btn.primary {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 4px 20px rgba(224,70,7,0.35);
      }

      .ks-btn.primary:hover {
        background: #c73d06;
        box-shadow: 0 6px 28px rgba(224,70,7,0.5);
        transform: translateY(-1px);
        color: #fff;
        text-decoration: none;
      }

      .ks-btn.disabled {
        background: rgba(100,116,139,0.15);
        color: #475569;
        border: 1px solid rgba(100,116,139,0.2);
        cursor: not-allowed;
        pointer-events: none;
      }

      .ks-btn svg {
        width: 15px; height: 15px;
      }

      /* =============================================
         EMPTY STATE
      ============================================= */
      .ks-empty {
        text-align: center;
        padding: 64px 24px;
        background: var(--bg-card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
      }

      .ks-empty svg {
        width: 48px; height: 48px;
        color: var(--gray);
        margin-bottom: 16px;
        opacity: 0.6;
      }

      .ks-empty p {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin: 0;
      }

      /* =============================================
         HELP BANNER
      ============================================= */
      .ks-help {
        margin-top: 40px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 28px 36px;
        display: flex;
        align-items: center;
        gap: 24px;
        animation: fadeUp 0.5s ease 0.5s both;
      }

      .ks-help__icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }

      .ks-help__icon svg {
        width: 28px; height: 28px;
        color: var(--accent);
      }

      .ks-help__text {
        flex: 1;
      }

      .ks-help__text h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px;
      }

      .ks-help__text p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
      }

      /* =============================================
         RESPONSIVE
      ============================================= */
      @media (max-width: 768px) {
        .ks-card {
          flex-direction: column;
        }

        .ks-card__thumb {
          width: 100%;
          min-width: unset;
          height: 200px;
        }

        .ks-card__thumb::after {
          background: linear-gradient(0deg, var(--bg-card) 0%, transparent 60%);
        }

        .ks-card__body {
          padding: 20px 20px 24px;
        }

        .ks-help {
          flex-direction: column;
          text-align: center;
          padding: 28px 24px;
          gap: 16px;
        }
      }
    </style>

    <!-- ============================================================
         PAGE CONTENT
    ============================================================= -->
    <section class="ks-page">
      <div class="container">

        <!-- Header -->
        <div class="ks-header">
          <h1>Riwayat Kelas Saya</h1>
          <p>Kelola progres belajar dan sertifikat Anda di satu tempat.</p>
        </div>

        <!-- Card List -->
        <div class="ks-list">
          <?php
          if ($rskelas->num_rows() > 0):
            foreach ($rskelas->result() as $row):
              $kelas_slug = $this->db->query("SELECT * FROM kelas WHERE idkelas='" . $row->idkelas . "'")->row()->kelas_slug;
              $tglsertifikat = !empty($row->tglsertifikat) ? tglindonesia($row->tglsertifikat) : '—';

              /* ---------- Badge & Button ---------- */
              if ($row->statuslulus == '1') {
                $badgeClass = 'lulus';
                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
                $badgeLabel = 'Lulus';
                $dateLabel = 'Selesai pada ' . $tglsertifikat;
                $lockedClass = '';
                $btn = '<a href="' . site_url('akun/sertifikat/' . $row->idregistrasikelas) . '" 
                          class="ks-btn primary" target="_blank">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                          Lihat Sertifikat
                        </a>';
              } else {
                $badgeClass = 'belum-lulus';
                $badgeIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                $badgeLabel = 'Belum Lulus';
                $dateLabel = 'Tgl Sertifikat: ' . $tglsertifikat;
                $lockedClass = '';
                $btn = '<a href="' . site_url('nextstep/kelas/' . $kelas_slug . '/') . '" 
                          class="ks-btn primary">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                          Registrasi Kelas
                        </a>';
              }

              echo "
              <div class='ks-card {$lockedClass}'>
                <div class='ks-card__thumb'>
                  <img src='https://myesc.id/myesc.id/assets/gambar/bgkelas2.jpg' alt='{$row->namakelas}' loading='lazy'>
                </div>
                <div class='ks-card__body'>
                  <div class='ks-card__top'>
                    <span class='ks-badge {$badgeClass}'>
                      {$badgeIcon}
                      {$badgeLabel}
                    </span>
                    <span class='ks-card__date'>{$dateLabel}</span>
                  </div>
                  <h2 class='ks-card__title'>{$row->namakelas}</h2>
                  <p class='ks-card__desc'>Kelas {$row->namakelas} — tingkatkan pengetahuan dan iman Anda bersama komunitas kami.</p>
                  <div class='ks-card__footer'>
                    {$btn}
                  </div>
                </div>
              </div>
              ";
            endforeach;
          else:
            echo "
            <div class='ks-empty'>
              <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                <path d='M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z'/><path d='M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z'/>
              </svg>
              <p>Belum ada kelas yang diikuti.</p>
            </div>
            ";
          endif;
          ?>
        </div><!-- /.ks-list -->

        <!-- Help Banner -->
        <div class="ks-help">
          <div class="ks-help__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
          </div>
          <div class="ks-help__text">
            <h3>Butuh bantuan dengan sertifikat Anda?</h3>
            <p>Jika Anda telah menyelesaikan kelas namun sertifikat belum muncul atau terdapat kesalahan data, tim Equip kami siap membantu Anda.</p>
          </div>
          <a href="https://wa.me/6285183023883" target="_blank" class="ks-btn primary" style="white-space:nowrap;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.124.558 4.121 1.535 5.856L.057 23.215a.75.75 0 0 0 .922.922l5.356-1.479A11.952 11.952 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.952 9.952 0 0 1-5.073-1.384l-.364-.214-3.766 1.039 1.04-3.766-.214-.364A9.953 9.953 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
            </svg>
            Hubungi Admin
          </a>
        </div>

      </div><!-- /.container -->
    </section>

    <script>
      $(document).on('change', '#foto', function(e) {
        $('#formUpload').submit();
      });
    </script>

    <?php $this->load->view('template/festavalive/footer'); ?>
  </main>
</body>