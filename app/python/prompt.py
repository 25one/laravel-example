#!/usr/bin/env python3
import sys
import json
from openai import OpenAI
from google import genai

try:
    pythonObject = json.loads(sys.argv[1])

    if (pythonObject['variantAI'] == 'OpenAI') :
        client = OpenAI(api_key = pythonObject['api_key'])

        response = client.responses.create(
            #model = "gpt-5.2", #дольше и длиннее, -1с
            #model = "gpt-4.1", #быстрее и короче, но все-равно -1с
            model = pythonObject['variantModel'],
            input = pythonObject['prompt']
        )
        print(response.output_text)
    
    elif (pythonObject['variantAI'] == 'GenAI') :
        client = genai.Client(api_key = pythonObject['api_key'])

        response = client.models.generate_content(
            #...
            #model = 'gemini-2.5-flash',
            model = pythonObject['variantModel'],
            contents = pythonObject["prompt"]
        )
        print(response.text)  

except Exception as e:
    # Создаем словарь с данными об ошибке


    error_data = {
        "errorPython": {
        #"data": {
            #"type": e.__class__.__name__,
            "message": str(e),
            #"status": 500
        }
    }
    # Конвертируем в JSON
    json_error = json.dumps(error_data)
    print(json_error)
