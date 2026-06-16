const $ = id => document.getElementById(id);
const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

function applyFontSize(val) {
    const valid = ['small', 'medium', 'large'];
    if (!valid.includes(val)) val = 'medium';
    document.documentElement.classList.remove('font-small', 'font-medium', 'font-large');
    document.documentElement.classList.add('font-' + val);
}

(function initPreferences() {
    const btn = document.getElementById('btn-dark');
    if (btn) btn.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
})();

function toggleDark() {
    const isDark = document.documentElement.classList.toggle('dark');
    setCookie('tema', isDark ? 'dark' : 'light', 30);
    const btn = document.getElementById('btn-dark');
    if (btn) btn.textContent = isDark ? '☀️' : '🌙';
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sb-overlay');
    if (!sidebar) return;
    const isOpen = sidebar.classList.contains('open');
    sidebar.classList.toggle('open', !isOpen);
    if (overlay) overlay.classList.toggle('show', !isOpen);
}

let inventaris = [];
let editIndex  = null;

const toast = msg => {
    const t = $('inv-toast');
    if (!t) return;
    t.textContent = msg;
    t.classList.add('on');
    setTimeout(() => t.classList.remove('on'), 2500);
};
const save = () => localStorage.setItem('mua_inv', JSON.stringify(inventaris));
const load = () => {
    const d = localStorage.getItem('mua_inv');
    inventaris = d ? JSON.parse(d) : [];
};
const renderStat = () => {
    if ($('stat-item'))  $('stat-item').textContent  = inventaris.length;
    if ($('stat-nilai')) $('stat-nilai').textContent = rupiah(inventaris.reduce((s,i) => s + i.stok * i.harga, 0));
    if ($('stat-tipis')) $('stat-tipis').textContent = inventaris.filter(i => i.stok < 5).length;
};
const renderTabel = () => {
    const tbody = $('inv-tbody');
    if (!tbody) return;
    const q   = $('inv-search') ? $('inv-search').value.toLowerCase() : '';
    const kat = $('inv-kat')    ? $('inv-kat').value                  : '';
    const data = inventaris.filter(i =>
        (i.nama.toLowerCase().includes(q) || i.kode.toLowerCase().includes(q)) &&
        (!kat || i.kat === kat)
    );
    if (!data.length) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--muted)">Tidak ada data</td></tr>`;
        renderStat();
        return;
    }
    tbody.innerHTML = data.map(i => {
        const idx = inventaris.indexOf(i);
        return `<tr>
            <td>${i.kode}</td><td>${i.nama}</td><td>${i.kat}</td>
            <td><span class="${i.stok < 5 ? 'stok-tipis' : 'stok-aman'}">${i.stok}</span></td>
            <td>${rupiah(i.harga)}</td><td>${i.tgl}</td>
            <td>
                <button class="btn-edit-row" data-i="${idx}">Edit</button>
                <button class="btn-del-row"  data-i="${idx}">Hapus</button>
            </td>
        </tr>`;
    }).join('');
    renderStat();
};
const bukaForm = (idx = null) => {
    editIndex = idx;
    if (idx !== null) {
        const d = inventaris[idx];
        $('f-kode').value  = d.kode;
        $('f-nama').value  = d.nama;
        $('f-kat').value   = d.kat;
        $('f-stok').value  = d.stok;
        $('f-harga').value = d.harga;
        $('f-tgl').value   = d.tgl;
    } else {
        ['f-kode','f-nama','f-kat','f-stok','f-harga','f-tgl']
            .forEach(id => { if ($(id)) $(id).value = ''; });
    }
    const modal = $('modal-form');
    if (modal) modal.classList.add('aktif');
};
const tutupForm = () => {
    const modal = $('modal-form');
    if (modal) modal.classList.remove('aktif');
    editIndex = null;
};
const simpan = () => {
    const data = {
        kode:  $('f-kode')  ? $('f-kode').value   : '',
        nama:  $('f-nama')  ? $('f-nama').value   : '',
        kat:   $('f-kat')   ? $('f-kat').value    : '',
        stok:  $('f-stok')  ? +$('f-stok').value  : 0,
        harga: $('f-harga') ? +$('f-harga').value : 0,
        tgl:   $('f-tgl')   ? $('f-tgl').value    : '',
    };
    if (editIndex !== null) {
        inventaris[editIndex] = data;
        toast('✅ Update berhasil');
    } else {
        inventaris.push(data);
        toast('✅ Tambah berhasil');
    }
    save(); tutupForm(); renderTabel();
};
const hapus = idx => {
    if (!confirm('Hapus data ini?')) return;
    inventaris.splice(idx, 1);
    save(); renderTabel(); toast('🗑️ Data dihapus');
};

const filterCard = () => {
    const checked = [...document.querySelectorAll('aside input:checked')]
        .map(cb => cb.parentElement.textContent.trim());
    document.querySelectorAll('#Portofolio .card').forEach(card => {
        card.style.display =
            (checked.length === 0 || checked.includes(card.dataset.kat))
                ? 'block' : 'none';
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('sb-overlay');
    if (overlay) {
        overlay.addEventListener('click', () => {
            document.getElementById('sidebar')?.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    const fcClose  = $('fc-close');
    const fcBatal  = $('fc-batal');
    const fcSimpan = $('fc-simpan');
    if (fcClose)  fcClose.onclick  = tutupForm;
    if (fcBatal)  fcBatal.onclick  = tutupForm;
    if (fcSimpan) fcSimpan.onclick = simpan;

    const invTbody = $('inv-tbody');
    if (invTbody) {
        invTbody.addEventListener('click', e => {
            const edit = e.target.closest('.btn-edit-row');
            const del  = e.target.closest('.btn-del-row');
            if (edit?.dataset.i !== undefined) bukaForm(+edit.dataset.i);
            if (del?.dataset.i  !== undefined) hapus(+del.dataset.i);
        });
    }

    const invSearch = $('inv-search');
    const invKat    = $('inv-kat');
    if (invSearch) invSearch.addEventListener('input',  renderTabel);
    if (invKat)    invKat.addEventListener('change',    renderTabel);

    document.querySelectorAll('aside input[type="checkbox"]').forEach(cb => {
        cb.addEventListener('change', filterCard);
    });

    load();
    if ($('inv-tbody')) renderTabel();

    const btnDark = document.getElementById('btn-dark');
    if (btnDark) btnDark.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';

    document.querySelectorAll('.flash-success, .flash-error').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 3500);
    });
});
