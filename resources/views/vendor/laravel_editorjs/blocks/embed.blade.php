<div class="article-enlil-editor-embed">
    <iframe src="{{$data['embed']}}" style="width:100%; height: 600px" scrolling="no" frameborder="no"></iframe>
    @if (!empty($data['caption']))
        <footer class="article-embed-caption">
            {{$data['caption']}}
        </footer>
    @endif
</div>
