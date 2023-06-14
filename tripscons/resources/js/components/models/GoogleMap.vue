<template>
    <div class="modal fade"
         :id="model_id"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <b style=" font-weight: bolder; color: #0dc068; border-bottom: 3px solid #0dc068;">Choose
                            Location</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <vue-google-autocomplete
                                    style="z-index: 99999999 !important;"
                                    ref="address"
                                    :id="map_id+'-vue-google-autocomplete'"
                                    classname="form-control vue-google-text-box"
                                    placeholder="Search Location..."
                                    types="(regions)"
                                    v-on:placechanged="getAddressData"
                                >
                                </vue-google-autocomplete>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-sm-12 col-md-12">

                            <GmapMap style="width: 100%; height: 400px ;" :zoom="15" :center="center"
                                     ref="map">
                                <GmapMarker v-for="(marker, index) in markers"
                                            :key="index"
                                            :position="marker.latLng"
                                            :draggable="true"
                                            @dragend="gMapFunc($event.latLng)"
                                />
                            </GmapMap>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" ref="btnClose" data-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'
    import * as VueGoogleMaps from 'vue2-google-maps'

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyDIyqy08mOTMQa76nMv5AlQCHI_NxBaFEk',
            libraries: 'places',

            // This is required if you use the Autocomplete plugin
            // OR: libraries: 'places,drawing'
            // OR: libraries: 'places,drawing,visualization'
            // (as you require)

            //// If you want to set the version, you can do so:
            // v: '3.26',
        },
    });
    export default {
        name: "GoogleMap",
        props: ['model_id', 'map_id'],
        components: {
            VueGoogleAutocomplete,
        },
        data() {
            return {
                center: {lat: 0, lng: 0},
                markers: [],
                place: null,
            }
        },
        mounted() {
            this.changeLattLong(31.5204, 74.3587);
        },
        methods: {
            gMapFunc(evnt) {
                this.changeLattLong(evnt.lat(), evnt.lng());
            },
            changeLattLong(latt, long) {
                this.markers = _.range(1)
                    .map(m => ({
                        latLng: {
                            lat: latt,
                            lng: long,
                        }
                    }));
                this.center.lat = latt;
                this.center.lng = long;
                var latitudeLongitude = {lat: latt, lng: long};
                var geocoder = new window.google.maps.Geocoder;
                geocoder.geocode({'latLng': latitudeLongitude}, function (results, status) {
                    $('.vue-google-text-box').val(results[0].formatted_address);
                });
                setTimeout(()=>{
                    this.$emit('setLatLng', {
                        lat: latt,
                        lng: long,
                        address: $('.vue-google-text-box').val()
                    });
                },2000);
            },
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.changeLattLong(addressData.latitude, addressData.longitude);
            },
        },
        watch: {},
    }
</script>

<style scoped>

</style>
