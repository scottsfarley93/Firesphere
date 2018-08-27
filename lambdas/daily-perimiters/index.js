const fs = require("fs");
const request = require("request");
const convert = require('@mapbox/togeojson');
const DOMParser = require('xmldom').DOMParser;
const AWS = require("aws-sdk");
const s3 = new AWS.S3();
const md5 = require("md5");
const turf = require("@turf/turf");

const perimiterEndpoint = "https://rmgsc.cr.usgs.gov/outgoing/GeoMAC/ActiveFirePerimeters.kml"

function main(event, context, callback){
  requestPerimiters()
    .then((kmlPerimiters)=>{
      console.log("[process] Got perimiters. Processing...")
        const seen = [];
        try{
          const geojsonPerimiters = kml2Geojson(kmlPerimiters);
        }catch((err)=>{
          return callback(err, null)
        })
        let perimeters = geojsonPerimiters.features.map((feature)=>{
          let nameComponents = feature.properties.name.split(" ")
          feature.properties.id = nameComponents[0]
          const AM = nameComponents.pop();
          const time = nameComponents.pop();
          feature.properties.lastUpdatedTime = time + " " + AM;
          feature.properties.lastUpdatedDate = nameComponents.pop();
          feature.properties.commonName = nameComponents.join(" ");
          feature.properties.lastUpdated = new Date(Date.parse(feature.properties.lastUpdatedDate + " " + feature.properties.lastUpdatedTime))
          feature.geometry.hash = md5(feature.geometry);
          delete feature.properties.styleUrl;
          delete feature.properties.styleHash;
          delete feature.properties.description;
          delete feature.properties['stroke-width'];
          delete feature.properties['fill-opacity'];
          delete feature.properties['styleMapHash'];
          feature.properties.area = turf.area(feature) * 0.000247105; //acres
          console.log(feature)
          return feature
        }).filter((feature)=>{
          return feature.geometry.type != "Point"
        })
        const fileParams = getS3FileParams(geojsonPerimiters);
        console.log(fileParams)
        s3.putObject(fileParams, (err, res)=>{
          console.log(err, res)
          if (err) callback(err)
          console.log(JSON.stringify(res));
          callback(null, res)
        })
    })
    .catch((err)=>{
      throw err
      callback(err)
    })
}

function requestPerimiters(){
  return new Promise((resolve, reject)=>{
    request(perimiterEndpoint, (err, res)=>{
      if (err) return reject(err);
      const kml = res.body;
      return resolve(kml);
    })
  })
}

function kml2Geojson(kml){
  const tree = new DOMParser().parseFromString(kml, 'text/xml')
  const geojson = convert.kml(tree);
  return geojson;
}

function getS3FileParams(body){
  const today = new Date().toISOString().split("T")[0];
  const key = `perimiters/geomac/${today}.geojson`
  let params = {
    Bucket: 'firesphere',
    Key: key,
    Body: JSON.stringify(body)
  }
  return params;
}

module.exports = {
  main
}
