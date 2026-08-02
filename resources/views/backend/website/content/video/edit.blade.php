@extends('layouts.backend.app')

@section('title', 'Edit Video')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-body">
                <strong>{{ Session::get('success') }}</strong>

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Tutup"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-body">
                <strong>{{ Session::get('error') }}</strong>

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Tutup"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="content-wrapper container-xxl p-0">

        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title">
                            Edit Video
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <div class="col-12">

                    <section>
                        <div class="card">

                            <div class="card-header header-bottom">
                                <h4 class="card-title">
                                    Form Edit Video
                                </h4>
                            </div>

                            <div class="card-body">

                                <form
                                    action="{{ route('backend-video.update', $video->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        {{-- URL VIDEO --}}
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">

                                                <label for="url">
                                                    URL Video YouTube
                                                </label>

                                                <input
                                                    type="url"
                                                    id="url"
                                                    name="url"
                                                    class="form-control @error('url') is-invalid @enderror"
                                                    value="{{ old('url', $video->url) }}"
                                                    placeholder="Contoh: https://www.youtube.com/watch?v=xxxx"
                                                >

                                                <small class="text-danger">
                                                    Salin dan tempel URL video dari YouTube.
                                                </small>

                                                @error('url')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        {{-- STATUS --}}
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">

                                                <label for="is_active">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select
                                                    id="is_active"
                                                    name="is_active"
                                                    class="form-control @error('is_active') is-invalid @enderror"
                                                    required
                                                >
                                                    <option value="">
                                                        -- Pilih Status --
                                                    </option>

                                                    <option
                                                        value="0"
                                                        {{ old('is_active', $video->is_active) == '0' ? 'selected' : '' }}
                                                    >
                                                        Aktif
                                                    </option>

                                                    <option
                                                        value="1"
                                                        {{ old('is_active', $video->is_active) == '1' ? 'selected' : '' }}
                                                    >
                                                        Tidak Aktif
                                                    </option>
                                                </select>

                                                @error('is_active')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        {{-- JUDUL --}}
                                        <div class="col-12">
                                            <div class="form-group">

                                                <label for="title">
                                                    Judul Video
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input
                                                    type="text"
                                                    id="title"
                                                    name="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    value="{{ old('title', $video->title) }}"
                                                    placeholder="Masukkan judul video"
                                                    required
                                                >

                                                @error('title')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        {{-- DESKRIPSI --}}
                                        <div class="col-12">
                                            <div class="form-group">

                                                <label for="desc">
                                                    Deskripsi
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea
                                                    id="desc"
                                                    name="desc"
                                                    class="form-control @error('desc') is-invalid @enderror"
                                                    rows="6"
                                                    placeholder="Masukkan deskripsi video"
                                                    required
                                                >{{ old('desc', $video->desc) }}</textarea>

                                                @error('desc')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                    <div class="mt-2">

                                        <button
                                            class="btn btn-primary"
                                            type="submit"
                                        >
                                            <i data-feather="save"></i>
                                            Update Video
                                        </button>

                                        <a
                                            href="{{ route('backend-video.index') }}"
                                            class="btn btn-warning"
                                        >
                                            <i data-feather="arrow-left"></i>
                                            Batal
                                        </a>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

    </div>

@endsection