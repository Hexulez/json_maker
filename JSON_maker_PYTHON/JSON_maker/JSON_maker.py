# -*- coding: utf-8 -*-

import pandas as pd
import json

# Load the Excel file into a pandas DataFrame
df = pd.read_excel('Pelaajaluettelo.xlsx')

tokenId = int(input('Enter the starting tokenId: '))
imagelocation = str(input('Enter the image location folder: '))
description = str(input('Enter the description: '))

# Loop through the rows of the DataFrame and create a JSON file for each row
for index, row in df.iterrows():
    # Extract the values from the row
    image = imagelocation + '/' + str(tokenId) + '.png' 
    number = row['Number']
    surname = row['Surname']
    firstName = row['First Name']
    position = row['Position']
    rarity = row['Rarity']
    collection = row['Collection']
    name = collection + ' ' + surname + ' ' + str(number) + ' ' + rarity

    # Create a dictionary representing the JSON data
    data = {
        "image": image,
        "tokenId": tokenId,
        "name": name,
        "description": description,
        "attributes": [
            {
                "trait_type": "Number",
                "value": number
            },
            {
                "trait_type": "Surname",
                "value": surname
            },
            {
                "trait_type": "First Name",
                "value": firstName
            },
            {
                "trait_type": "Position",
                "value": position
            },
            {
                "trait_type": "Rarity",
                "value": rarity
            },
            {
                "trait_type": "Collection",
                "value": collection
            }
        ]
    }
    
    # Save the dictionary as a JSON file
    with open(f'{tokenId}.json', 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False)

    tokenId += 1
