<?php include resource_path('views/includes/header.php'); ?>
<style>
   
</style>
<div class="bg_blue full_viewport">
    <div class="container pt-5 pb-5 text-center">
        <h4><span class="text-orange">CONTACT</span> US</h4>
        <div class="text-grey">
            <p>We love to hear your feedback. How may we assist you?</p>
        </div>
    </div>

    <div class="contact_form_section">
        <div class="overlay">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-sm-9">
                        <form method="post" action="<?= asset('contact') ?>" id="contact_us">
                            <?php if (session()->has('success')) { ?>
                                <div class="text-success"><?php echo Session::get('success'); ?></div>
                            <?php } ?>
                            <?php if (Session::get('message')) { ?>
                                <div class="text-danger"><?= Session::get('message') ?></div>
                            <?php } ?>
                            <div class="row">
                                <?= csrf_field(); ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input name="name" type="text" placeholder="Your Name" class="form-control eb-form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input required="" name="email" type="email" placeholder="Your Email" class="form-control eb-form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Write your message" class="form-control eb-form-control other_reason"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4 ml-auto mr-auto">
                                    <input type="submit" value="Send" class="btn orange btn-block" />
                                </div>

                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5 pb-5 text-center">
        <h4><span class="text-orange">FOLLOW</span> US</h4>
        <div class="text-grey">
            <p>We would love to hear from you. Follow us and get updates on events and promotions.</p>
        </div>
        <ul class="social_media2 justify-content-center">
            <li><a href="https://www.facebook.com/Ebbseys/" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
            <li><a href="https://www.instagram.com/ebbseys/" target="_blank"><i class="fa fa-instagram" target="_blank"></i></a></li> 
        </ul>
    </div>


    <div class="contact_map">
        <div id="map"></div>
        <div id="content">
            <p>2010 Corporate Ridge <br/>Suite # 700 <br/>McLean, Virginia <br/> 22102</p>
        </div>
    </div>

</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<style>
    /*            #contact_us input.error {
                    border:solid 1px red !important;
                }*/
    #contact_us label.error {
        width: auto;
        display: none !important;
        color:red;
        font-size: 16px;
        float:right;
    }
</style>
<script>
    $("#contact_us").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            },
            messages: {
                message: {
                    required: "Complete Address Is Required"
                },
                email: {
                    required: "Complete Address Is Required"
                },
                name: {
                    required: "Complete Address Is Required"
                }
            }
        }
    });
</script>
<script>

    var map, popup, Popup;

    function initMap() {
        definePopupClass();
        // Styles a map in night mode.
        var location = {lat: 38.9116523, lng: -77.2158859};

        var map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 15,

            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: false,

            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#212121"
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#212121"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#757575"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#181818"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#1b1b1b"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#2c2c2c"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#8a8a8a"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#373737"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#3c3c3c"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#4e4e4e"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#000000"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#3d3d3d"
                        }
                    ]
                }
            ]
        });
        
        popup = new Popup(
                new google.maps.LatLng(location),
                document.getElementById('content'));
        popup.setMap(map);
        
        var marker = new google.maps.Marker({position: location, map: map});
//        var contentString = '<div id="google-popup">'+
//            '<p>Styled Google maps pin popup example by Paul Seal on <a target="_blank" href="http://codeshare.co.uk">codeshare.co.uk</a><br /></p>'+
//            '</div>';
//        var infowindow = new google.maps.InfoWindow({
//            content: contentString
//        });
//
//        infowindow.open(map, marker);

        

    }


    /** Defines the Popup class. */
    function definePopupClass() {
        /**
         * A customized popup on the map.
         * @param {!google.maps.LatLng} position
         * @param {!Element} content
         * @constructor
         * @extends {google.maps.OverlayView}
         */
        Popup = function (position, content) {
            this.position = position;

            content.classList.add('popup-bubble-content');

            var pixelOffset = document.createElement('div');
            pixelOffset.classList.add('popup-bubble-anchor');
            pixelOffset.appendChild(content);

            this.anchor = document.createElement('div');
            this.anchor.classList.add('popup-tip-anchor');
            this.anchor.appendChild(pixelOffset);

            // Optionally stop clicks, etc., from bubbling up to the map.
            this.stopEventPropagation();
        };
        // NOTE: google.maps.OverlayView is only defined once the Maps API has
        // loaded. That is why Popup is defined inside initMap().
        Popup.prototype = Object.create(google.maps.OverlayView.prototype);

        /** Called when the popup is added to the map. */
        Popup.prototype.onAdd = function () {
            this.getPanes().floatPane.appendChild(this.anchor);
        };

        /** Called when the popup is removed from the map. */
        Popup.prototype.onRemove = function () {
            if (this.anchor.parentElement) {
                this.anchor.parentElement.removeChild(this.anchor);
            }
        };

        /** Called when the popup needs to draw itself. */
        Popup.prototype.draw = function () {
            var divPosition = this.getProjection().fromLatLngToDivPixel(this.position);
            // Hide the popup when it is far out of view.
            var display =
                    Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
                    'block' :
                    'none';

            if (display === 'block') {
                this.anchor.style.left = divPosition.x + 'px';
                this.anchor.style.top = divPosition.y + 'px';
            }
            if (this.anchor.style.display !== display) {
                this.anchor.style.display = display;
            }
        };

        /** Stops clicks/drags from bubbling up to the map. */
        Popup.prototype.stopEventPropagation = function () {
            var anchor = this.anchor;
            anchor.style.cursor = 'auto';

            ['click', 'dblclick', 'contextmenu', 'wheel', 'mousedown', 'touchstart',
                'pointerdown']
                    .forEach(function (event) {
                        anchor.addEventListener(event, function (e) {
                            e.stopPropagation();
                        });
                    });
        };
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=env('GOOGLE_API_KEY')?>&callback=initMap"
async defer></script>
</body>
</html>
