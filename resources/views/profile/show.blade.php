@extends('layouts.app')

@section('content')
<style>
  body {
    background: linear-gradient(135deg,rgb(17, 0, 165) 0%, #2575fc 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
  }

  .profile-wrapper {
    padding: 3rem 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .profile-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.18);
    padding: 2rem;
    color: #fff;
    width: 100%;
    max-width: 700px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    animation: fadeIn 0.7s ease-in-out;
  }

  .profile-card h5 {
    font-weight: 600;
    margin-bottom: 1rem;
  }

  .profile-info {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
  }

  .profile-info i {
    font-size: 1.4rem;
    color: #ffd700;
  }

  .btn-edit {
    background-color: #ffffff;
    color: #2575fc;
    border: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s;
  }

  .btn-edit:hover {
    background-color: #ffd700;
    color: #000;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<div class="profile-wrapper">
  <div class="profile-card">
    <div class="d-flex align-items-center mb-4">
      <i class="bi bi-person-circle fs-1 me-3"></i>
      <h5 class="mb-0">Profil Pengguna</h5>
    </div>

    <div class="profile-info">
      <i class="bi bi-person-fill"></i>
      <span><strong>Username:</strong> {{ $user->username }}</span>
    </div>

    <div class="profile-info">
      <i class="bi bi-envelope-fill"></i>
      <span><strong>Email:</strong> {{ $user->email }}</span>
    </div>

    <div class="profile-info">
      <i class="bi bi-shield-lock-fill"></i>
      <span><strong>Role:</strong> {{ ucfirst($user->role) }}</span>
    </div>

    <div class="text-end mt-4">
      <a href="{{ route('profile.edit') }}" class="btn-edit">
        <i class="bi bi-pencil-square me-1"></i> Edit Profil
      </a>
    </div>
  </div>
</div>
@endsection
