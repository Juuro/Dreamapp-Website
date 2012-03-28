// Javascript functions for the Google Maps plugin

function resizeMap( map, points ) {
  var minLong = 999;
  var minLat = 999;
  var maxLong = -999;
  var maxLat = -999;
  
  // Get the current map width/height
  var size = map.getSpanLatLng();
  var mapWidth = size.width;
  var mapHeight = size.height;
  var baseWidth = mapWidth;
  var baseHeight = mapHeight;
  
  // Figure out the elemental unit (depends on the size of the map)
  // You will need to re-run resizeMap() if the size of the map changes.
  if ( map.getZoomLevel() > 0 ) {
    baseWidth /= Math.pow( 2, map.getZoomLevel() );
    baseHeight /= Math.pow( 2, map.getZoomLevel() );
  }
  
  // Find the max/min points
  for ( var i = 0; i < points.length; i++ ) {
    if ( points[i].x < minLong ) minLong = points[i].x;
    if ( points[i].x > maxLong ) maxLong = points[i].x;
    if ( points[i].y < minLat ) minLat = points[i].y;
    if ( points[i].y > maxLat ) maxLat = points[i].y;
  }
  
  // Find the optimal Width Zoom
  var wZoom = 0;
  var w = Math.abs( maxLong - minLong );
  for ( var i = 1; i < 16; i++ ) {
    if ( baseWidth > w ) break;
    baseWidth *= 2;
    wZoom = i;
  }
  
  // Find the optimal Height Zoom
  var hZoom = 0;
  var h = Math.abs( maxLat - minLat );
  for ( var i = 1; i < 16; i++ ) {
    if ( baseHeight > h ) break;
    baseHeight *= 2;
    hZoom = i;
  }
  
  // Reposition
  map.centerAndZoom(
    new GPoint( ( minLong + maxLong ) / 2, ( minLat + maxLat ) / 2 ),
    ( wZoom > hZoom ? wZoom : hZoom )
  );
}

function vtoggle(x) {
	var xTog = document.getElementById(x);
	var xIndex = xTog.style.visibility;
	if (xIndex == 'hidden') { 
		xIndex = 'visible'; 
		xTog.style.position='relative';
		xTog.style.left='auto';
		xTog.style.top='auto';
		if(!map) {
			showmap();
		}
		map.checkResize();
	} else { 
		xIndex = 'hidden'; 
		xTog.style.position='absolute';
		xTog.style.left='-3000px';
		xTog.style.top='-3000px';
	}
	xTog.style.visibility = xIndex;
}
