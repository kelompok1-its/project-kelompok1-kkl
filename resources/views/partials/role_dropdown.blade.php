<div class="header-bar" style="position:relative;">
    <div class="header-bar-inner" style="position:relative;">
        <div class="header-bar">
            Dashboard Pengelolaan Mata Kuliah & Ploting Dosen

            <!-- profile icon on the right inside the same header-bar -->
            <button class="profile-icon" id="profileBtn" aria-haspopup="true" aria-expanded="false" title="Profile / Ganti Aktor">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0b0b0b" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </button>

            <div id="profileDropdown" class="profile-dropdown" role="menu" aria-labelledby="profileBtn">
                <div style="padding:8px 12px; font-weight:700; color:#2b5f36;">Pilih Aktor</div>

                @php $current = session('current_role_slug', null); @endphp

                <form method="POST" action="{{ route('role.switch') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="role" value="akademik">
                    <button type="submit" class="role-item" aria-current="{{ $current === 'akademik' ? 'true' : 'false' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L1 7l11 5 9-4.09V17" stroke="#1f8b4a" stroke-width="1.4" />
                        </svg>
                        <span>Akademik</span>
                        @if($current === 'akademik') <span style="margin-left:auto;color:#1f8b4a;font-size:12px">(Aktif)</span> @endif
                    </button>
                </form>

                <form method="POST" action="{{ route('role.switch') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="role" value="kaprodi">
                    <button type="submit" class="role-item" aria-current="{{ $current === 'kaprodi' ? 'true' : 'false' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4" stroke="#ff9f1c" stroke-width="1.4" />
                        </svg>
                        <span>Kaprodi</span>
                        @if($current === 'kaprodi') <span style="margin-left:auto;color:#ff9f1c;font-size:12px">(Aktif)</span> @endif
                    </button>
                </form>

                <form method="POST" action="{{ route('role.switch') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="role" value="dekan">
                    <button type="submit" class="role-item" aria-current="{{ $current === 'dekan' ? 'true' : 'false' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l3 6 6 .5-4.5 3.5L18 20" stroke="#79c2a5" stroke-width="1.2" />
                        </svg>
                        <span>Dekan</span>
                        @if($current === 'dekan') <span style="margin-left:auto;color:#79c2a5;font-size:12px">(Aktif)</span> @endif
                    </button>
                </form>

                <form method="POST" action="{{ route('role.switch') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="role" value="wr1">
                    <button type="submit" class="role-item" aria-current="{{ $current === 'wr1' ? 'true' : 'false' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l7 3v6c0 5-3.58 9.74-7 11" stroke="#e04f5f" stroke-width="1.4" />
                        </svg>
                        <span>Wakil Rektor I</span>
                        @if($current === 'wr1') <span style="margin-left:auto;color:#e04f5f;font-size:12px">(Aktif)</span> @endif
                    </button>
                </form>

                <form method="POST" action="{{ route('role.switch') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="role" value="dosen">
                    <button type="submit" class="role-item" aria-current="{{ $current === 'dosen' ? 'true' : 'false' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M3 7l9 4 9-4" stroke="#6b6bff" stroke-width="1.4" />
                        </svg>
                        <span>Dosen</span>
                        @if($current === 'dosen') <span style="margin-left:auto;color:#6b6bff;font-size:12px">(Aktif)</span> @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const btn = document.getElementById('profileBtn');
        const dd = document.getElementById('profileDropdown');
        if (!btn || !dd) return;

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dd.classList.toggle('show');
            if (dd.classList.contains('show')) {
                const first = dd.querySelector('button');
                if (first) first.focus();
            }
        });

        dd.querySelectorAll('form').forEach(f => f.addEventListener('submit', () => dd.classList.remove('show')));

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') dd.classList.remove('show');
        });
    })();
</script>