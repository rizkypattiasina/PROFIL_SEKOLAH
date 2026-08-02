from pathlib import Path

blade = r'''@extends('layouts.backend.app')

@section('title', 'Profil Sekolah')

@section('content')
    {{-- Summernote Lite: editor teks tanpa konflik dengan versi Bootstrap template --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-lite.min.css"
    >

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif ($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
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
                        <h2 class="content-header-title float-left mb-0">
                            Profil Sekolah
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
                                <h4 class="card-title">Profil Sekolah</h4>
                            </div>

                            <div class="card-body">
                                @if (is_null($profile))
                                    <form
                                        action="{{ route('backend-profile-sekolah.store') }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="profile-school-form"
                                    >
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="title-create">
                                                        Judul <span class="text-danger">*</span>
                                                    </label>

                                                    <input
                                                        id="title-create"
                                                        type="text"
                                                        name="title"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        value="{{ old('title') }}"
                                                        placeholder="Contoh: Profil SMA Plus Muhammadiyah Merauke"
                                                        required
                                                    >

                                                    @error('title')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="image-create">
                                                        Gambar <span class="text-danger">*</span>
                                                    </label>

                                                    <input
                                                        id="image-create"
                                                        type="file"
                                                        name="image"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                        required
                                                    >

                                                    <small class="form-text text-muted">
                                                        Format JPG, JPEG, PNG, atau WEBP.
                                                    </small>

                                                    @error('image')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="content-create">
                                                        Isi profil <span class="text-danger">*</span>
                                                    </label>

                                                    <textarea
                                                        id="content-create"
                                                        name="content"
                                                        class="form-control summernote-editor @error('content') is-invalid @enderror"
                                                        rows="12"
                                                    >{{ old('content') }}</textarea>

                                                    @error('content')
                                                        <div class="invalid-feedback d-block">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror

                                                    <small class="form-text text-muted">
                                                        Gunakan toolbar untuk mengatur font, ukuran, warna, tebal,
                                                        miring, paragraf, daftar, tabel, tautan, dan gambar.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit">
                                            Tambah
                                        </button>

                                        <a
                                            href="{{ route('backend-profile-sekolah.index') }}"
                                            class="btn btn-warning"
                                        >
                                            Batal
                                        </a>
                                    </form>
                                @else
                                    <form
                                        action="{{ route('backend-profile-sekolah.update', $profile->id) }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="profile-school-form"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="title-update">
                                                        Judul <span class="text-danger">*</span>
                                                    </label>

                                                    <input
                                                        id="title-update"
                                                        type="text"
                                                        name="title"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        value="{{ old('title', $profile->title) }}"
                                                        placeholder="Contoh: Profil SMA Plus Muhammadiyah Merauke"
                                                        required
                                                    >

                                                    @error('title')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="image-update">Gambar</label>

                                                    <input
                                                        id="image-update"
                                                        type="file"
                                                        name="image"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        accept=".jpg,.jpeg,.png,.webp"
                                                    >

                                                    <small class="form-text text-muted">
                                                        Kosongkan jika gambar tidak ingin diubah.
                                                    </small>

                                                    @error('image')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            @if (!empty($profile->image))
                                                <div class="col-12 mb-1">
                                                    <p class="mb-50">Gambar saat ini:</p>
                                                    <img
                                                        src="{{ asset('storage/images/profile/' . $profile->image) }}"
                                                        alt="Gambar profil sekolah"
                                                        class="img-thumbnail"
                                                        style="max-width: 220px; max-height: 160px; object-fit: cover;"
                                                        onerror="this.style.display='none'"
                                                    >
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="content-update">
                                                        Isi profil <span class="text-danger">*</span>
                                                    </label>

                                                    <textarea
                                                        id="content-update"
                                                        name="content"
                                                        class="form-control summernote-editor @error('content') is-invalid @enderror"
                                                        rows="12"
                                                    >{{ old('content', $profile->content) }}</textarea>

                                                    @error('content')
                                                        <div class="invalid-feedback d-block">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror

                                                    <small class="form-text text-muted">
                                                        Gunakan toolbar untuk mengatur font, ukuran, warna, tebal,
                                                        miring, paragraf, daftar, tabel, tautan, dan gambar.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit">
                                            Perbarui
                                        </button>

                                        <a
                                            href="{{ route('backend-profile-sekolah.index') }}"
                                            class="btn btn-warning"
                                        >
                                            Batal
                                        </a>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <style>
        .note-editor.note-frame {
            border: 1px solid #d8d6de;
            border-radius: 0.357rem;
        }

        .note-editor.note-frame .note-editing-area .note-editable {
            min-height: 350px;
            background-color: #fff;
            color: #2c2c2c;
            font-size: 15px;
            line-height: 1.7;
        }

        .note-editor .note-toolbar {
            background-color: #f8f8f8;
            border-bottom: 1px solid #d8d6de;
        }

        .note-editor.fullscreen {
            z-index: 1050;
        }

        .note-status-output:empty {
            display: none;
        }
    </style>

    <script>
        window.addEventListener('load', function () {
            function initializeSummernote() {
                if (typeof window.jQuery === 'undefined') {
                    console.error('jQuery belum tersedia. Summernote tidak dapat dijalankan.');
                    return;
                }

                if (typeof window.jQuery.fn.summernote === 'undefined') {
                    console.error('Library Summernote gagal dimuat.');
                    return;
                }

                window.jQuery('.summernote-editor').summernote({
                    height: 350,
                    minHeight: 250,
                    maxHeight: 700,
                    focus: false,
                    placeholder: 'Tuliskan profil sekolah di sini...',
                    fontNames: [
                        'Arial',
                        'Arial Black',
                        'Calibri',
                        'Comic Sans MS',
                        'Courier New',
                        'Georgia',
                        'Helvetica',
                        'Impact',
                        'Tahoma',
                        'Times New Roman',
                        'Trebuchet MS',
                        'Verdana'
                    ],
                    fontNamesIgnoreCheck: [
                        'Calibri',
                        'Helvetica'
                    ],
                    fontSizes: [
                        '8',
                        '9',
                        '10',
                        '11',
                        '12',
                        '14',
                        '16',
                        '18',
                        '20',
                        '22',
                        '24',
                        '28',
                        '30',
                        '32',
                        '36',
                        '40',
                        '48',
                        '56',
                        '64',
                        '72'
                    ],
                    toolbar: [
                        ['style', ['style']],
                        ['font', [
                            'fontname',
                            'fontsize',
                            'fontsizeunit',
                            'bold',
                            'italic',
                            'underline',
                            'strikethrough',
                            'superscript',
                            'subscript',
                            'clear'
                        ]],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                        ]
                    },
                    callbacks: {
                        onImageUploadError: function () {
                            alert('Gambar gagal dimasukkan ke editor.');
                        }
                    }
                });

                window.jQuery('.profile-school-form').on('submit', function (event) {
                    var editor = window.jQuery(this).find('.summernote-editor');
                    var content = editor.summernote('code').trim();

                    if (
                        content === '' ||
                        content === '<p><br></p>' ||
                        content === '<br>'
                    ) {
                        event.preventDefault();
                        alert('Isi profil sekolah wajib diisi.');
                        editor.summernote('focus');
                    }
                });
            }

            if (
                typeof window.jQuery !== 'undefined' &&
                typeof window.jQuery.fn.summernote !== 'undefined'
            ) {
                initializeSummernote();
                return;
            }

            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-lite.min.js';
            script.onload = initializeSummernote;
            script.onerror = function () {
                console.error('Summernote gagal diunduh dari CDN.');
            };

            document.body.appendChild(script);
        });
    </script>
@endsection
'''

path = Path("/mnt/data/profile-sekolah-editor.blade.php")
path.write_text(blade, encoding="utf-8")
print(path, path.stat().st_size)
