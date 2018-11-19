from util import get_weather_service_wrapper
from download import get_station_metadata, get_station_list_from_bbox
import os
from config import *
from geopy import distance
import pandas as pd


def get_nearest_stations(service, station_id, n):
    """
    return the N closest stations to the given station
    """
    station_list = service.metadata(bbox=bbox)['STATION']
    center_station = get_station_metadata(service, station_id)[0]
    center_coords = get_coords(center_station)
    distances = []
    for station in station_list:
        station_coords = get_coords(station)
        distance_to_station = distance.distance(center_coords, station_coords)
        distances.append(distance_to_station)
    return_stations = []
    i = 0
    while i < n:
        if len(station_list) > 0:
            min_distance = min(distances)
            min_idx = distances.index(min_distance)
            min_station = station_list.pop(min_idx)['STID']
            if min_station == station_id:
                continue
            ### check if the data exists for that station
            if not os.path.exists( os.path.join(write_dir, min_station + ".csv")):
                continue
            try:
                pd.read_csv(os.path.join(write_dir, min_station + ".csv")).air_temp_set_1
            except:
                continue
            distances.pop(min_idx)
            return_stations.append((min_station, min_distance))
        i += 1
    return return_stations

def get_coords(station_metadata):
    location = [float(station_metadata['LATITUDE']), float(station_metadata['LONGITUDE'])]
    return location


def read_values(station_id):
    """
    Read a csv in preparation for analysis
    """
    data_path = os.path.join(write_dir, station_id + ".csv")
    series = pd.read_csv(data_path)

    ## turn date into a date
    series.date_time = pd.to_datetime(series.date_time)
    series.index = series.date_time

    series = ensure_time_distribution(series)
    return series



def ensure_time_distribution(df):
    """Resample the data frame so that the required time slices are present for analysis"""
    df = df.resample('60T', label='right').mean()
    return df


def assemble_nearest_values_for_interpolation(service, station_id, n):
    y_field = 'air_temp_set_1'
    x_fields = ['air_temp_set_1', '_meta_elevation']
    interpolation_data = pd.DataFrame()
    response = read_values(station_id)

    ## add some extra source data
    interpolation_data['y'] = response[y_field]
    interpolation_data['hour'] = response.index.hour
    interpolation_data['doy'] = response.index.dayofyear
    interpolation_data['elevation'] = response._meta_elevation
    interpolation_data['latitude'] = response._meta_latitude
    interpolation_data['longitude'] = response._meta_longitude
    station_distance_idx = 1
    for station in get_nearest_stations(service, station_id, n):
        near_station_id = station[0]
        station_distance = station[1]
        try:
            near_station_values = read_values(near_station_id)
            # near_station_values['distance'] = station_distance
            ## assembly the values together
            for x in x_fields:
                key = x + "_" + str(station_distance_idx)
                interpolation_data[key] = near_station_values[x]
            station_distance_idx += 1
        except FileNotFoundError as e:
            print (str(e))
            pass
    interpolation_data = interpolation_data.dropna()
    return interpolation_data

def assemble_interpolation_training_data(service, n_neighbors):
    stations = get_station_list_from_bbox(service, bbox)
    full_df = pd.DataFrame()
    for station in stations:
        try:
            if os.path.exists( os.path.join(write_dir, station + ".csv")):
                station_values = assemble_nearest_values_for_interpolation(service, station, n_neighbors)
                full_df = full_df.append(station_values)
        except:
            pass
    return full_df



if __name__ == "__main__":
    service = get_weather_service_wrapper(token)
    training_data = assemble_interpolation_training_data(service, 5)
    full_path = os.path.join(write_dir, 'training_data_sept.csv')
    training_data.to_csv(full_path)
