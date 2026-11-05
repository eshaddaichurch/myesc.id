(function ($) {
    'use strict';

    var cfg = window.DKH || {};
    var BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    var PALET = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc', '#fd7e14', '#6f42c1', '#20c997'];
    var MAKS_HARI = 400;

    var charts = {};
    var dataTren = null;
    var tipeTren = 'bar';

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

    function warnaSesi(i) {
        return PALET[i % PALET.length];
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
            idabsenjenis: $('#fJenis').val(),
            tglawal: $('#fAwal').val(),
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
        muatInfo(f);
        muatBanding(f);
        muatKosong(f);
        muatGrafik(f);
        muatLokasi(f);
        muatBulan(f);
    }

    function ajax(nama, f) {
        return $.getJSON(cfg.base + nama, f);
    }

    // ===================== INFO BULAN =====================
    function muatInfo(f) {
        ajax('getinfobox', f)
            .done(function (r) {
                $('#infoIni').text(fmt(r.kehadiranbulanini));
                $('#infoIniNama').text(r.namabulanini);
                tampilPct('#pctIni', r.kenaikanbulanini, 'dibanding bulan sebelumnya');

                $('#infoLalu').text(fmt(r.kehadiranbulanlalu));
                $('#infoLaluNama').text(r.namabulanlalu);
                tampilPct('#pctLalu', r.kenaikanbulanlalu, 'dibanding dua bulan sebelumnya');
            })
            .fail(function (xhr) {
                $('#infoIni, #infoLalu').text('–');
                $('#pctIni, #pctLalu').text('Gagal dimuat (HTTP ' + xhr.status + ')');
            });
    }

    // ===================== PERBANDINGAN PERIODE =====================
    function muatBanding(f) {
        ajax('getbanding', f)
            .done(function (r) {
                $('#bNow').text(fmt(r.now));
                var selisih = parseInt(r.selisih, 10) || 0;
                var teks = 'Periode sebelumnya (' + r.prevawal + ' s/d ' + r.prevakhir + '): ' +
                    fmt(r.prev) + ' &middot; selisih ' + (selisih > 0 ? '+' : '') + fmt(selisih) +
                    ' (' + pctTxt(r.persen) + ')';
                $('#bInfo').html(teks)
                    .removeClass('text-success text-danger text-muted')
                    .addClass(selisih < 0 ? 'text-danger' : (selisih > 0 ? 'text-success' : 'text-muted'));
            })
            .fail(function (xhr) {
                $('#bNow').text('–');
                $('#bInfo').text('Gagal dimuat (HTTP ' + xhr.status + ')');
            });
    }

    // ===================== IBADAH TANPA CATATAN =====================
    function muatKosong(f) {
        ajax('getkosong', f)
            .done(function (r) {
                var d = r.data || [];
                if (!d.length) {
                    $('#listKosong').html('<li class="text-success">Semua hari ibadah dalam periode sudah tercatat.</li>');
                    return;
                }
                $('#listKosong').html(d.map(function (x) {
                    return '<li class="text-danger">' + esc(x.label) + '</li>';
                }).join(''));
            })
            .fail(function (xhr) {
                $('#listKosong').html('<li class="text-danger">Gagal dimuat (HTTP ' + xhr.status + ')</li>');
            });
    }

    // ===================== GRAFIK & RINGKASAN =====================
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

    function isiRingkas(s) {
        $('#hTotal').text(fmt(s.total));
        $('#hRata').text(fmt(s.rata));
        $('#hHari').text(fmt(s.hari));
        $('#hSesi').text(s.sesi_terbesar.nama);
        $('#hSesiSub').text(s.sesi_terbesar.total ? '(' + fmt(s.sesi_terbesar.total) + ' hadir)' : '');
    }

    function isiSesi(sesi, grand) {
        var html = '';
        sesi.forEach(function (s, i) {
            var pct = grand ? Math.round(s.total / grand * 100) : 0;
            html += '<div class="col-6 col-md-4 col-xl mb-3">' +
                '<div class="card dk-card h-100 p-3" style="border-top:4px solid ' + warnaSesi(i) + '">' +
                    '<div class="dk-label">' + esc(s.nama) + '</div>' +
                    '<div class="dk-val">' + fmt(s.total) + '</div>' +
                    '<small class="text-muted">' + pct + '% dari total periode</small>' +
                '</div></div>';
        });
        $('#gridSesi').html(html || '<div class="col-12 text-muted mb-3">Belum ada data ibadah.</div>');
    }

    function gambarTren() {
        if (!dataTren) return;
        var isLine = tipeTren === 'line';

        var datasets = dataTren.sesi.map(function (s, i) {
            var w = warnaSesi(i);
            return {
                label: s.nama,
                data: s.data,
                borderColor: w,
                backgroundColor: isLine ? rgba(w, 0.08) : rgba(w, 0.85),
                borderWidth: isLine ? 2.5 : 1,
                pointBackgroundColor: w,
                pointRadius: isLine ? 3 : 0,
                pointHoverRadius: 6,
                lineTension: 0.35,
                fill: false
            };
        });

        var extra = isLine ? {} : { scales: { xAxes: [{ stacked: true }], yAxes: [{ stacked: true }] } };

        gambar('tren', 'cvTren', isLine ? 'line' : 'bar',
            { labels: dataTren.labels, datasets: datasets }, extra);
    }

    function gambarDonut(sesi) {
        var total = sesi.reduce(function (a, s) { return a + s.total; }, 0);
        gambar('donut', 'cvDonut', 'doughnut', {
            labels: sesi.map(function (s) { return s.nama; }),
            datasets: [{
                data: sesi.map(function (s) { return s.total; }),
                backgroundColor: sesi.map(function (s, i) { return warnaSesi(i); }),
                borderWidth: 0
            }]
        }, {
            cutoutPercentage: 68,
            tooltips: {
                callbacks: {
                    label: function (item, d) {
                        var v = d.datasets[0].data[item.index];
                        var p = total ? Math.round(v / total * 100) : 0;
                        return ' ' + d.labels[item.index] + ': ' + fmt(v) + ' (' + p + '%)';
                    }
                }
            }
        });
    }

    function isiTabel(r) {
        var sesi = r.sesi;
        var peak = Math.max.apply(null, r.totalhari.concat([0]));

        var head = '<thead class="thead-light"><tr><th>Tanggal</th>';
        sesi.forEach(function (s) { head += '<th class="text-right">' + esc(s.nama) + '</th>'; });
        head += '<th class="text-right">Total</th></tr></thead>';

        var body = '<tbody>';
        if (!r.labels.length) {
            body += '<tr><td colspan="' + (sesi.length + 2) + '" class="text-center text-muted py-3">Tidak ada data</td></tr>';
        }
        r.labels.forEach(function (_, i) {
            var t = r.totalhari[i];
            var isPeak = t > 0 && t === peak;
            body += '<tr><td>' + r.tanggal[i] + '</td>';
            sesi.forEach(function (s) { body += '<td class="text-right">' + fmt(s.data[i]) + '</td>'; });
            body += '<td class="text-right ' + (isPeak ? 'dk-peak' : '') + '">' +
                (isPeak ? '<i class="fas fa-star text-warning"></i> ' : '') + fmt(t) + '</td></tr>';
        });
        body += '</tbody>';

        var foot = '<tfoot><tr><td>Total</td>';
        sesi.forEach(function (s) { foot += '<td class="text-right">' + fmt(s.total) + '</td>'; });
        foot += '<td class="text-right">' + fmt(r.ringkas.total) + '</td></tr></tfoot>';

        $('#tabelHarian').html(head + body + foot);
    }

    function muatGrafik(f) {
        ajax('getgrafik', f)
            .done(function (r) {
                if (r.error) notify('Perhatian', r.error, 'warning');

                isiRingkas(r.ringkas);
                isiSesi(r.sesi, r.ringkas.total);

                dataTren = r;
                gambarTren();
                gambarDonut(r.sesi);
                isiTabel(r);

                $('#catatanKosong').toggleClass('d-none', r.labels.length > 0);
            })
            .fail(function (xhr) {
                notify('Gagal', 'Data grafik gagal dimuat (HTTP ' + xhr.status + ').', 'error');
            });
    }

    // ===================== LOKASI =====================
    function muatLokasi(f) {
        ajax('getlokasi', f)
            .done(function (r) {
                var grup = {}, urut = [];

                (r.data || []).forEach(function (row) {
                    if (!grup[row.idsesi]) {
                        grup[row.idsesi] = { nama: row.namasesi, lokasi: [], total: 0 };
                        urut.push(row.idsesi);
                    }
                    grup[row.idsesi].lokasi.push(row);
                    grup[row.idsesi].total += row.total;
                });
                urut.sort();

                var html = '';
                urut.forEach(function (id, i) {
                    var g = grup[id];
                    var w = warnaSesi(i);
                    var tiles = g.lokasi.map(function (l) {
                        return '<div class="col-6 col-sm-4 col-md-3 col-xl-2 mb-2">' +
                            '<div class="dk-tile">' +
                                '<div class="small text-muted">' + esc(l.namalokasi || '-') + '</div>' +
                                '<div class="h5 font-weight-bold mb-0" style="color:' + w + '">' + fmt(l.total) + '</div>' +
                            '</div></div>';
                    }).join('');

                    html += '<div class="col-12 mb-3"><div class="card dk-card">' +
                        '<div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">' +
                            '<h6 class="font-weight-bold mb-0 text-uppercase">' + esc(g.nama) + '</h6>' +
                            '<span class="badge badge-pill" style="background:' + w + ';color:#fff">' + fmt(g.total) + ' jemaat</span>' +
                        '</div>' +
                        '<div class="card-body"><div class="row">' + tiles + '</div></div>' +
                    '</div></div>';
                });

                $('#gridLokasi').html(html || '<div class="col-12 text-center text-muted py-3">Tidak ada data ruangan pada periode ini.</div>');
            })
            .fail(function (xhr) {
                $('#gridLokasi').html('<div class="col-12 text-danger">Gagal memuat data ruangan (HTTP ' + xhr.status + ').</div>');
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
                        label: 'Kehadiran',
                        data: r.data,
                        backgroundColor: rgba('#6d28d9', 0.85),
                        borderColor: '#6d28d9',
                        borderWidth: 1
                    }]
                });
            })
            .fail(function (xhr) {
                notify('Gagal', 'Data per bulan gagal dimuat (HTTP ' + xhr.status + ').', 'error');
            });
    }

    // ===================== CETAK PDF =====================
    function cetakPdf() {
        var f = getFilter();
        if (!validFilter(f)) return;
        window.open(cfg.cetak + '?' + $.param(f), '_blank');
    }

    // ===================== INIT =====================
    $(function () {
        $('#btnTerapkan').on('click', terapkan);
        $('#btnCetak').on('click', cetakPdf);

        $('[data-preset]').on('click', function () {
            setPreset($(this).data('preset'));
        });

        $('input[name="tipeTren"]').on('change', function () {
            tipeTren = $(this).closest('label').data('type');
            gambarTren();
        });

        muatSemua(getFilter());
    });

})(jQuery);