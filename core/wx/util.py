MAX_DURATION = 100000
from datetime import datetime
from math import radians, cos, sin, asin, sqrt

def format_date_for_service(date):
    return datetime.strftime(date, '%Y%m%d%H%M')

def validate_duration(date1, date2, MAX_DURATION=MAX_DURATION):
    """
    Ensures that the duration is less than the maximum duration allowed by the api service
    """
    delta = date2 - date1
    delta_seconds = delta.seconds
    delta_days = delta.days
    delta_hours = delta_days * 24
    delta_hours += delta_seconds / (60 * 60)
    assert abs(delta_hours) < MAX_DURATION, "Duration execeeded MAX_DURATION of " + str(MAX_DURATION)


def get_weather_service_wrapper(token):
    from MesoPy import Meso
    m = Meso(token=token)
    return m

def haversine(coordsA, coordsB):
    """
    Calculate the great circle distance between two points
    on the earth (specified in decimal degrees)
    """

    lon1, lat1 = coordsA
    lon2, lat2 = coordsB
    # convert decimal degrees to radians
    lon1, lat1, lon2, lat2 = map(radians, [lon1, lat1, lon2, lat2])

    # haversine formula
    dlon = lon2 - lon1
    dlat = lat2 - lat1
    a = sin(dlat/2)**2 + cos(lat1) * cos(lat2) * sin(dlon/2)**2
    c = 2 * asin(sqrt(a))
    r = 6371 # Radius of earth in kilometers. Use 3956 for miles
    return c * r
