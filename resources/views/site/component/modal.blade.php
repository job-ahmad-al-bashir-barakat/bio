<div id="{{ $id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="myModalLabel">{{ $title }}</h5>
            </div>
            <div class="modal-body {{ $bodyClass or '' }}" {{ $bodyAttr or '' }}>
               {{ $slot }}
            </div>
            <div class="modal-footer {{ $footerClass or '' }}" {{ $footerAttr }}>
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
