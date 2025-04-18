#!/usr/bin/env python3

import os
import json

def get_image_paths(directory):
    image_paths = {}

    for root, dirs, files in os.walk(directory):
        images_in_directory = [f for f in files if f.lower().endswith(('.png', '.jpg', '.jpeg', '.gif', '.bmp'))]
        if images_in_directory:
            category = os.path.basename(root)
            image_paths[category] = []
            for image in images_in_directory:
                image_path = os.path.join(root, image)
                relative_path = os.path.relpath(image_path, start=directory)
                full_path = os.path.join("autres/repertoire", relative_path)
                image_paths[category].append(full_path)
    return image_paths

def generate_json(directory, output_file):
    image_paths = get_image_paths(directory)

    with open(output_file, 'w', encoding='utf-8') as json_file:
        json.dump(image_paths, json_file, ensure_ascii=False, indent=4)
    print(f"Le fichier JSON a été généré : {os.path.abspath(output_file)}")

directory = 'repertoire/'
output_file = 'dataBase.json'

generate_json(directory, output_file)
