@extends('layouts.app')

@section('content')

<div class="container">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">

                            <form action="{{ route('buku.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        placeholder="Cari Judul Buku, Pengarang, Penerbit...." name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('buku.create') }}" class="btn btn-success">Tambah Buku</a>
                        </div>
                    </div>
                    </h6>
                    <div class="table-responsive">
                        <table class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $count = 1;
                                @endphp
                                @foreach ($bukus as $key => $buku)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->pengarang }}</td>
                                    <td>{{ $buku->penerbit }}</td>
                                    <td>
                                        <a href="{{ route('buku.edit', $buku->id) }}"
                                            class="btn btn-success btn-sm">Edit</a>
                                        <a href="{{ route('buku.show', $buku->id) }}"
                                            class="btn btn-info btn-sm">Show</a>
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Mau Hapus Buku?')">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection