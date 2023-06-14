<div wire:ignore.self class="modal fade" id="signup" aria-labelledby="signup" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body">
                <h2 class="main-title ">
                    Please signup using
                </h2>
                <div class="d-flex justify-content-around my-4">
                    <a href="{{ url('auth/facebook') }}" class="">

                            <img src="/facebook.png" width="40px"  alt="facebook">
                            

                    </a>
                    <a href="{{ url('auth/google') }}" class="">

                        <img src="/google.png" width="40px" alt="google">
                            

                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
