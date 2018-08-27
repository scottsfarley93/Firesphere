from datetime import datetime
import pandas as pd
import os
from util import get_weather_service_wrapper, validate_duration, format_date_for_service
from config import *


def get_station_list_from_bbox(service, bbox):
    response = service.metadata(bbox=bbox)
    stations = response['STATION']
    station_list = [station['STID'] for station in stations]
    return station_list

def get_station_metadata(service, station_id):
    station_meta = service.metadata(stid=station_id)
    return station_meta['STATION']

def get_station_timeseries(service, station_id, start, stop):
    # validate_duration(start, stop)
    start_time = format_date_for_service(start)
    end_time = format_date_for_service(stop)
    station_data = service.timeseries(stid=station_id, start=start_time, end=end_time)
    if station_data is None:
        return
    assert len(station_data['STATION']) == 1, "Must return only one station"
    obs = station_data['STATION'][0]['OBSERVATIONS']
    obs_df = pd.DataFrame.from_dict(obs)
    ## set time components
    obs_df.date_time = pd.to_datetime(obs_df['date_time'])
    ## set metaata
    station_meta = station_data["STATION"][0]
    obs_df["_meta_station_id"] = station_id
    obs_df['_meta_elevation'] = station_meta["ELEVATION"]
    obs_df['_meta_longitude'] = station_meta["LONGITUDE"]
    obs_df['_meta_latitude'] = station_meta["LATITUDE"]
    return obs_df


def download_bbox(bbox, start, end, token=token):
    service = get_weather_service_wrapper(token)
    station_list = get_station_list_from_bbox(service, bbox)
    validate_duration(start, end)
    for stationid in station_list:
        station_obs = get_station_timeseries(service, stationid, start, end)
        full_path = os.path.join(write_dir, stationid + ".csv")
        if station_obs is not None:
            station_obs.to_csv(full_path)
            print ("[working] Wrote file: ", full_path, " with ", len(station_obs.index), " observations")
        else:
            print("Failed to find observations for: ", stationid, " during requested time period.")
    print("[finished]")

if __name__ == "__main__":
    download_bbox(bbox, start, end)
