<template>
    <div class="modal fade " :id="model_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true"
    style="z-index: 99999;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ref="btnClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="upload-file" @click="$refs.fileupload.click()">
                        <h4><i class="fa fa-upload" aria-hidden="true"></i> Select Image</h4>
                    </div>

                    <input
                        style="display:none;"
                        ref="fileupload"
                        type="file"
                        name="image"
                        accept="image/*"
                        @change="setImage"
                    />

                    <vue-cropper
                        v-if="imgSrc"
                        ref="cropper"
                        :src="imgSrc"
                        alt="Source Image"
                        :cropmove="cropImage"
                    >
                    </vue-cropper>

                    <div class="cropped-image">
                        <img
                            style="margin-top:10px;float: left; width: 100%;object-fit: cover;"
                            v-if="cropImg"
                            :src="cropImg"
                            alt="Cropped Image"
                        />
                    </div>
                    <!--                    <img src="https://unsplash.it/500/500/?random" alt="" id="cropper">-->

                    <!--                    <img src="/basic/img/test.jpg" id="image" style="width:500px;height:500px" alt="">-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-model" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="uploadImage">Save Crop</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>

    // Local
    import VueCropper from 'vue-cropperjs';
    import 'cropperjs/dist/cropper.css';

    export default {
        name: 'ImageCrop',
        props: ['model_id'],
        components: {
            VueCropper
        },
        data() {
            return {
                imgSrc: '',
                cropImg: ''
            }
        },
        created() {

        },
        methods: {
            cropImage() {
                // get image data for post processing, e.g. upload or setting image src
                this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
            },
            setImage(e) {
                const file = e.target.files[0];
                if (file.type.indexOf('image/') === -1) {
                    alert('Please select an image file');
                    return;
                }
                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.imgSrc = event.target.result;
                        this.cropImg = event.target.result;
                        // rebuild cropperjs with the updated source
                        this.$refs.cropper.replace(event.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Sorry, FileReader API not supported');
                }
            },
            uploadImage() {
                if (this.cropImg) {
                    this.$emit('cropped_file', this.cropImg);
                    this.$refs.btnClose.click();
                    this.imgSrc = '';
                    this.cropImg = '';
                    this.$refs.fileupload.value = null;
                }
            }
        },
    };
</script>


<style scoped>
    #upload-file {
        margin: 0 0 10px 0;
        border: 1px #65c9a3 solid;
        border-radius: 29px;
        text-align: center;
        cursor: pointer;
        background-image: url("/basic/img/after-image.png");
    }

    #upload-file h4 {
        padding: 10px;
    }

    .cropper-container.cropper-bg {
        width: 452px;
        height: 301px;
    }

</style>
