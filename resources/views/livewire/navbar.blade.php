<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <div class="card fixed-bottom shadow mb-0" wire:ignore>
        <div class="card-body">
            <div class="d-flex justify-content-around">
                <a href='{{ route('user.home') }}' class="d-flex flex-column align-items-center">
                    <span class='mb-1 {{ request()->is('user') ? 'text-danger' : 'text-muted' }}'>
                        <i class="bi bi-house{{ request()->is('user') ? '-fill' : '' }} font-size-22"></i>
                    </span>
                    <span class="{{ request()->is('user') ? 'text-danger' : 'text-muted' }}">Home</span>
                </a>
                <a href='{{ route('absen.index') }}' class="d-flex flex-column align-items-center">
                    <span class='mb-1 {{ request()->is('user/absen*') ? 'text-danger' : 'text-muted' }}'>
                        <i class="bi bi-clock{{ request()->is('user/absen*') ? '-fill' : '' }} font-size-22"></i>
                    </span>
                    <span class="{{ request()->is('user/absen*') ? 'text-danger' : 'text-muted' }}">Absen</span>
                </a>
                <a href='{{ route('kegiatan.index') }}' class="d-flex flex-column align-items-center">
                    <span class='mb-1 {{ request()->is('user/kegiatan*') ? 'text-danger' : 'text-muted' }}'>
                        <i class="bi bi-chat-square-text{{ request()->is('user/kegiatan*') ? '-fill' : '' }} font-size-22"></i>
                    </span>
                    <span class="{{ request()->is('user/kegiatan*') ? 'text-danger' : 'text-muted' }}">Kegiatan</span>
                </a>
                <a href='{{ route('user.profil') }}' class="d-flex flex-column align-items-center">
                    <span class='mb-1 {{ request()->is('user/profil*') ? 'text-danger' : 'text-muted' }}'>
                        <i class="bi bi-person{{ request()->is('user/profil*') ? '-fill' : '' }} font-size-22"></i>
                    </span>
                    <span class="{{ request()->is('user/profil*') ? 'text-danger' : 'text-muted' }}">Profil</span>
                </a>
            </div>
        </div>
    </div>
</div>
