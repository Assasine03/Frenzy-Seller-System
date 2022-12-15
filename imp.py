import requests
from requests.structures import CaseInsensitiveDict

url = "https://api.maplestory.gg/v2/public/character/ems/Mitsuki0"

headers = CaseInsensitiveDict()
headers["Accept"] = "application/json"


resp = requests.get(url, headers=headers)

print(resp.status_code)