<div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mx-2 my-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            @foreach ($errors->all() as $error)
                <script>
                    //message with toastr
                    @if(session()-> has('success'))
                    toastr.success('{{ session('success') }}', 'BERHASIL!');
                    @elseif(session()-> has('error'))
                    toastr.error('{{ session('error') }}', 'GAGAL!');
                    @endif
                </script>
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
</div>
<div>
    @if(session() -> has('success'))
        <div class="alert alert-primary alert-dismissible fade show mx-2 my-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{Session::get( 'success' )}}</strong>
        </div>

    @elseif(session() -> has('error'))

        <div class="alert alert-primary alert-dismissible fade show mx-2 my-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{Session::get( 'error' )}}</strong>
        </div>

    @endif
</div>
