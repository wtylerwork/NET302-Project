import json
import requests
import configparser
import sys
import pymongo
from time import mktime
from datetime import datetime
from geopy import Nominatim
from bson import json_util

#Time Details
datetime = datetime.now()
unixtime = mktime(datetime.timetuple())

#API URL details
api_token = 'a1772b5eb4516dca799fa31e7482ac70'
api_url_base = 'http://api.openweathermap.org/data/2.5/'
locname = sys.argv[1]
geolocator = Nominatim(user_agent="WTNET302")
location = geolocator.geocode(locname+",UK")
lat=location.latitude
lon=location.longitude
parameters = 'lat={0}&lon={1}&exclude=current,minutely,hourly,alerts&units=metric&appid={2}'.format(lat,lon,api_token)
headers = {'Content-Type': 'application/json', 'Authorisation': 'Bearer {0}'.format(api_token)}

#Database connection details
myClient = pymongo.MongoClient('mongodb://NET302Admin:NET302@54.87.27.24:27017')
mydb = myClient["NET302DB"]
mycol = mydb[locname]

#Sends a request to the API for data
def get_weather_data():
    api_url = '{0}onecall?{1}'.format(api_url_base,parameters)
    response = requests.get(api_url, headers=headers)
    if response.status_code == 200:
        return json.loads(response.content.decode('utf-8'))
    else:
        return None

#Outputs the Nested JSON file retrieved from the API
weather_data = get_weather_data()
weather_data['timecreated'] = unixtime
print(weather_data)

#Converts the Nested JSON File to BSON and stores in mongoDB 
JsonToJstring = json.dumps(weather_data)
JstringToBson = json_util.loads(JsonToJstring)
mycol.insert_one(JstringToBson)
