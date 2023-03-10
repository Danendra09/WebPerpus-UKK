@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Detail Buku</h1>
    <div class="row">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ Storage::url($buku->image) }}" alt="{{ $buku->judul }}" class="card-img-top"
                        style="max-width: 55%; width: auto;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Judul : </strong>{{ $buku->judul }}</h5>
                        <p class="card-text"><strong>Pengarang : </strong>{{ $buku->pengarang }}</p>
                        <p class="card-text"><strong>Penerbit : </strong>{{ $buku->penerbit }}</p>
                        <p class="card-text"><strong>Deskripsi: </strong></br>{{ $buku->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection