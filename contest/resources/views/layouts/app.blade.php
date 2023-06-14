<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/favic.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/brands.min.css"
        integrity="sha512-L+sMmtHht2t5phORf0xXFdTC0rSlML1XcraLTrABli/0MMMylsJi3XA23ReVQkZ7jLkOEIMicWGItyK4CAt2Xw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{url('/style.css')}}" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VXDTBDNP96"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-VXDTBDNP96');
    </script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=910708040314966&ev=PageView&noscript=1" alt="none"></noscript>
<script type="text/javascript" async>
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/630e2b7354f06e12d891c8cd/1gbnljf6f';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '910708040314966');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=910708040314966&ev=PageView&noscript=1" alt="none"></noscript>
    <!-- End Meta Pixel Code -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles

    @yield('header')
</head>

<body>
    @include('layouts.app.nav')


    <!-- ============================navbar ends here======================== -->


    <!-- ============================ author detail modal start here======================== -->
    <div class="modal fade" id="authordetail" aria-labelledby="authordetail" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-body">
                    <h2 class="main-title">
                        Please fill out your info
                    </h2>
                    <div class="mt-5">
                        <div class="autor-details">
                            <div class="form-group">
                                <input type="text" id="author" class="form-control">
                                <label for="author">Author name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="title" class="form-control">
                                <label for="title">Title</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="des" class="form-control">
                                <label for="des">Description</label>
                            </div>
                            <div class="d-flex justify-content-between bottom-button">
                                <button class="custom-button"><i class="fa-solid fa-camera"></i>Upload photo
                                    <input type="file">

                                </button>

                                <button class="custom-button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- ============================ author detail modal ends here======================== -->

    {{$slot}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    @livewireScripts
    <!-- bootstrap links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('modalAction', event => {
            $("#" + event.detail.id).modal(event.detail.action)
        })
        window.addEventListener('saveLoginInfo', event => {
            $.each(event.detail, function(index, item) {
                localStorage.setItem(index, item);
            })
        })
        window.addEventListener('removeLocalStorage', event => {
            $.each(event.detail.items, function(index, item) {
                console.log(item)
                localStorage.removeItem(item);
            })
        })
        window.addEventListener('alert', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                confirmButtonText: event.detail.confirmButtonText
            })
        })
    </script>

    <script>
        $('#result-filter').on('change', function(e) {
            Livewire.emit('filterResults', $('#result-filter').val())
        })
    </script>

    <script>
        function copyLink(id) {
            // Get the text field
            var copyText = document.getElementById(id);

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            Swal.fire({
                title: "Link Copied",
                text: "The link has been copied now you can past it anywhere to share with your friends",
                icon: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor : '#0a6cac'
            })
        }
    </script>

</body>

</html>
