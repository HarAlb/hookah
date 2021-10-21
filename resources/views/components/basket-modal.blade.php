<div class="modal fade" tabindex="-1" id="products-basket">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-2 pt-2">
                <h5 class="modal-title">Basket</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body p-2 scroll-y mh-sm-auto px-0 mh-250px">
                <ul class="nav rounded-pill flex-sm-center bg-light overflow-auto p-2 mb-2 flex-stack" id="nav-tab-basket" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link btn btn-active-white btn-color-gray-500 btn-active-color-gray-700 py-2 px-4 fs-6 fw-bold active" data-bs-toggle="tab" href="#basket">Basket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-active-white btn-color-gray-500 btn-active-color-gray-700 py-2 px-4 fs-6 fw-bold" data-bs-toggle="tab" href="#orders">Orders</a>
                    </li>
                </ul>

                <div class="tab-content px-0">
                    <div class="tab-pane fade active show px-6" id="basket" role="tabpanel" aria-labelledby="order-tab">
                        <img src="{{ asset('images/spinner-loading.svg') }}" alt="loading animation" class="w-100px m-auto">
                        
                    </div>
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="order-tab">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="px-4 py-2 bg-success rounded text-white price-all invisible"></span>
                <button type="button" class="btn btn-primary btn-sm order">Order</button>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>