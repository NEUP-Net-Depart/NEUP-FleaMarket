@extends('layout.master')

@section('title', "管理")

@section('content')

<div class="card">
<div class="card-header">
<ul class="nav nav-tabs card-header-tabs" role="tab-list">
    @yield('tab-list')
</ul>
</div>

    <div class="tab-content card-body">
            @yield('tab-announcement')
            @yield('tab-classify')
            @yield('tab-report')
            @yield('tab-userlist')
            @yield('tab-translist')
	</div>
</div>
<script>
        // WYSIWYG Editor
        $("textarea#content").froalaEditor({
            imageUploadParam: 'source',
            imageUploadParams: {
            key: "7e945496f2de8cbc710ecca702062e9b",
                format: "flea-mart"
            },
            imageUploadURL: 'https://flimg.neupioneer.com/api/1/upload',
            requestWithCORS: true,
            pluginsEnabled: ['image', 'link', 'colors', 'emoticons',
                        'fontSize', 'fontFamily', 'fullscreen'],
			toolbarButtonsMD: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
				'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
			toolbarButtonsSM: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
				'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
			toolbarButtonsXS: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'align', 'quote', '-',
				'insertImage', '|', 'emoticons', 'help', 'fullscreen', '|', 'undo', 'redo'],
			height: 300
        });
		$('a[href="https://www.froala.com/wysiwyg-editor?k=u"]').wrap("<div hidden='hidden'></div>");
</script>
@endsection

