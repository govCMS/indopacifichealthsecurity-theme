(function ($) {
	Drupal.behaviors.gov_google_map = {
	    attach: function (context, settings) {
	    	
	    	var maps = settings.gov_google_map;
	    	var markers = [];
		    
		    for (i in maps) {
		       var current_map = settings['id' + maps[i]];
		       var map_id = current_map.id;
		       var map_locations = current_map.locations;
		       var map_style = (current_map.style != '' ? current_map.style : '[]');

		       var infoBubble = new InfoBubble({
	            shadowStyle: 0,
	            padding: 13,
	            borderRadius: 7,
	            borderWidth: 1,
	            borderColor: '#cccccc',
	            backgroundColor: '#ffffff',
	            minWidth: 'auto',
	            maxWidth: 'auto',
	            maxHeight: 'auto',
	            minHeight: 'auto',
	            arrowStyle: 0,
	            arrowSize: 10,
	            arrowPosition: 50,
	            disableAutoPan: 0,
	            disableAnimation: 1,
	            hideCloseButton: 0,
	            backgroundClassName: 'sgmpopup-content',
	          });

		       // Set extra custom classes for easy styling.
	          infoBubble.bubble_.className = 'sgmpopup sgmpopup-';
	          // infoBubble.close_.src = map_settings.style.active_pin;
	          infoBubble.contentContainer_.className = 'sgmpopup-content-wrapper';
	          infoBubble.arrow_.className = 'sgmpopup-arrow';
	          infoBubble.arrowOuter_.className = 'sgmpopup-arrow-outer';
	          infoBubble.arrowInner_.className = 'sgmpopup-arrow-inner';

		       if ($('#' + map_id).length) {
		       		var bounds = new google.maps.LatLngBounds();
			          var map_types = {
			            'ROADMAP': google.maps.MapTypeId.ROADMAP,
			            'SATELLITE': google.maps.MapTypeId.SATELLITE,
			            'HYBRID': google.maps.MapTypeId.HYBRID,
			            'TERRAIN': google.maps.MapTypeId.TERRAIN
			          }

			      var init_map = {
		            zoom: 4,
		            mapTypeId: google.maps.MapTypeId.ROADMAP,
		            // disableDefaultUI: !map_settings.ui,
		            maxZoom: 20,
		            minZoom: 3,
		            styles: JSON.parse(map_style),
		            mapTypeControl: false,
		            scaleControl: true,
		            rotateControl: false,
		            streetViewControl: false,
		            zoomControl: true,
		            scrollwheel: true,
		            draggable: true
		          }

		          var map = new google.maps.Map(document.getElementById(map_id), init_map);
		          
		          for (j in map_locations) {
		          		
			          	var marker = new google.maps.Marker({
			              position: new google.maps.LatLng( parseFloat(map_locations[j].location.latitude) , parseFloat(map_locations[j].location.longitude) ),
			              map: map,
			              html: map_locations[j].popup,
			              icon: map_locations[j].pin,
			              original_icon: map_locations[j].pin,
			              active_icon: map_locations[j].pin,
			            });

			            // markers.push(marker);

			            if (map_locations[j].popup) {

			              google.maps.event.addListener(marker, 'click', (function(map){

			                  return function() {

			                      infoBubble.setContent(this.html);
			                      for (var i = 0; i < markers.length; i++) {
			                         markers[i].setIcon(markers[i].original_icon);
			                      }
			                      this.setIcon(this.active_icon);
			                      infoBubble.open(map, this);
			                  };
			              }(map)) );
			            }
			            
			            bounds.extend(marker.getPosition());

		          }
		          map.setCenter(bounds.getCenter());
			      map.fitBounds(bounds);
		       }
		    }
	    }
	};
})(jQuery);