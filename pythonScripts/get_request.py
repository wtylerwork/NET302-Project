import json
import requests
import configparser
import sys
import pymongo

api_token = 'a1772b5eb4516dca799fa31e7482ac70'
api_url_base = 'http://api.openweathermap.org/data/2.5/'
city = 'Plymouth'
parameters = 'q={0},UK&appid={1}'.format(city,api_token)

headers = {'Content-Type': 'application/json', 'Authorisation': 'Bearer {0}'.format(api_token)}

def get_weather_data():
    api_url = '{0}weather?{1}'.format(api_url_base,parameters)
    response = requests.get(api_url, headers=headers)
    if response.status_code == 200:
        return json.loads(response.content.decode('utf-8'))
    else:
        return None

weather_data = get_weather_data()

if weather_data is not None:
    print("Heres your data: ")
    for k, v in weather_data.items():
        print('{0}:{1}'.format(k, v))

else:
    print('[!] Request Failed')

