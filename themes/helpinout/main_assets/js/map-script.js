WebFont.load({
   custom: {
     families: ["vectormap-icons"],
     urls: ["https://cdn.thinkgeo.com/vectormap-icons/1.0.0/vectormap-icons.css"]
   }
 });



var worldstreetsStyle = "https://cdn.thinkgeo.com/worldstreets-styles/1.0.0/light.json";    
var worldstreets = new ol.mapsuite.VectorTileLayer(worldstreetsStyle, 
                                                   {
  // Notice： please remove the APIKEY if you want publish this sample to client, the following key is created for develop VectorMap-JS.
  apiKey:'WPLmkj3P39OPectosnM1jRgDixwlti71l8KYxyfP2P0~'
});

let map = new ol.Map({
  layers: [worldstreets],
  target: 'map',
  view: new ol.View({
    center: ol.proj.fromLonLat([80.79620, 22.79423]),
    zoom: 4,
  }),
});