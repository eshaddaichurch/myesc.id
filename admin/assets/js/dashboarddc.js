(function ($) {
    'use strict';

    var cfg = window.DDC || {};
    var BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    var WARNA = '#be185d';
    var MAKS_HARI = 400;
    var REDUCE_MOTION = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var charts = {};
    var dataHarian = null;
    var tipeHarian = 'bar';

    // ===================== UTILITAS =====================
    function fmt(n) {
        return (Math.round(parseFloat(n)) || 0).toLocaleString('id-ID');
    }

    function pctTxt(v) {
        v = parseFloat(v) || 0;
        return (v > 0 ? '+' : '') + v.toLocaleString('id-ID', { maximumFractionDigits: 1 }) + '%';
    }

    function esc(s) {
        return $('<div>').text(s == null ? '' : s).html();
    }

    function rgba(hex, a) {
        var n = parseInt(hex.slice(1), 16);
        return 'rgba(' + (n >> 16) + ',' + ((n >> 8) & 255) + ',' + (n & 255) + ',' + a + ')';
    }

    // Angka bergerak dari nilai sebelumnya ke nilai baru
    function animateNumber($el, to) {
        if (!$el.length) return;
        to = Math.round(parseFloat(to)) || 0;
        var from = parseInt($el.attr('data-val'), 10) || 0;
        $el.attr('data-val', to);

        var prev = $el.data('raf');
        if (prev) cancelAnimationFrame(prev);

        if (REDUCE_MOTION || from === to) {
            $el.text(fmt(to));
            return;
        }

        var start = null, dur = 600;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            $el.text(fmt(Math.round(from + (to - from) * eased)));
            if (p < 1) {
                $el.data('raf', requestAnimationFrame(step));
            }
        }
        $el.data('raf', requestAnimationFrame(step));
    }

    function notify(title, text, icon) {
        if (typeof Swal !== 'undefined' && Swal.fire) {
            Swal.fire(title, text || '', icon || 'info');
        } else {
            alert(title + (text ? '\n\n' + text : ''));
        }
    }

    function formatTanggal(d) {
        return d.getFullYear() + '-' +
            String(d.getMonth() + 1).padStart(2, '0') + '-' +
            String(d.getDate()).padStart(2, '0');
    }

    function tampilPct(sel, v, label) {
        v = parseFloat(v) || 0;
        $(sel)
            .text(pctTxt(v) + ' ' + label)
            .removeClass('text-success text-danger text-muted')
            .addClass(v < 0 ? 'text-danger' : (v > 0 ? 'text-success' : 'text-muted'));
    }

    // ===================== FILTER =====================
    function getFilter() {
        return {
            tglawal:  $('#fAwal').val(),
            tglakhir: $('#fAkhir').val()
        };
    }

    function validFilter(f) {
        if (!f.tglawal || !f.tglakhir) {
            notify('Perhatian', 'Tanggal awal dan akhir harus diisi.', 'warning');
            return false;
        }
        if (f.tglawal > f.tglakhir) {
            notify('Perhatian', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.', 'warning');
            return false;
        }
        var hari = (new Date(f.tglakhir) - new Date(f.tglawal)) / 86400000;
        if (hari > MAKS_HARI) {
            notify('Perhatian', 'Rentang periode maksimal ' + MAKS_HARI + ' hari.', 'warning');
            return false;
        }
        return true;
    }

    function terapkan() {
        var f = getFilter();
        if (!validFilter(f)) return;
        history.replaceState(null, '', cfg.self + '?' + $.param(f));
        muatSemua(f);
    }

    function setPreset(kind) {
        var now = new Date();
        var y = now.getFullYear();
        var m = now.getMonth();
        var awal, akhir;

        switch (kind) {
            case 'ini':   awal = new Date(y, m, 1);     akhir = new Date(y, m + 1, 0); break;
            case 'lalu':  awal = new Date(y, m - 1, 1); akhir = new Date(y, m, 0);     break;
            case '3bln':  awal = new Date(y, m - 2, 1); akhir = new Date(y, m + 1, 0); break;
            case 'tahun': awal = new Date(y, 0, 1);     akhir = new Date(y, 11, 31);   break;
            default: return;
        }
        $('#fAwal').val(formatTanggal(awal));
        $('#fAkhir').val(formatTanggal(akhir));
        terapkan();
    }

    function muatSemua(f) {
        $('#hPeriode').text(f.tglawal + ' s/d ' + f.tglakhir);
        muatInfo();
        muatBanding(f);
        muatGrafik(f);
        muatBulan(f);
    }

    function ajax(nama, f) {
        return $.getJSON(cfg.base + nama, f || {});
    }

    // ===================== KARTU INFO =====================
    function muatInfo() {
        ajax('getinfobox')
            .done(function (r) {
                animateNumber($('#hDc'), r.jumlahDc);
                animateNumber($('#hMember'), r.jumlahMember);

                animateNumber($('#infoIni'), r.memberBaruIni);
                $('#infoIniNama').text(r.namabulanini);
                tampilPct('#pctIni', r.pctIni, 'dibanding bulan lalu');

                animateNumber($('#infoLalu'), r.memberBaruLalu);
                $('#infoLaluNama').text(r.namabulanlalu);
                tampilPct('#pctLalu', r.pctLalu, 'dibanding dua bulan lalu');
            })
            .fail(function (xhr) {
                $('#infoIni, #infoLalu').text('–');
                $('#pctIni, #pctLalu').text('Gagal dimuat (HTTP ' + xhr.status + ')');
            });
    }

    // ===================== PERBANDINGAN =====================
    function muatBanding(f) {
        ajax('getbanding', f)
            .done(function (r) {
                animateNumber($('#hBaru'), r.now);
                animateNumber($('#bNow'), r.now);

                var selisih = parseInt(r.selisih, 10) || 0;
                var teks = 'Periode sebelumnya (' + r.prevawal + ' s/d ' + r.prevakhir + '): ' +
                    fmt(r.prev) + ' &middot; selisih ' + (selisih > 0 ? '+' : '') + fmt(selisih) +
                    ' (' + pctTxt(r.persen) + ')';

                $('#bInfo').html(teks)
                    .removeClass('text-success text-danger text-muted')
                    .addClass(selisih < 0 ? 'text-danger' : (selisih > 0 ? 'text-success' : 'text-muted'));
            })
            .fail(function (xhr) {
                $('#hBaru, #bNow').text('–');
                $('#bInfo').text('Gagal dimuat (HTTP ' + xhr.status + ')');
            });
    }

    // ===================== GRAFIK HARIAN =====================
    function gambar(key, id, type, data, extra) {
        if (charts[key]) charts[key].destroy();

        var base = {
            maintainAspectRatio: false,
            responsive: true,
            animation: { duration: 400 },
            legend: { display: false },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function (item, d) {
                        return ' ' + d.datasets[item.datasetIndex].label + ': ' + fmt(item.yLabel);
                    }
                }
            },
            hover: { mode: 'index', intersect: false },
            scales: {
                yAxes: [{
                    ticks: { beginAtZero: true, precision: 0, callback: function (v) { return fmt(v); } },
                    gridLines: { color: 'rgba(0,0,0,.06)' }
                }],
                xAxes: [{ gridLines: { display: false } }]
            }
        };

        charts[key] = new Chart(document.getElementById(id).getContext('2d'), {
            type: type,
            data: data,
            options: $.extend(true, base, extra || {})
        });
    }

    function gambarHarian() {
        if (!dataHarian) return;
        var isLine = tipeHarian === 'line';

        gambar('harian', 'cvHarian', isLine ? 'line' : 'bar', {
            labels: dataHarian.labels,
            datasets: [{
                label: 'Member Baru',
                data: dataHarian.jumlah,
                borderColor: WARNA,
                backgroundColor: isLine ? rgba(WARNA, 0.08) : rgba(WARNA, 0.85),
                borderWidth: isLine ? 2.5 : 1,
                pointBackgroundColor: WARNA,
                pointRadius: isLine ? 3 : 0,
                pointHoverRadius: 6,
                lineTension: 0.35,
                fill: false
            }]
        });
    }

    function muatGrafik(f) {
        ajax('getgrafik', f)
            .done(function (r) {
                if (r.error) notify('Perhatian', r.error, 'warning');

                animateNumber($('#hRata'), r.ringkas.rata);

                var t = r.ringkas.tertinggi;
                $('#infoTertinggi').html(t.jumlah > 0
                    ? '<i class="fas fa-star text-warning"></i> Hari tertinggi: <b>' + esc(t.tgl) + '</b> dengan <b>' + fmt(t.jumlah) + '</b> member baru'
                    : '');

                dataHarian = r;
                gambarHarian();
                $('#catatanKosong').toggleClass('d-none', r.labels.length > 0);
            })
            .fail(function (xhr) {
                notify('Gagal', 'Data grafik gagal dimuat (HTTP ' + xhr.status + ').', 'error');
            });
    }

    // ===================== PER BULAN =====================
    function muatBulan(f) {
        ajax('getbulan', f)
            .done(function (r) {
                $('#judulBulan').text(r.tahun);
                gambar('bulan', 'cvBulan', 'bar', {
                    labels: BULAN,
                    datasets: [{
                        label: 'Member Baru',
                        data: r.data,
                        backgroundColor: rgba(WARNA, 0.85),
                        borderColor: WARNA,
                        borderWidth: 1
                    }]
                });
            })
            .fail(function (xhr) {
                notify('Gagal', 'Data per bulan gagal dimuat (HTTP ' + xhr.status + ').', 'error');
            });
    }

    // ===================== TABEL DC =====================
    function muatDc() {
        ajax('getdc')
            .done(function (r) {
                var rows = r.data || [];
                var total = 0;
                var head = '<thead class="thead-light"><tr><th>No</th><th>Nama DC</th><th class="text-right">Member Aktif</th></tr></thead>';
                var body = '<tbody>';

                if (!rows.length) {
                    body += '<tr><td colspan="3" class="text-center text-muted py-3">Belum ada DC aktif</td></tr>';
                }
                rows.forEach(function (x, i) {
                    var jml = parseInt(x.jumlah || x.jumlahmember || 0, 10) || 0;
                    total += jml;
                    body += '<tr><td>' + (i + 1) + '</td><td>' + esc(x.namadc) + '</td>' +
                        '<td class="text-right">' + fmt(jml) + '</td></tr>';
                });
                body += '</tbody>';

                var foot = '<tfoot><tr><td colspan="2">Total</td><td class="text-right">' + fmt(total) + '</td></tr></tfoot>';
                $('#tabelDc').html(head + body + foot);
            })
            .fail(function (xhr) {
                $('#tabelDc').html('<tbody><tr><td class="text-danger">Gagal dimuat (HTTP ' + xhr.status + ')</td></tr></tbody>');
            });
    }

    // ===================== CETAK =====================
    function bukaCetak(url, params) {
        window.open(url + '?' + $.param(params), '_blank');
    }

    function cetakPdf() {
        var f = getFilter();
        if (!validFilter(f)) return;
        bukaCetak(cfg.cetak, f);
    }

    function cetakExcel() {
        var f = getFilter();
        if (!validFilter(f)) return;
        bukaCetak(cfg.excel, f);
    }

    // Laporan anggota tidak memakai periode, hanya filter jenis kelamin, umur, dan status
    function cetakAnggota() {
        bukaCetak(cfg.anggota, {
            jeniskelamin: $('#fJk').val(),
            umur:         $('#fUmur').val(),
            status:       $('#fStatus').val()
        });
    }

    // ===================== INIT =====================
    $(function () {
        $('#btnTerapkan').on('click', terapkan);
        $('#btnCetak').on('click', cetakPdf);
        $('#btnExcel').on('click', cetakExcel);
        $('#btnLaporanAnggota').on('click', cetakAnggota);

        $('[data-preset]').on('click', function () {
            setPreset($(this).data('preset'));
        });

        $('input[name="tipeTren"]').on('change', function () {
            tipeHarian = $(this).closest('label').data('type');
            gambarHarian();
        });

        muatSemua(getFilter());
        muatDc();
    });

})(jQuery);