from datetime import datetime
import os

bbox = [-124.45312499999999, 39.18117526158749, -119.90478515625, 42.09822241118974]
start = datetime(2018, 3, 1, 0, 0, 0)
end  = datetime.now()
delta = 30 ## days

current_dir = os.path.dirname(os.path.realpath(__file__))
write_dir = os.path.join(current_dir, './../../data/')

token = "81c6390c31ee4277ad2082c748d2fc89"
