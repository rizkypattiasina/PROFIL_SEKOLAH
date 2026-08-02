@extends('layouts.backend.app')

@section('title')
    Tambah Berita
@endsection

@section('content')

{{-- Summernote CSS --}}
<link
    href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css"
    rel="stylesheet"
>

<style>
    .note-editor.note-frame {
        border: 1px solid #d8d6de;
        border-radius: 0.357rem;
    }

    .note-editable {
        min-height: 400px;
        background: #ffffff;
    }

    .preview-thumbnail {
        display: none;
        width: 100%;
        max-width: 350px;
        height: 200px;
        margin-top: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        object-fit: cover;
    }
</style>

@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <div class="alert-body">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    </div>
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        <div class="alert-body">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    </div>
@endif

<div class="content-wrapper container-xxl p-0">

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2>Berita</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header header-bottom">
                        <h4>Tambah Berita</h4>
                    </div>

                    <div class="card-body">

                        <form
                            action="{{ route('backend-berita.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="form-berita"
                        >
                            @csrf

                            <div class="row">

                                {{-- Judul berita --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">
                                            Judul Berita
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            name="title"
                                            value="{{ old('title') }}"
                                            placeholder="Masukkan judul berita"
                                            required
                                        >

                                        @error('title')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Sampul berita --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="thumbnail">
                                            Sampul Berita
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="file"
                                            id="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            name="thumbnail"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                        >

                                        <small class="text-muted">
                                            Format: JPG, JPEG, PNG, atau WebP.
                                            Gunakan gambar landscape.
                                        </small>

                                        <img
                                            id="thumbnail-preview"
                                            class="preview-thumbnail"
                                            alt="Preview sampul berita"
                                        >

                                        @error('thumbnail')
                                            <div class="invalid-feedback d-block">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kategori_id">
                                            Kategori
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            id="kategori_id"
                                            name="kategori_id"
                                            class="form-control @error('kategori_id') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">-- Pilih Kategori --</option>

                                            @foreach ($kategori as $kategoris)
                                                <option
                                                    value="{{ $kategoris->id }}"
                                                    {{ old('kategori_id') == $kategoris->id ? 'selected' : '' }}
                                                >
                                                    {{ $kategoris->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('kategori_id')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Isi berita --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="summernote">
                                            Isi Berita
                                            <span class="text-danger">*</span>
                                        </label>

                                        <textarea
                                            id="summernote"
                                            name="content"
                                            class="form-control @error('content') is-invalid @enderror"
                                        >{{ old('content') }}</textarea>

                                        @error('content')
                                            <div class="invalid-feedback d-block">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary" type="submit">
                                Simpan Berita
                            </button>

                            <a
                                href="{{ route('backend-berita.index') }}"
                                class="btn btn-warning"
                            >
                                Batal
                            </a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Summernote JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function () {
        const summernote = $('#summernote');

        summernote.summernote({
            height: 450,
            minHeight: 300,
            maxHeight: null,
            focus: false,
            placeholder: 'Tulis isi berita di sini...',

            fontNames: [
                'Arial',
                'Arial Black',
                'Calibri',
                'Courier New',
                'Georgia',
                'Helvetica',
                'Tahoma',
                'Times New Roman',
                'Trebuchet MS',
                'Verdana'
            ],

            fontNamesIgnoreCheck: [
                'Arial',
                'Calibri',
                'Helvetica',
                'Times New Roman'
            ],

            toolbar: [
                ['history', ['undo', 'redo']],
                ['style', ['style']],
                ['font', ['fontname', 'fontsize', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['color', ['color', 'highlight']],
                ['paragraph', ['ul', 'ol', 'paragraph']],
                ['alignment', ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],

            callbacks: {
                onImageUpload: function (files) {
                    Array.from(files).forEach(function (file) {
                        uploadGambarKonten(file);
                    });
                },

                onMediaDelete: function (target) {
                    const imageUrl = target.attr('src');

                    if (imageUrl) {
                        hapusGambarKonten(imageUrl);
                    }
                }
            }
        });

        function uploadGambarKonten(file) {
            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Gambar harus berformat JPG, JPEG, PNG, atau WebP.');
                return;
            }

            const maxSize = 5 * 1024 * 1024;

            if (file.size > maxSize) {
                alert('Ukuran gambar maksimal 5 MB.');
                return;
            }

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route('backend-berita.upload-image') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    summernote.summernote('disable');
                },

                success: function (response) {
                    summernote.summernote('enable');

                    if (response.url) {
                        summernote.summernote(
                            'insertImage',
                            response.url,
                            function ($image) {
                                $image.attr('alt', 'Gambar berita');
                                $image.addClass('img-fluid');
                                $image.css({
                                    maxWidth: '100%',
                                    height: 'auto'
                                });
                            }
                        );
                    }
                },

                error: function (xhr) {
                    summernote.summernote('enable');

                    let message = 'Gambar gagal diunggah.';

                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {
                        message = xhr.responseJSON.message;
                    }

                    alert(message);
                }
            });
        }

        function hapusGambarKonten(imageUrl) {
            $.ajax({
                url: '{{ route('backend-berita.delete-image') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image_url: imageUrl
                }
            });
        }

        $('#thumbnail').on('change', function (event) {
            const file = event.target.files[0];
            const preview = $('#thumbnail-preview');

            if (!file) {
                preview.hide().attr('src', '');
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.attr('src', e.target.result).show();
            };

            reader.readAsDataURL(file);
        });

        $('#form-berita').on('submit', function (event) {
            const content = summernote.summernote('code');
            const plainText = $('<div>').html(content).text().trim();

            if (plainText === '' && !content.includes('<img')) {
                event.preventDefault();
                alert('Isi berita wajib diisi.');
                summernote.summernote('focus');
            }
        });
    });
</script>

@endsection