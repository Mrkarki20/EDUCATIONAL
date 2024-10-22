# admin_panel.py
from django.shortcuts import render
from django.http.response import HttpResponse
import os
import boto3

# Create an S3 client
s3_client = boto3.client(
    's3',
    aws_access_key_id='YOUR_ACCESS_KEY_ID',
    aws_secret_access_key='YOUR_SECRET_ACCESS_KEY',
    region_name='ca-central-1'
)

# Define a view for the admin panel
def admin_panel(request):
    if request.method == 'POST':
        subject = request.POST['subject']
        portion = request.POST['portion']
        chapter = request.POST['chapter']
        notes = request.FILES['notes']

        # Upload notes to S3 bucket
        file_location = f'{subject}/{portion}/{chapter}/{notes.name}'
        s3_client.put_object(
            Bucket='student-uploads',
            Key=file_location,
            Body=notes
        )

        return HttpResponse('Notes uploaded successfully!')
    else:
        return render(request, 'admin_panel.html')

# Create an HTML template for the admin panel
<!-- admin_panel.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <form id="upload-form">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject"><br><br>
        <label for="portion">Portion:</label>
        <input type="text" id="portion" name="portion"><br><br>
        <label for="chapter">Chapter:</label>
        <input type="text" id="chapter" name="chapter"><br><br>
        <label for="notes">Notes:</label>
        <input type="file" id="notes" name="notes"><br><br>
        <button id="upload-btn">Upload Notes</button>
    </form>
</body>
</html>