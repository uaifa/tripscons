<template>
    <div class="review-section" >
        <div class="container" style="margin-bottom: 10px;">
            <div class="row">
                <div class="col-md-9">
                    <div class="review">
                        <div class="control">
                            <div class="review-76">
                                <ul class="list-unstyle list-inline">
                                    <li>
                                        <h3>76 Reviews</h3>
                                    </li>
                                    <li>
                                        <div id="rateYo1"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="Most-recent">
                                <!-- Split button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Most Recent</button>
                                    <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <section class="myScroll">
                            <section class="demo-scrollbars">
                                <div class="test jcf-scrollable">
                                    <div class="reviews-main">
                                        <div class="media">
                                            <a class="media-left" href="#">
                                                <img class="media-object" src="/basic/img/guide-1.jpg"
                                                     alt="Generic placeholder image">
                                            </a>
                                            <div class="media-body">
                                                <ul class="list-unstyle list-inline rating-sec">
                                                    <li>
                                                        <h4 class="media-heading">Pauline C. Mize <span
                                                            class="traveller-text">as a traveller</span></h4>
                                                    </li>
                                                    <li>
                                                        <div class="rateYo2"></div>
                                                    </li>
                                                </ul>
                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
                                                scelerisque ante sollicitudin commodo.Cras sit amet nibh libero, in
                                                gravida nulla. Nulla vel metus scelerisque ante sollicitudin
                                                commodo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="adds-sec-right">
                        <div class="add-sec-1">
                            <div class="table-method">
                                <p>Add here</p>
                            </div>
                        </div>
                    </div>
                    <div class="adds-sec-right">
                        <div class="add-sec-2">
                            <div class="table-method">
                                <p>Add here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReviewsSection"
    }
</script>

<style scoped>

</style>
