(function ($) {
    'use strict';

    var cfg = window.DNS || {};
    var BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    var REDUCE_MOTION = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Satu sumber konfigurasi untuk KPI, grafik, dan tabel
    var KELAS = [
        { key: 'membership', label: 'Membership Class',   url: 'getgrafikmembership', info: 'MembershipClass', kl: 'KL001', warna: '#4e73df', icon: 'fa-id-badge',       chart: true },
        { key: 'fc1',        label: 'Foundation Class 1', url: 'getgrafikfc1',        info: 'FondationClass1', kl: 'KL002', warna: '#e74a3b', icon: 'fa-user-graduate',  chart: true },
        { key: 'fc2',        label: 'Foundation Class 2', url: 'getgrafikfc2',        info: 'FondationClass2', kl: 'KL003', warna: '#1cc88a', icon: 'fa-user-graduate',  chart: true },
        { key: 'fc3',        label: 'Foundation Class 3', url: 'getgrafikfc3',        info: 'FondationClass3', kl: 'KL004', warna: '#f6c23e', icon: 'fa-user-graduate',  chart: true },
        { key: 'grade1',     label: 'Grade 1',            url: 'getgrafikgrade1',     info: 'Grade1',          kl: 'KL005', warna: '#36b9cc', icon: 'fa-book-open',      chart: true },
        { key: 'grade2',     label: 'Grade 2',            url: 'getgrafikgrade2',     info: 'Grade2',          kl: 'KL006', warna: '#fd7e14', icon: 'fa-book-open',      chart: true },
        { key: 'grade3',     label: 'Grade 3',            url: 'getgrafikgrade3',     info: 'Grade3',          kl: 'KL007', warna: '#6f42c1', icon: 'fa-book-open',      chart: true },
        { key: 'volunteer',  label: 'Volunteer Class',    url: 'getgrafikfolunteer',  info: 'FolunteerClass',  kl: 'KL008', warna: '#20c997', icon: 'fa-hands-helping',  chart: true },
        { key: 'marriage',   label: 'Marriage Class',     url: null,                  info: 'MarriageClass',   kl: 'KL101', warna: '#e83e8c', icon: 'fa-ring',           chart: false }
    ];

    var CHARTS = KELAS.filter(function (c) { return c.chart; });
    var infobox = {};
    var data = {};
    var charts = {};
    var chartType = 'bar';
    var pending = 0;

    // ===================== UTILITAS =====================
    function fmt(n) {
        return (parseInt(n, 10) || 0).toLocaleString('id-ID');
    }

    function toInt(v) {
        return parseInt(v, 10) || 0;
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

    // ===================== KPI =====================
    function renderKpi() {
        var html = '';
        KELAS.forEach(function (c) {
            html += '<div class="col-xl col-md-4 col-6 mb-3">' +
                '<a href="' + cfg.registrasi + c.kl + '" class="dns-kpi-link">' +
                    '<div class="card dns-card dns-kpi h-100">' +
                        '<div class="d-flex align-items-center mb-2">' +
                            '<div class="dns-ico mr-2" style="background:' + c.warna + '"><i class="fas ' + c.icon + '"></i></div>' +
                            '<div class="dns-label">' + c.label + '</div>' +
                        '</div>' +
                        '<div class="dns-val">0</div>' +
                        '<small class="text-muted d-block mt-1">Total lulus</small>' +
                    '</div>' +
                '</a></div>';
        });
        $('#rowKpi').html(html);

        KELAS.forEach(function (c, i) {
            animateNumber($('#rowKpi .dns-val').eq(i), toInt(infobox[c.info]));
        });
    }

    function renderHero() {
        var total = 0;
        KELAS.forEach(function (c) { total += toInt(infobox[c.info]); });

        var fondation = toInt(infobox.FondationClass1) + toInt(infobox.FondationClass2) + toInt(infobox.FondationClass3);
        var grade = toInt(infobox.Grade1) + toInt(infobox.Grade2) + toInt(infobox.Grade3);

        animateNumber($('#heroTotal'), total);
        animateNumber($('#heroMembership'), toInt(infobox.MembershipClass));
        animateNumber($('#heroFoundation'), fondation);
        animateNumber($('#heroGrade'), grade);
    }

    // ===================== KARTU GRAFIK =====================
    function renderCards() {
        var kolom = cfg.mode === 'detail' ? 'col-12' : 'col-lg-6';
        var html = '';
        CHARTS.forEach(function (c) {
            html += '<div class="' + kolom + ' mb-4">' +
                '<div class="card dns-card h-100">' +
                    '<div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-start">' +
                        '<div>' +
                            '<h6 class="font-weight-bold mb-0"><span class="dns-dot" style="background:' + c.warna + '"></span>' + c.label + '</h6>' +
                            '<small class="text-muted">Sertifikat terbit per bulan, ' + cfg.tahun + '</small>' +
                        '</div>' +
                        '<div class="text-right">' +
                            '<div class="dns-total" id="tot-' + c.key + '">&ndash;</div>' +
                            '<small class="text-muted">tahun ini</small>' +
                        '</div>' +
                    '</div>' +
                    '<div class="card-body">' +
                        '<div class="dns-chart-box"><canvas id="cv-' + c.key + '"></canvas></div>' +
                        '<div class="mt-2"><span class="dns-insight" id="ft-' + c.key + '">Memuat...</span></div>' +
                    '</div>' +
                '</div></div>';
        });
        $('#gridKelas').html(html);
    }

    function drawChart(c) {
        var res = data[c.key];
        if (!res) return;

        var isLine = chartType === 'line';
        var puncak = Math.max.apply(null, res.jumlahmurid);
        var idx = res.jumlahmurid.indexOf(puncak);

        animateNumber($('#tot-' + c.key), res.totalsiswa);
        $('#ft-' + c.key).html(puncak > 0
            ? '<i class="fas fa-lightbulb"></i> Puncak: <b>' + BULAN[idx] + '</b> dengan <b>' + fmt(puncak) + '</b> sertifikat'
            : 'Belum ada sertifikat tahun ini.');

        if (charts[c.key]) charts[c.key].destroy();

        charts[c.key] = new Chart(document.getElementById('cv-' + c.key).getContext('2d'), {
            type: chartType,
            data: {
                labels: BULAN,
                datasets: [{
                    label: c.label,
                    data: res.jumlahmurid,
                    borderColor: c.warna,
                    backgroundColor: isLine ? rgba(c.warna, 0.08) : rgba(c.warna, 0.85),
                    borderWidth: isLine ? 2.5 : 1,
                    pointBackgroundColor: c.warna,
                    pointRadius: isLine ? 3 : 0,
                    pointHoverRadius: 6,
                    lineTension: 0.35,
                    fill: false
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                animation: { duration: 400 },
                legend: { display: false },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (item) { return ' ' + fmt(item.yLabel) + ' sertifikat'; }
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
            }
        });
    }

    function drawAllCharts() {
        CHARTS.forEach(drawChart);
    }

    // ===================== TABEL RINCIAN (halaman detail) =====================
    function renderTabel() {
        var $tabel = $('#tabelBulanan');
        if (!$tabel.length || pending > 0) return;

        var head = '<thead class="thead-light"><tr><th>Bulan</th>';
        CHARTS.forEach(function (c) { head += '<th class="text-right">' + c.label + '</th>'; });
        head += '<th class="text-right">Total</th></tr></thead>';

        var body = '<tbody>';
        var totals = {};
        CHARTS.forEach(function (c) { totals[c.key] = 0; });
        var grand = 0;

        BULAN.forEach(function (b, i) {
            var baris = 0;
            body += '<tr><td class="font-weight-bold">' + b + '</td>';
            CHARTS.forEach(function (c) {
                var v = data[c.key] ? (data[c.key].jumlahmurid[i] || 0) : 0;
                totals[c.key] += v;
                baris += v;
                body += '<td class="text-right">' + fmt(v) + '</td>';
            });
            body += '<td class="text-right font-weight-bold">' + fmt(baris) + '</td></tr>';
            grand += baris;
        });
        body += '</tbody>';

        var foot = '<tfoot><tr><td>Total</td>';
        CHARTS.forEach(function (c) { foot += '<td class="text-right">' + fmt(totals[c.key]) + '</td>'; });
        foot += '<td class="text-right">' + fmt(grand) + '</td></tr></tfoot>';

        $tabel.html(head + body + foot);
    }

    // ===================== LOAD DATA =====================
    function loadInfobox() {
        $.getJSON(cfg.base + 'getinfobox')
            .done(function (res) {
                infobox = (res && res[0]) ? res[0] : {};
                renderKpi();
                renderHero();
            })
            .fail(function (xhr) {
                $('#rowKpi').html('<div class="col-12 text-danger">Data kelas gagal dimuat (HTTP ' + xhr.status + ').</div>');
            });
    }

    function loadChart(c) {
        pending++;
        $.getJSON(cfg.base + c.url)
            .done(function (res) {
                // Nilai dari server bisa berupa string, jadi dinormalisasi ke integer
                data[c.key] = {
                    datatanggal: res.datatanggal,
                    jumlahmurid: (res.jumlahmurid || []).map(toInt),
                    totalsiswa:  toInt(res.totalsiswa)
                };
                drawChart(c);
            })
            .fail(function (xhr) {
                $('#tot-' + c.key).text('–');
                $('#ft-' + c.key).html('<span class="text-danger">Gagal dimuat (HTTP ' + xhr.status + ')</span>');
            })
            .always(function () {
                pending--;
                renderTabel();
            });
    }

    // ===================== INIT =====================
    $(function () {
        renderCards();
        loadInfobox();
        CHARTS.forEach(loadChart);

        $('input[name="chartType"]').on('change', function () {
            chartType = $(this).closest('label').data('type');
            drawAllCharts();
        });

        $('#btnRefresh').on('click', function () {
            window.location.reload();
        });
    });

})(jQuery);