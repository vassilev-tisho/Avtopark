/*
 Params:

 @param mapDomEl | required | Dom element, which will hold the map.
 @param center | An object containing lat and lng prop, pointing to the default center of the map.
 @param onRouteSuccess | A callback function, called, when a route is successfully found.
 @param onRouteFail | A callback function, called to handle failure of finding route.
 */
var routeControl = function (controlOptions) {
    /*
     ______________________________
     Definition of inner properties
     ______________________________
     */
    var _labels = ['A', 'B'],
        _pointIndexes = {
            A: 0,
            B: 1
        },
        _points = [],
        _directionsService = new google.maps.DirectionsService,
        _geocoder = new google.maps.Geocoder(),
        _directionsDisplay = null,
        _caclulatingDistance = false;

    (function validateParams () {
        controlOptions.mapDomEl = controlOptions.mapDomEl || console.error('Map dom element is not provided');
        controlOptions.onRouteSuccess = controlOptions.onRouteSuccess || function () {};
        controlOptions.onRouteFail = controlOptions.onRouteFail || function () {};
        controlOptions.center = controlOptions.center || {
                lat: 0.00,
                lng: 0.00
            };
    })();

    /*
     _________________________
     Initialization of the map
     _________________________
     */

    var map = new google.maps.Map(controlOptions.mapDomEl, {
        zoom: 6,
        center: controlOptions.center
    });

    map.addListener('mousedown', function (event) {
        addPoint(new google.maps.Marker({
            position: event.latLng,
            optimized : true,
            draggable: true
        }))
    });

    /*
     ______________________________
     Definition of member functions
     ______________________________
     */

    var arePointSelectionsValid = function () {
        return Boolean(
            _points[0] instanceof google.maps.Marker &&
            _points[1] instanceof google.maps.Marker
        );
    }

    var addPoint = function (newMarker, newMarkerIndex) {
        if (_caclulatingDistance) {
            return;
        }

        newMarkerIndex = newMarkerIndex || _points.length;

        if (newMarkerIndex < 2) {
            var existingMarker = _points[newMarkerIndex];

            if (existingMarker) {
                existingMarker.setPosition(newMarker.getPosition());
            } else {
                _points[newMarkerIndex] = newMarker;
                newMarker.setMap(map)
                newMarker.addListener('dragend', calcRoute);
            }

            newMarker.setLabel(_labels[newMarkerIndex]);
            calcRoute();
        }
    }

    var calcRoute = function () {
        if (!arePointSelectionsValid() || _caclulatingDistance) {
            return
        }

        if (_directionsDisplay) {
            _directionsDisplay.setMap(null);
        }

        _caclulatingDistance = true;

        _directionsService.route({
            origin: _points[0].position,
            destination: _points[1].position,
            travelMode: 'DRIVING',
            transitOptions: {
                modes: ['BUS']
            },
            drivingOptions: {
                departureTime: new Date(),
                trafficModel: 'pessimistic'
            }
        }, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                _directionsDisplay = new google.maps.DirectionsRenderer({
                    suppressMarkers: true,
                    map: map,
                    directions: response,
                    draggable: false,
                    suppressPolylines: false,

                });

                var leg = response.routes[0].legs[0];

                controlOptions.onRouteSuccess({
                    addressA: leg.start_address,
                    addressB: leg.end_address,
                    distanceInMeters: leg.distance,
                    timeInSeconds: leg.duration
                });

                _points[0].setPosition(leg.start_location);
                _points[1].setPosition(leg.end_location);
            } else {
                _directionsDisplay && _directionsDisplay.setMap(null);
                controlOptions.onRouteFail();
            }

            _caclulatingDistance = false;
        });
    }

    var setPointAddress = function (address, pointIndex) {
        if (_caclulatingDistance) {
            return;
        }

        if ([0, 1].indexOf(pointIndex) < 0) {
            console.error('Point index should be 0 or 1.');
            return;
        }

        if (address.length === 0) {
            console.warn('No address was provided for point ' + _labels[pointIndex]);
            return;
        }

        _geocoder.geocode({ 'address': address }, function (results, status) {
            if (status == 'OK') {
                var pointLocation = results[0].geometry.location;
                if (_points[pointIndex]) {
                    _points[pointIndex].setPosition(pointLocation);
                    calcRoute();
                } else {
                    addPoint(new google.maps.Marker({
                        position: pointLocation,
                        optimized : true,
                        draggable: true
                    }), pointIndex);
                }

            } else {
                _directionsDisplay && _directionsDisplay.setMap(null);
                controlOptions.onRouteFail();
            }
        });
    }

    return {
        pointIndexes: _pointIndexes,
        setAddress: setPointAddress
    };
}