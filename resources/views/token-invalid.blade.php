@extends('layouts.error')

@section('title', 'Token Tidak Valid')

@section('content')
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 1rem; min-width:100%">
        <div style="
            background-color: #fff;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            border-radius: 0.5rem;
            padding: 2rem;
            max-width: 35%;
            width: 100%;
            text-align: center;
            ">
            <h1 style="
                font-size: 5rem;
                font-weight: 700;
                color: #dc2626;
                margin: 0 0 1rem 0;
                line-height: 1;
                ">
                !
            </h1>
            <p style="
                font-size: 1.25rem;
                color: #374151;
                margin-bottom: 1.5rem;
                ">
                Token yang Anda gunakan tidak ditemukan atau sudah kadaluarsa.
            </p>
            <a href="https://wa.me/62881036043991" style="
                display: inline-block;
                padding: 0.5rem 1.5rem;
                background-color: #2563eb;
                color: white;
                border-radius: 0.375rem;
                font-weight: 600;
                text-decoration: none;
                transition: background-color 0.3s ease;
                ">
                Hubungi Admin
            </a>
        </div>
    </div>
@endsection
