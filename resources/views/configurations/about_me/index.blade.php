@extends('layouts.app')

@section('toolbar')
    <div class="toolbar p-4 pb-0">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-5 mb-3 mb-lg-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/" class="">Home</a></li>
                            <li class="breadcrumb-item active">
                                <a href="#" class="">Advance</a>
                            </li>
                            <li class="breadcrumb-item active">
                                About us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">
            <div class="row">
                <form class="card" id="forminput" method="POST" enctype="multipart/form-data"
                    action="{{ route('about-us.post') }}">
                    <div class="card-header w-100">
                        About us
                    </div>
                    <div class="card-body position-relative">
                        @csrf
                        <textarea name="content" class="d-none">{!! $content !!}</textarea>
                        <div class="w-100" id="quill-container">
                            <div id="editor"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toolbarOptions = [
                [{
                    'font': []
                }],
                [{
                    'size': ['small', false, 'large', 'huge']
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'align': []
                }],
                ['link', 'image']
            ];

            // Initialize quill js
            const container = document.getElementById('editor');
            const editor = new Quill(container, {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            editor.root.innerHTML = `{!! $content !!}`;

            // listen on submit event
            const formElement = document.getElementById('forminput');
            const textareaElement = document.querySelector('textarea[name="content"]');
            formElement.addEventListener('submit', function(e) {
                const content = editor.root.innerHTML;
                textareaElement.value = content;
            });
        });
    </script>
@endpush

@push('head')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor {
            height: 350px;
        }
    </style>
@endpush
