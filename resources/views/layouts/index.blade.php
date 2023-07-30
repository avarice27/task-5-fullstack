@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Artikel</h1>
        
        <!-- Form Pencarian -->
        <form action="{{ route('articles.search') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="q" class="form-control" placeholder="Cari artikel...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>
        
        @foreach ($articles as $article)
            <!-- Tampilkan daftar artikel seperti sebelumnya -->
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
