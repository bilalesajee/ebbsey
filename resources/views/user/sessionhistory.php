<?php include resource_path('views/includes/header.php'); ?>
<div class="bg_blue full_viewport">
    <div class="session_map">
        <div class="d-lg-none d-block">
            <img src="<?= asset('userassets/images/spacer1.png'); ?>" class="spacer" alt="" />
        </div>
        <div id="map"></div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-6 col-12">
        </div>
        <div class="col-md-6 col-12">
            <div class="trainer_details_wrap">
                <div class="trainer-header d-flex">
                    <div class="left_side">
                        <?php if ($user_sessions->end_date < date('Y-m-d H:i:s')) { ?>
                            <h1>Session History</h1>
                        <?php } else { ?>
                            <h1>Session Detail</h1>
                        <?php } ?>
                    </div>
                </div>
                <div class="class_trainer_info align-items-center d-flex">
                    <?php
                    if ($user_data->user_type == 'user') {
                        $img_path = isset($user_sessions->appointmentTrainer->image) ? asset('public/images/' . $user_sessions->appointmentTrainer->image) : asset('public/images/users/default.jpg');
                        $full_name = $user_sessions->appointmentTrainer->first_name . ' ' . $user_sessions->appointmentTrainer->last_name;
                    } else {
                        $img_path = isset($user_sessions->appointmentClient->image) ? asset('public/images/' . $user_sessions->appointmentClient->image) : asset('public/images/users/default.jpg');
                        $full_name = $user_sessions->appointmentClient->first_name . ' ' . $user_sessions->appointmentClient->last_name;
                    }
                    ?>
                    <div class="profile_info d-flex align-items-center">
                        <div class="image">
                            <div class="img" style="background-image: url(<?= $img_path; ?>);"></div>
                        </div>
                        <div class="info">
                            <!--<div class="type">Trainer</div>-->
                            <div class="name"><?= $full_name; ?></div>
                        </div>
                    </div>

                </div>
                <div class="trainer_details_list mt-4">
                    <h6 style="color: #8b8893"><strong>OTHER DETAILS</strong></h6>                    
                    <div>
                        <div class="left-side"> Session Type </div>
                        <div class="right-side"> 
                            <?php if (isset($user_sessions->number_of_passes) && $user_sessions->number_of_passes == 1) { ?>

                                Individual 
                            <?php } elseif (isset($user_sessions->number_of_passes) && $user_sessions->number_of_passes == 2) { ?>
                                Couple
                            <?php } elseif (isset($user_sessions->number_of_passes) && $user_sessions->number_of_passes > 2) { ?> 
                                Group
                            <?php } else { ?>
                                N/A
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <div class="left-side"> Time </div>
                        <div class="right-side"> <?= $user_sessions->start_time ?> to <?= $user_sessions->end_time ?> </div>
                    </div>
                    <?php if ($current_user->user_type == "user" || $user_sessions->status == "accepted" || $user_sessions->status == "completed") { ?>
                        <div>
                            <div class="left-side"> Distance </div>
                            <div class="right-side"> <?= $user_sessions->distance ? $user_sessions->distance . ' Miles' : 'Unknown' ?>  </div>
                        </div>
                        <div>
                            <div class="left-side"> Session Location </div>
                            <div class="right-side"> <?= $user_sessions->client_location ?> </div>
                        </div>
                    <?php } ?>
                    <div>
                        <div class="left-side"> Status </div>
                        <div class="right-side"> <?= ucfirst($user_sessions->status) ?> </div>
                    </div>
                </div>
                <div class="trainer_details_list">
                    <h6 style="color: #8b8893"><strong>PASSES</strong></h6>
                    <div>
                        <div class="left-side"> Used Passes </div>
                        <div class="right-side text-orange"> <?= $user_sessions->number_of_passes ?> </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    var lat = lng = zoom = '';
    $(document).ready(function () {
        function scrollSticky() {
            var window_width = window.innerWidth;
            var $sticky = $('.session_map');
            var $stickyrStopper = $('.footer');
            if (!!$sticky.offset()) { // make sure ".sticky" element exists
                if (window_width > 767) {
                    var generalSidebarHeight = $sticky.innerHeight();
                    var stickyTop = $sticky.offset().top;
                    var stickOffset = 0;
                    var stickyStopperPosition = $stickyrStopper.offset().top;
                    var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
                    var diff = stopPoint + stickOffset;

                    $(window).scroll(function () { // scroll event
                        var windowTop = $(window).scrollTop(); // returns number
                        if (stopPoint < windowTop) {
                            $sticky.css({position: 'absolute', top: diff});
                        } else if (stickyTop < windowTop + stickOffset) {
                            $sticky.css({position: 'fixed', top: stickOffset});
                        } else {
                            $sticky.css({position: 'absolute', top: 'initial'});
                        }
                    });
                }
            }
        }
        scrollSticky();
        $(window).resize(function () {
            scrollSticky();
        });
    });
<?php
$is_display_map = false;
if ($current_user->user_type == "user") {
    if ($user_sessions->status == "accepted") {
        $is_display_map = true;
    }
} else if ($current_user->user_type == "trainer") {
    if ($user_sessions->status == "accepted" || $user_sessions->status == "completed") {
        $is_display_map = true;
    }
}
if ($is_display_map) {
    ?>

        var markers = [
            {
                "title": '<?= $user_sessions->trainer_location ?>',
                "lat": '<?= $user_sessions->trainer_lat ?>',
                "lng": '<?= $user_sessions->trainer_lng ?>',
                "description": '<?= $user_sessions->trainer_location ?>'
            },
            {
                "title": '<?= $user_sessions->client_location ?>',
                "lat": '<?= $user_sessions->client_lat ?>',
                "lng": '<?= $user_sessions->client_lng ?>',
                "description": '<?= $user_sessions->client_location ?>'
            }
        ];
        window.onload = function () {
            var mapOptions = {
                center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: false,
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,

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
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            var iconBase = '<?= asset('userassets/images/icons') ?>/';
            var icons = {
                '0': {
                    icon: iconBase + 'starting_from.png'
                },
                '1': {
                    icon: iconBase + 'marker.png'
                }
            };

            var lat_lng = new Array();
            var latlngbounds = new google.maps.LatLngBounds();

            for (i = 0; i < markers.length; i++) {
                var data = markers[i];

                var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                lat_lng.push(myLatlng);

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    icon: icons[i].icon,
                    map: map,
                    title: data.title
                });

                latlngbounds.extend(marker.position);
                var infowindow = new google.maps.InfoWindow({
                    content: data.title
                });
                marker.addListener('click', function () {
                    infowindow.open(map, marker);
                });

            }

            map.setCenter(latlngbounds.getCenter());
            map.fitBounds(latlngbounds);

            //***********ROUTING****************//

            //Initialize the Path Array
            var path = new google.maps.MVCArray();

            //Initialize the Direction Service
            var service = new google.maps.DirectionsService();

            //Set the Path Stroke Color
            var poly = new google.maps.Polyline({map: map, strokeColor: '#f26824'});

            //Loop and Draw Path Route between the Points on MAP
            for (var i = 0; i < lat_lng.length; i++) {
                if ((i + 1) < lat_lng.length) {
                    var src = lat_lng[i];
                    var des = lat_lng[i + 1];
                    path.push(src);
                    poly.setPath(path);
                    service.route({
                        origin: src,
                        destination: des,
                        travelMode: google.maps.DirectionsTravelMode.DRIVING
                    }, function (result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                                path.push(result.routes[0].overview_path[i]);
                            }
                        }
                    });
                }
            }
        }
        //END HERE
        function initMap() {
            // Styles a map in night mode.
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 40.674, lng: -73.945},
                zoom: 12,
                zoomControl: true,
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
        }


<?php } else { ?>

        lat = 39.937119;
        lng = -99.096468;
        zoom = 4;
         var iconBase = '<?= asset('userassets/images/icons') ?>/';
        function initMap() { 
            var location = {lat: <?= $current_user->lat ?>,
                lng: <?= $current_user->lng ?>};

            var map = new google.maps.Map(document.getElementById('map'), {
                center: location,
                zoom: zoom,
                zoomControl: true,
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
         var marker = new google.maps.Marker({
                    position: location,
                    icon: iconBase + 'marker.png',
                    map: map,
                    title: 'Current location'
                });
        }

<?php } ?>
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&callback=initMap" async defer></script>
</body>
</html>