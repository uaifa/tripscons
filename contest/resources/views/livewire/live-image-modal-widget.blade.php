<div wire:ignore.self class="modal fade" id="imgmodal{{$entry->id}}" aria-labelledby="imgmodal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body">
                <h2 class="main-title">
                    Beautiful Lake
                </h2>
                <div class="my-4">
                    <div class="modal-buttons">
                        <button class="custom-button w-100">
                            {{$entry->votes}} Votes
                        </button>
                        
                    </div>
                </div>
                <div class="image-modal-wrapper">
                    <img src="{{route('stream', ['filePath' => $entry->media_path])}}" alt="" srcset="">
                </div>
            </div>

        </div>
    </div>
</div>
