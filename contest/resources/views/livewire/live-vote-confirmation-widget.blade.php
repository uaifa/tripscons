<div wire:ignore.self class="modal fade" id="vote-confirmation{{$entry->id}}" aria-labelledby="signup" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">


            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body">
                <h2 class="main-title">
                    Are you sure you want to vote for this?
                </h2>
                <div class="d-flex justify-content-around my-4">
                    <button wire:click='vote' class="custom-button">
                        <i class="fas fa-check"></i>
                        Yes
                    </button>
                    <button wire:click='close' class="custom-button">
                        <i class="fa fa-times"></i>
                        No
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
