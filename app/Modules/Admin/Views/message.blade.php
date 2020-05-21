<div id="message-wrapper">
    @if(session('success_message'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            <i class="fa fa-check"></i>&nbsp;
            {{ session('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error_message'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            <i class="fa fa-times"></i>&nbsp;
            {{ session('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning_message'))
        <div class="alert alert-warning alert-dismissible show" role="alert">
            <i class="fa fa-info"></i>&nbsp;
            {{ session('warning_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>