<!-- ===== TOP BAR ===== -->
<div class="topbar">
    <div class="topbar-left">
        @php
        $role = session('current_role_slug', 'akademik');
        $dashboardTitles = [
        'akademik' => 'Dashboard Pengelolaan Mata Kuliah & Ploting Dosen',
        'kaprodi' => 'Dashboard Kaprodi – Kuisioner & Ploting',
        'dekan' => 'Dashboard Dekan – Verifikasi & Approval',
        'wr1' => 'Dashboard Wakil Rektor I – Final Approval SK',
        'dosen' => 'Dashboard Dosen – Kuisioner & Jadwal Mengajar',
        ];
        $currentTitle = $dashboardTitles[$role] ?? 'Dashboard Sistem Informasi Akademik';
        @endphp

        <h2>{{ $currentTitle }}</h2>
    </div>

    <div class="topbar-right">



        <!-- PROFILE BUTTON -->
        <button class="profile-mini" id="topProfileBtn">
            <i class="bi bi-person-circle"></i>
        </button>

        <!-- CURRENT ROLE LABEL -->
        <span class="role-badge">{{ session('current_role', 'Akademik') }}</span>

        <!-- DROPDOWN -->
        <div id="topProfileDropdown" class="top-dropdown">

            <div class="dd-title">Pilih Aktor</div>

            @php $current = session('current_role_slug'); @endphp

            @foreach([
            'akademik' => 'Akademik',
            'kaprodi' => 'Kaprodi',
            'dekan' => 'Dekan',
            'wr1' => 'Wakil Rektor I',
            'dosen' => 'Dosen'
            ] as $slug => $label)

            <form action="{{ route('role.switch') }}" method="POST" class="dd-form">
                @csrf
                <input type="hidden" name="role" value="{{ $slug }}">
                <button class="dd-item">
                    <span>{{ $label }}</span>
                    @if($current === $slug)
                    <small class="active-text">Aktif</small>
                    @endif
                </button>
            </form>

            @endforeach

        </div>

    </div>
</div>

<!-- ===== END TOP BAR ===== -->


<!-- ===== TOP BAR CSS ===== -->
<style>
    .topbar {
        width: 100%;
        background: #ffffff;
        padding: 14px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 10px;
        margin-bottom: 22px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.08);
    }

    .topbar-left h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #2d2d2d;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
    }

    .icon-btn,
    .profile-mini {
        background: #f3f3f3;
        border: none;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: 0.2s;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-btn:hover,
    .profile-mini:hover {
        background: #e3e3e3;
    }

    .role-badge {
        background: #eef2ff;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    /* DROPDOWN */
    .top-dropdown {
        position: absolute;
        right: 0;
        top: 48px;
        min-width: 220px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        padding: 8px 0;
        display: none;
        z-index: 2000;
    }

    .top-dropdown.show {
        display: block;
    }

    .dd-title {
        padding: 10px 16px;
        font-weight: 700;
        border-bottom: 1px solid #eee;
        color: #215732;
    }

    .dd-item {
        width: 100%;
        padding: 10px 16px;
        background: transparent;
        border: none;
        display: flex;
        justify-content: space-between;
        cursor: pointer;
        font-size: 14px;
        transition: 0.2s;
    }

    .dd-item:hover {
        background: #f3f7f3;
    }

    .active-text {
        color: #2a7a33;
        font-weight: 600;
        font-size: 12px;
    }
</style>


<!-- ===== TOP BAR SCRIPT ===== -->
<script>
    const tpBtn = document.getElementById('topProfileBtn');
    const tpDrop = document.getElementById('topProfileDropdown');

    tpBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        tpDrop.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
        if (!tpDrop.contains(e.target) && !tpBtn.contains(e.target)) {
            tpDrop.classList.remove('show');
        }
    });
</script>