const AWS = require("aws-sdk");
const s3 = new AWS.S3();
const turf = require("@turf/turf");

function main(event, context, callback){
  const now = new Date().toISOString().split("T")[0];
  const yesterday = getYesterday();
  const nowParams = getExistingPerimiterParams(now);
  const thenParams = getExistingPerimiterParams(yesterday);
  let nowData;
  let thenData;
  const differences = [];
  getObject(s3, nowParams)
    .then((data)=>{
      nowData = data;
      console.log('got data for: ', now);
      return getObject(s3, thenParams)
    })
    .then((data)=>{
      thenData = data;
      console.log('got data for: ', yesterday)
      //need to match up the perimiters by fireid
      const currentPerimiters = buildFeatureHashMap(nowData);
      const pastPerimiters = buildFeatureHashMap(thenData);

      for (let fireid in currentPerimiters){
        console.log(fireid)
        const _currentPerim = currentPerimiters[fireid];
        const _pastPerim = pastPerimiters[fireid];
        const difference = perimiterDifference(_pastPerim, _currentPerim);
        if (difference){
          console.log("Adding new difference")
          differences.push(difference);
        }

      }
      const differenceFeatureCollection ={
        type:'FeatureCollection',
        features: differences
      }
      console.log(JSON.stringify(differenceFeatureCollection))
      putDifferencesToS3(now, differenceFeatureCollection)
    })
    .catch((err)=>{
      throw err;
    })
}


function buildFeatureHashMap(featureCollection){
  const hashMap = {};
  featureCollection.features.forEach((feature)=>{
    const featureID = feature.properties.id;
    hashMap[featureID] = feature;
  })
  return hashMap
}

function getObject(s3, params){
  return new Promise((resolve, reject)=>{
      s3.getObject(params, (err, res)=>{
        if (err) return reject(err);
        // console.log(res)
        return resolve(JSON.parse(res.Body));
      })
  })
}

function perimiterDifference(oldPerim, newPerim){
  const perimProperties = newPerim.properties;

  let difference;
  if (!oldPerim){
    difference = newPerim //it's new, nothing to difference
  }else{
    try{
      difference = turf.difference(newPerim.geometry, oldPerim.geometry);
    }catch(err){
      console.log('[WARNING] Passing invalid geometry: ', err.toString())
      return null
    }

  }
  if (!difference) return null;

  difference.properties = getDifferenceProperties(difference, perimProperties);
  return difference
}

function getExistingPerimiterParams(perimiterDate){
  const params = {
    Bucket: 'firesphere',
    Key: `perimiters/geomac/${perimiterDate}.geojson`
  }
  return params;
}

function putDifferencesToS3(s3, analysisDate, differenceGeojson){
  const params = {
    Bucket: 'firesphere',
    Key: `perimiers/difference/${analysisDate}.geojson`,
    Body: JSON.stringify(differenceGeojson)
  }
  // return new Promise((resolve, reject)=>{
  //   s3.putObject(params, (err, res)=>{
  //
  //   })
  // })
  return params;
}

function getDifferenceProperties(differencePolygon, existingProps){
  const props = {
    area: turf.area(differencePolygon),
    commonName: existingProps.commonName,
    lastUpdatedDate: existingProps.lastUpdatedDate,
    lastUpdatedTime: existingProps.lastUpdatedTime,
    id: existingProps.id
  }
  return props
}


function getYesterday(){
  const yesterday = new Date();
  yesterday.setDate(yesterday.getDate()-1);

  return yesterday.toISOString().split("T")[0];
}

if (require.main === module){
  main()
}
