<div class="row">
    <div class="col-xl-10 mb-5 mb-xl-0 mx-auto">
        <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-uppercase">Tables</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row tables-content flex-sm-row flex-xs-row flex-column">
                    @foreach($tables as $table)
                    <div class="p-2 col-12 col-sm-3 col-xs-6 order-table" data-path="{{ route('products', ['path' => $table->path]) }}">
                        <div class="position-relative py-12 rounded text-center bg-light cursor-pointer">
                            <div class="d-none">
                                {!! QrCode::size(150)->generate(route('products', ['path' => $table->path,'qr_code' => md5($table->path)])); !!}
                            </div>
                            <span>{{ $table->index }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="table-close">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Close table</h5>
            </div>
            
            <div class="modal-body py-1">
                
            </div>

            <div class="modal-footer py-2">
                <a class="btn btn-success fs-14 submit">Enter</a>
            </div>
        </div>
    </div>
</div>