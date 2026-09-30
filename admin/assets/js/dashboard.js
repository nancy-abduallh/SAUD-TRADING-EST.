(() => {
    'use strict';
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const kebab = s => (s || '').replace(/([a-z])([A-Z0-9])/g, '$1-$2').toLowerCase();
    const icons = () => window.lucide && window.lucide.createIcons();

    /* ---------- toast ---------- */
    window.toast = (msg, type = 'ok') => {
        const t = document.createElement('div');
        t.className = 'toast ' + type;
        t.textContent = msg;
        $('#toasts').appendChild(t);
        requestAnimationFrame(() => t.classList.add('show'));
        setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3300);
    };

    /* ---------- API ---------- */
    async function parse(res) {
        if (res.status === 401) { location.href = 'login.php'; return { ok: false, error: 'Session expired' }; }
        try { return await res.json(); } catch { return { ok: false, error: 'Unexpected server response' }; }
    }
    window.api = async (action, data = {}, extra = {}) => {
        const body = new FormData();
        Object.entries(data).forEach(([k, v]) => body.append(k, v));
        const qs = new URLSearchParams({ action, ...extra });
        return parse(await fetch('api.php?' + qs, { method: 'POST', body, headers: { 'X-CSRF-Token': window.CSRF } }));
    };

    /* ---------- modals ---------- */
    const openModal = m => { m.classList.add('open'); document.body.classList.add('no-scroll'); };
    const closeModal = m => { m.classList.remove('open'); document.body.classList.remove('no-scroll'); };
    document.addEventListener('click', e => {
        const c = e.target.closest('[data-close]');
        if (c) closeModal(c.closest('.modal'));
        else if (e.target.classList.contains('modal')) closeModal(e.target);
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') $$('.modal.open').forEach(closeModal); });
    const confirmDialog = text => new Promise(res => {
        const m = $('#confirmModal');
        $('#confirmText').textContent = text;
        openModal(m);
        $('#confirmOk').onclick = () => { closeModal(m); res(true); };
    });

    /* ---------- sidebar / dropdown / tabs ---------- */
    const store = {
        get: k => { try { return localStorage.getItem(k); } catch { return null; } },
        set: (k, v) => { try { localStorage.setItem(k, v); } catch { } }
    };
    if (store.get('collapsed') === '1') document.body.classList.add('collapsed');
    $('#collapseBtn')?.addEventListener('click', () => {
        document.body.classList.toggle('collapsed');
        store.set('collapsed', document.body.classList.contains('collapsed') ? '1' : '0');
    });
    $('#menuBtn')?.addEventListener('click', () => {
        if (innerWidth <= 900) document.body.classList.toggle('side-open');
        else $('#collapseBtn')?.click();
    });
    $('#profileBtn')?.addEventListener('click', e => { e.stopPropagation(); $('#profileMenu').classList.toggle('open'); });
    document.addEventListener('click', () => $('#profileMenu')?.classList.remove('open'));

    $$('.tabs [data-pane]').forEach(b => b.addEventListener('click', () => {
        $$('.tabs [data-pane]').forEach(x => x.classList.toggle('active', x === b));
        $$('.pane').forEach(p => p.classList.toggle('active', p.id === b.dataset.pane));
    }));
    $$('.tabs [data-tab]').forEach(b => b.addEventListener('click', () => {
        $$('.tabs [data-tab]').forEach(x => x.classList.toggle('active', x === b));
        applyFilters();
    }));

    /* ---------- table search / filter ---------- */
    function applyFilters() {
        const q = ($('#globalSearch')?.value || '').trim().toLowerCase();
        const f = $('#filterSel')?.value || '';
        const tab = $('.tabs [data-tab].active')?.dataset.tab;
        $$('#dataTable tbody tr[data-id], #dataTable tbody tr[data-msg]').forEach(tr => {
            let show = !q || tr.textContent.toLowerCase().includes(q);
            if (show && f && tr.dataset.filter !== f) show = false;
            if (show && tab && tab !== 'all' && tr.dataset.read !== (tab === 'read' ? '1' : '0')) show = false;
            tr.hidden = !show;
        });
    }
    $('#globalSearch')?.addEventListener('input', applyFilters);
    $('#filterSel')?.addEventListener('change', applyFilters);

    /* ---------- generic API forms ---------- */
    document.addEventListener('submit', async e => {
        const form = e.target.closest('form[data-action]');
        if (!form) return;
        e.preventDefault();
        const btn = $('[type=submit]', form);
        btn && (btn.disabled = true);
        const qs = new URLSearchParams({ action: form.dataset.action });
        if (form.dataset.module) qs.set('module', form.dataset.module);
        if (form.dataset.group) qs.set('group', form.dataset.group);
        try {
            const res = await fetch('api.php?' + qs, { method: 'POST', body: new FormData(form), headers: { 'X-CSRF-Token': window.CSRF } });
            const j = await parse(res);
            if (j.ok) {
                toast(j.message || 'Saved');
                if ('reset' in form.dataset) form.reset();
                if ('reload' in form.dataset) setTimeout(() => location.reload(), 500);
            } else toast(j.error || 'Something went wrong', 'err');
        } catch { toast('Network error', 'err'); }
        btn && (btn.disabled = false);
    });

    /* ---------- image + icon previews ---------- */
    document.addEventListener('change', e => {
        if (!e.target.classList.contains('file-input')) return;
        const f = e.target.files[0], img = e.target.closest('.img-field').querySelector('img');
        if (f) { img.src = URL.createObjectURL(f); img.hidden = false; }
    });
    document.addEventListener('input', e => {
        const inp = e.target.closest('.icon-field input');
        if (inp) setIcon(inp);
    });
    function setIcon(inp) {
        inp.closest('.icon-field').querySelector('.icon-preview').innerHTML = `<i data-lucide="${kebab(inp.value)}"></i>`;
        icons();
    }

    /* ---------- CRUD pages ---------- */
    function initCrud() {
        const C = window.CRUD;
        if (!C) return;
        const modal = $('#formModal'), form = $('#recordForm'), tbody = $('#dataTable tbody');
        const idField = form.querySelector('[name=id]');

        const fill = row => {
            form.reset();
            idField.value = row ? row.id : '';
            C.fields.forEach(f => {
                const el = form.elements[f.name];
                if (!el) return;
                const v = row ? (row[f.name] ?? '') : null;
                if (f.type === 'toggle') el.checked = row ? String(v) === '1' : true;
                else if (f.type === 'number') el.value = row ? v : 0;
                else if (f.type === 'rating') el.value = row ? v : 5;
                else if (f.type === 'image') {
                    el.value = v ?? '';
                    const img = el.closest('.img-field').querySelector('img');
                    img.src = v || ''; img.hidden = !v;
                } else el.value = v ?? '';
                if (f.type === 'icon') setIcon(el);
            });
            if (!row && C.filter && $('#filterSel')?.value) form.elements[C.filter].value = $('#filterSel').value;
        };

        $('[data-add]').addEventListener('click', () => { fill(null); $('#modalTitle').textContent = 'Add ' + C.singular; openModal(modal); });

        tbody.addEventListener('click', async e => {
            const tr = e.target.closest('tr[data-id]');
            if (!tr) return;
            if (e.target.closest('[data-edit]')) {
                fill(C.rows[tr.dataset.id]); $('#modalTitle').textContent = 'Edit ' + C.singular; openModal(modal);
            } else if (e.target.closest('[data-delete]')) {
                const extra = C.module === 'services' ? ' All its categories and products will be deleted too.'
                    : C.module === 'categories' ? ' All its products will be deleted too.' : '';
                if (!await confirmDialog('Delete this ' + C.singular.toLowerCase() + '?' + extra)) return;
                const j = await api('delete', { id: tr.dataset.id }, { module: C.module });
                if (j.ok) { tr.remove(); toast(j.message); } else toast(j.error, 'err');
            }
        });

        tbody.addEventListener('change', async e => {
            if (!e.target.classList.contains('tg')) return;
            const tr = e.target.closest('tr');
            const j = await api('toggle', { id: tr.dataset.id }, { module: C.module });
            if (!j.ok) { e.target.checked = !e.target.checked; toast(j.error, 'err'); } else toast(j.value ? 'Enabled' : 'Disabled');
        });

        if (C.sortable) {
            let drag = null;
            tbody.addEventListener('dragstart', e => { drag = e.target.closest('tr'); drag?.classList.add('dragging'); });
            tbody.addEventListener('dragover', e => {
                e.preventDefault();
                const t = e.target.closest('tr[data-id]');
                if (!drag || !t || t === drag) return;
                const r = t.getBoundingClientRect();
                t.parentNode.insertBefore(drag, e.clientY > r.top + r.height / 2 ? t.nextSibling : t);
            });
            tbody.addEventListener('dragend', async () => {
                if (!drag) return;
                drag.classList.remove('dragging'); drag = null;
                const ids = $$('tr[data-id]', tbody).map(tr => tr.dataset.id).join(',');
                const j = await api('reorder', { ids }, { module: C.module });
                j.ok ? toast('Order saved') : toast(j.error, 'err');
            });
        }
    }

    /* ---------- messages ---------- */
    function initMessages() {
        const M = window.MSGS;
        if (!M) return;
        const modal = $('#msgModal');
        let cur = null, curRow = null;
        const setRead = (tr, read) => { tr.dataset.read = read ? '1' : '0'; tr.classList.toggle('unread', !read); };

        $('#dataTable').addEventListener('click', async e => {
            const tr = e.target.closest('tr[data-msg]');
            if (!tr) return;
            cur = M[tr.dataset.msg]; curRow = tr;
            $('#mSubject').textContent = cur.subject || '(no subject)';
            $('#mName').textContent = cur.name;
            $('#mEmail').textContent = cur.email;
            $('#mPhone').textContent = cur.phone || '';
            $('#mDate').textContent = cur.created_at;
            $('#mBody').textContent = cur.message || '';
            $('#mReply').href = 'mailto:' + cur.email + '?subject=' + encodeURIComponent('Re: ' + (cur.subject || ''));
            openModal(modal);
            if (String(cur.is_read) === '0') {
                const j = await api('msg_read', { id: cur.id });
                if (j.ok) { cur.is_read = 1; setRead(tr, true); }
            }
        });
        $('#mUnread').addEventListener('click', async () => {
            const j = await api('msg_unread', { id: cur.id });
            if (j.ok) { cur.is_read = 0; setRead(curRow, false); closeModal(modal); toast('Marked as unread'); }
        });
        $('#mDelete').addEventListener('click', async () => {
            closeModal(modal);
            if (!await confirmDialog('Delete this message permanently?')) return;
            const j = await api('msg_delete', { id: cur.id });
            if (j.ok) { curRow.remove(); toast(j.message); } else toast(j.error, 'err');
        });
    }

    /* ---------- KPI counters ---------- */
    $$('[data-count]').forEach(el => {
        const target = +el.dataset.count, t0 = performance.now();
        const tick = t => {
            const p = Math.min(1, (t - t0) / 900);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    });

    /* ---------- charts ---------- */
    function initCharts() {
        const D = window.DASH;
        if (!D || !window.Chart) return;
        Chart.defaults.color = '#9aa4d6';
        Chart.defaults.font.family = "Inter, Cairo, sans-serif";
        Chart.defaults.borderColor = 'rgba(255,255,255,.06)';
        const pal = ['#4fc3f7', '#26c6da', '#7986cb', '#ba68c8', '#ffb74d', '#81c784', '#f06292', '#4db6ac', '#ffd54f', '#90a4ae', '#a1887f', '#e57373', '#64b5f6'];
        const base = { responsive: true, maintainAspectRatio: false };

        new Chart($('#chMsgs'), {
            type: 'line', data: {
                labels: D.msgs.labels, datasets: [{
                    label: 'Messages', data: D.msgs.data,
                    borderColor: '#4fc3f7', backgroundColor: 'rgba(79,195,247,.16)', fill: true, tension: .35, pointRadius: 4
                }]
            },
            options: { ...base, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        new Chart($('#chSector'), {
            type: 'doughnut', data: {
                labels: D.perSector.labels, datasets: [{
                    data: D.perSector.data,
                    backgroundColor: pal, borderWidth: 0
                }]
            }, options: { ...base, cutout: '62%', plugins: { legend: { position: 'bottom' } } }
        });

        new Chart($('#chCat'), {
            type: 'bar', data: {
                labels: D.perCat.labels, datasets: [{
                    label: 'Products', data: D.perCat.data,
                    backgroundColor: pal, borderRadius: 6
                }]
            }, options: {
                ...base, indexAxis: 'y', plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        new Chart($('#chRate'), {
            type: 'bar', data: {
                labels: ['1★', '2★', '3★', '4★', '5★'], datasets: [{
                    label: 'Testimonials',
                    data: D.ratings, backgroundColor: '#26c6da', borderRadius: 6
                }]
            },
            options: { ...base, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    }

    icons();
    initCrud();
    initMessages();
    initCharts();
})();