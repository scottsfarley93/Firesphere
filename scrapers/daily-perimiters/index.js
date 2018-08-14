const fs = require("fs");
const request = require("request");
const convert = require('@mapbox/togeojson');
const DOMParser = require('xmldom').DOMParser;
const AWS = require("aws-sdk");
const s3 = new AWS.S3();

const perimiterEndpoint = "https://rmgsc.cr.usgs.gov/outgoing/GeoMAC/ActiveFirePerimeters.kml"

function main(event, context, callback){
  requestPerimiters()
    .then((kmlPerimiters)=>{
        const geojsonPerimiters = kml2Geojson(kmlPerimiters);
        const fileParams = getS3FileParams(geojsonPerimiters);
        s3.putObject(fileParams, (err, res)=>{
          if (err) callback(err)
          console.log(JSON.stringify(res));
          callback(null, res)
        })
    })
    .catch((err)=>{
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
  const tree = new DOMParser().parseFromString(kml)
  const geojson = convert.kml(kml);
  return tree;
}

function getS3FileParams(body){
  const today = new Date().toISOString().split("T")[0];
  const key = `perimiters/geomac/${now}.geojson`
  let params = {
    Bucket: 'firesphere',
    Key: key,
    Body: JSON.stringify(today)
  }
  return key;
}

if (require.main == module){
  main();
}
