import time, requests, random, hashlib

while True:
    #Updates wind speed to a random value
    randwind = round(random.uniform(0.01,2), 1)

    #use api to get average wind speed
    json = requests.get('http://localhost/project/accesspoint/generaldata.php').json()
    windAVG = json[0]
    print("Generated wind: ",randwind, " new wind avg is: ",windAVG)
    
    
    #authenticate and update buffer,price,wind etc
    requests.post('http://localhost/project/accesspoint/updateBuffer.php?wind='+str(randwind)+'&user='+'Karla2'+'&pass='+'eUf8KDYesvij75mLG3AyQw==')
    
    userjson = requests.get('http://localhost/project/accesspoint/userdata.php?user='+'Karla2'+'&pass='+'eUf8KDYesvij75mLG3AyQw==').json()
    print(userjson)
    
    
    time.sleep(2)
  